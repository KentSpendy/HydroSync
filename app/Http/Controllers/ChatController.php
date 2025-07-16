<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;
use App\Models\Expense;
use App\Models\ChatHistory;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat.index');
    }

    public function getHistory(Request $request)
    {
        $sessionId = $request->input('session_id');
        
        if (!$sessionId) {
            return response()->json([
                'success' => false,
                'error' => 'Session ID required'
            ], 400);
        }

        $history = ChatHistory::forSession($sessionId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($chat) {
                return [
                    'id' => $chat->id,
                    'message' => $chat->message,
                    'role' => $chat->role,
                    'timestamp' => $chat->created_at->format('H:i')
                ];
            });

        return response()->json([
            'success' => true,
            'history' => $history
        ]);
    }

    public function getSessions()
    {
        $sessions = ChatHistory::select('session_id')
            ->selectRaw('MAX(created_at) as last_activity')
            ->selectRaw('MIN(created_at) as first_activity')
            ->selectRaw('COUNT(*) as message_count')
            ->groupBy('session_id')
            ->orderBy('last_activity', 'desc')
            ->take(20)
            ->get()
            ->map(function ($session) {
                // Get the first user message to use as title
                $firstMessage = ChatHistory::where('session_id', $session->session_id)
                    ->where('role', 'user')
                    ->orderBy('created_at', 'asc')
                    ->first();
                
                $title = $firstMessage ? Str::limit($firstMessage->message, 50) : 'New Chat';
                
                return [
                    'session_id' => $session->session_id,
                    'title' => $title,
                    'last_activity' => Carbon::parse($session->last_activity)->diffForHumans(),
                    'message_count' => $session->message_count
                ];
            });

        return response()->json([
            'success' => true,
            'sessions' => $sessions
        ]);
    }

    public function deleteSession(Request $request)
    {
        $sessionId = $request->input('session_id');
        
        if (!$sessionId) {
            return response()->json([
                'success' => false,
                'error' => 'Session ID required'
            ], 400);
        }

        ChatHistory::where('session_id', $sessionId)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Session deleted successfully'
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'session_id' => 'required|string'
        ]);

        $sessionId = $request->input('session_id');
        $userMessage = $request->input('message');

        // Save user message to history
        ChatHistory::create([
            'session_id' => $sessionId,
            'message' => $userMessage,
            'role' => 'user'
        ]);

        // Check if API key exists
        $apiKey = env('GROQ_API_KEY');
        if (!$apiKey) {
            Log::error('GROQ_API_KEY not found in environment variables');
            return response()->json([
                'success' => false,
                'error' => 'API configuration error'
            ], 500);
        }

        try {
            // Get real-time database context
            $databaseContext = $this->getDatabaseContext();
            
            // Get conversation history for context
            $conversationHistory = $this->getConversationHistory($sessionId);
            
            Log::info('Making request to Groq API', [
                'message' => $userMessage,
                'session_id' => $sessionId,
                'api_key_length' => strlen($apiKey),
                'database_context_length' => strlen($databaseContext),
                'conversation_history_count' => count($conversationHistory)
            ]);

            // Prepare messages with conversation history
            $messages = [
                [
                    'role' => 'system',
                    'content' => 'You are a helpful AI assistant for a transaction tracking business. Help users with transaction queries, financial analysis, and business insights. Be professional, accurate, and concise.

Here is the current real-time database context you can reference:

' . $databaseContext . '

Use this data to provide accurate, data-driven responses about transactions, expenses, financial summaries, and business insights. Always base your answers on the actual data provided.'
                ]
            ];

            // Add conversation history (keep last 10 messages for context)
            $messages = array_merge($messages, array_slice($conversationHistory, -10));

            // Add current user message
            $messages[] = [
                'role' => 'user',
                'content' => $userMessage
            ];

            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ])->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.3-70b-versatile',
                    'messages' => $messages,
                    'max_tokens' => 1000,
                    'temperature' => 0.7,
                ]);

            Log::info('Groq API Response', [
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body_preview' => substr($response->body(), 0, 200)
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Check if response has expected structure
                if (!isset($data['choices'][0]['message']['content'])) {
                    Log::error('Unexpected API response structure', ['response' => $data]);
                    return response()->json([
                        'success' => false,
                        'error' => 'Invalid response format from AI'
                    ], 500);
                }

                $assistantMessage = $data['choices'][0]['message']['content'];

                // Save assistant response to history
                ChatHistory::create([
                    'session_id' => $sessionId,
                    'message' => $assistantMessage,
                    'role' => 'assistant'
                ]);

                return response()->json([
                    'success' => true,
                    'response' => $assistantMessage
                ]);
            } else {
                $errorBody = $response->body();
                $statusCode = $response->status();
                
                Log::error('Groq API Error', [
                    'status' => $statusCode,
                    'body' => $errorBody,
                    'headers' => $response->headers()
                ]);

                // Parse error message if available
                $errorMessage = 'Failed to get response from AI';
                try {
                    $errorData = $response->json();
                    if (isset($errorData['error']['message'])) {
                        $errorMessage = $errorData['error']['message'];
                    }
                } catch (\Exception $e) {
                    // If we can't parse JSON, use the raw body
                    $errorMessage = $errorBody ?: $errorMessage;
                }

                return response()->json([
                    'success' => false,
                    'error' => $errorMessage,
                    'debug' => [
                        'status' => $statusCode,
                        'api_available' => $this->checkGroqApiHealth()
                    ]
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Chat Error: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while processing your request: ' . $e->getMessage()
            ], 500);
        }
    }

    private function formatResponse($response)
    {
        // Clean up the response and ensure proper formatting
        $response = trim($response);
        
        // Convert markdown-style formatting to HTML
        $response = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $response);
        $response = preg_replace('/^\* (.+)$/m', '• $1', $response);
        $response = preg_replace('/^- (.+)$/m', '• $1', $response);
        
        // Format headers
        $response = preg_replace('/^### (.+)$/m', '<h3 class="text-lg font-semibold text-white mt-4 mb-2">$1</h3>', $response);
        $response = preg_replace('/^## (.+)$/m', '<h2 class="text-xl font-semibold text-white mt-4 mb-2">$1</h2>', $response);
        $response = preg_replace('/^# (.+)$/m', '<h1 class="text-2xl font-bold text-white mt-4 mb-2">$1</h1>', $response);
        
        // Format code blocks
        $response = preg_replace('/```(.*?)```/s', '<pre class="bg-black/20 rounded-lg p-3 my-2 overflow-x-auto"><code class="text-gray-200">$1</code></pre>', $response);
        $response = preg_replace('/`([^`]+)`/', '<code class="bg-black/20 px-2 py-1 rounded text-gray-200">$1</code>', $response);
        
        // Format line breaks properly
        $response = preg_replace('/\n\n/', '</p><p class="mb-3">', $response);
        $response = preg_replace('/\n/', '<br>', $response);
        
        // Wrap in paragraph tags
        $response = '<p class="mb-3">' . $response . '</p>';
        
        // Format bullet points with proper spacing
        $response = preg_replace('/• (.+?)(<br>|$)/', '<div class="flex items-start space-x-2 mb-1"><span class="text-blue-400 mt-1">•</span><span>$1</span></div>', $response);
        
        // Clean up any multiple spaces or empty paragraphs
        $response = preg_replace('/<p class="mb-3"><\/p>/', '', $response);
        $response = preg_replace('/\s+/', ' ', $response);
        
        // Format numbers and currency
        $response = preg_replace('/\$(\d+(?:,\d{3})*(?:\.\d{2})?)/', '<span class="text-green-400 font-medium">$$1</span>', $response);
        
        return $response;
    }

    private function getConversationHistory($sessionId)
    {
        return ChatHistory::forSession($sessionId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($chat) {
                return [
                    'role' => $chat->role,
                    'content' => $chat->message
                ];
            })
            ->toArray();
    }

    private function getDatabaseContext()
    {
        try {
            // Get recent transactions (last 50 or all if less)
            $transactions = Transaction::orderBy('created_at', 'desc')
                ->take(50)
                ->get();

            // Get recent expenses (last 50 or all if less)
            $expenses = Expense::orderBy('created_at', 'desc')
                ->take(50)
                ->get();

            // Calculate summaries
            $totalTransactionAmount = $transactions->sum('amount');
            $totalExpenseAmount = $expenses->sum('amount');
            $netAmount = $totalTransactionAmount - $totalExpenseAmount;

            // Group transactions by payment status
            $transactionsByStatus = $transactions->groupBy('payment_status');
            $paidAmount = $transactionsByStatus->get('paid', collect())->sum('amount');
            $pendingAmount = $transactionsByStatus->get('pending', collect())->sum('amount');

            // Group expenses by category
            $expensesByCategory = $expenses->groupBy('category');

            // Build context string
            $context = "=== REAL-TIME DATABASE SUMMARY ===\n\n";
            
            // Financial Summary
            $context .= "FINANCIAL SUMMARY:\n";
            $context .= "- Total Transaction Amount: $" . number_format($totalTransactionAmount, 2) . "\n";
            $context .= "- Total Expense Amount: $" . number_format($totalExpenseAmount, 2) . "\n";
            $context .= "- Net Amount: $" . number_format($netAmount, 2) . "\n";
            $context .= "- Paid Transactions: $" . number_format($paidAmount, 2) . "\n";
            $context .= "- Pending Transactions: $" . number_format($pendingAmount, 2) . "\n";
            $context .= "- Total Transactions Count: " . $transactions->count() . "\n";
            $context .= "- Total Expenses Count: " . $expenses->count() . "\n\n";

            // Recent Transactions
            $context .= "RECENT TRANSACTIONS:\n";
            foreach ($transactions->take(10) as $transaction) {
                $context .= "- {$transaction->customer_name}: {$transaction->order_details} | ";
                $context .= "Amount: $" . number_format($transaction->amount, 2) . " | ";
                $context .= "Status: {$transaction->payment_status} | ";
                $context .= "Group: {$transaction->delivery_group} | ";
                $context .= "Date: {$transaction->created_at->format('Y-m-d H:i')}\n";
            }

            // Recent Expenses
            $context .= "\nRECENT EXPENSES:\n";
            foreach ($expenses->take(10) as $expense) {
                $context .= "- {$expense->description} | ";
                $context .= "Category: {$expense->category} | ";
                $context .= "Amount: $" . number_format($expense->amount, 2) . " | ";
                $context .= "Date: {$expense->date}\n";
            }

            // Expense Categories Summary
            $context .= "\nEXPENSE CATEGORIES:\n";
            foreach ($expensesByCategory as $category => $categoryExpenses) {
                $categoryTotal = $categoryExpenses->sum('amount');
                $context .= "- {$category}: $" . number_format($categoryTotal, 2) . " ({$categoryExpenses->count()} items)\n";
            }

            // Payment Status Summary
            $context .= "\nPAYMENT STATUS BREAKDOWN:\n";
            foreach ($transactionsByStatus as $status => $statusTransactions) {
                $statusTotal = $statusTransactions->sum('amount');
                $context .= "- {$status}: $" . number_format($statusTotal, 2) . " ({$statusTransactions->count()} transactions)\n";
            }

            return $context;

        } catch (\Exception $e) {
            Log::error('Error getting database context: ' . $e->getMessage());
            return "Error retrieving database context. Please check the database connection.";
        }
    }

    private function checkGroqApiHealth()
    {
        try {
            $response = Http::timeout(5)->get('https://api.groq.com/openai/v1/models');
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}