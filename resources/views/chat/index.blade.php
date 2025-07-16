<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hydra AI Assistant</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e40af',
                        secondary: '#3b82f6',
                        accent: '#06b6d4',
                        dark: '#0f172a',
                        success: '#10b981',
                        warning: '#f59e0b',
                        error: '#ef4444',
                    }
                }
            }
        }
    </script>
    <style>
         /* Ensure full height layout */
        html, body {
            height: 100%;
            overflow: hidden;
        }

        /* Add this to your existing CSS styles */

/* Message content styling */
.message-content {
    line-height: 1.6;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.message-content h1,
.message-content h2,
.message-content h3 {
    margin-top: 1rem;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.message-content h1 {
    font-size: 1.25rem;
}

.message-content h2 {
    font-size: 1.125rem;
}

.message-content h3 {
    font-size: 1rem;
}

.message-content p {
    margin-bottom: 0.75rem;
}

.message-content p:last-child {
    margin-bottom: 0;
}

.message-content strong {
    font-weight: 600;
    color: #e2e8f0;
}

.message-content code {
    font-family: 'Courier New', monospace;
    font-size: 0.9em;
    background: rgba(0, 0, 0, 0.3);
    padding: 0.125rem 0.25rem;
    border-radius: 0.25rem;
    color: #f1f5f9;
}

.message-content pre {
    background: rgba(0, 0, 0, 0.4);
    padding: 0.75rem;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin: 0.5rem 0;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.message-content pre code {
    background: none;
    padding: 0;
    border-radius: 0;
    font-size: 0.875rem;
    color: #cbd5e1;
}

/* Bullet point styling */
.message-content .flex.items-start {
    margin-bottom: 0.25rem;
}

.message-content .flex.items-start:last-child {
    margin-bottom: 0;
}

/* Number and currency highlighting */
.message-content .text-green-400 {
    font-weight: 500;
    color: #34d399;
}

/* Improved spacing for lists */
.message-content ul {
    margin: 0.5rem 0;
    padding-left: 1rem;
}

.message-content li {
    margin-bottom: 0.25rem;
    color: #cbd5e1;
}

/* Better link styling if you add links later */
.message-content a {
    color: #60a5fa;
    text-decoration: underline;
    transition: color 0.2s;
}

.message-content a:hover {
    color: #93c5fd;
}

/* Ensure proper spacing in message bubbles */
.message-bubble {
    min-width: 100px;
    max-width: 85%;
}

.message-bubble.user {
    max-width: 70%;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .message-bubble {
        max-width: 90%;
    }
    
    .message-bubble.user {
        max-width: 85%;
    }
}
        /* Chat container with proper flex layout */
        .chat-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        /* Main chat area with proper flex layout */
        .main-chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 0; /* Important for flex child to shrink */
        }

        /* Fixed height for messages container */
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            min-height: 0; /* Important for flex child to shrink */
        }

        /* Custom scrollbar styling */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            border: 1px solid transparent;
            background-clip: padding-box;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        /* Message bubble styling */
        .message-bubble {
            max-width: 80%;
            word-wrap: break-word;
        }

        .message-bubble.user {
            margin-left: auto;
        }

        /* Glass effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Animations */
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .animate-slide-up {
            animation: slideUp 0.3s ease-out;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .typing-indicator {
            animation: pulse 1.5s infinite;
        }

        /* Sidebar styling */
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
            z-index: 10;
        }

        .session-item {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .session-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(4px);
        }

        .session-item.active {
            background: rgba(30, 64, 175, 0.3);
            border-left: 4px solid #3b82f6;
        }

        /* Input area - fixed height */
        .chat-input-area {
            flex-shrink: 0;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Quick actions - fixed height */
        .quick-actions-area {
            flex-shrink: 0;
            padding: 1.5rem;
            padding-top: 0;
        }
/* Fix scrolling layout */
.chat-container {
    height: 100vh;
    overflow: hidden;
}

.main-chat-area {
    height: 100vh;
    display: flex;
    flex-direction: column;
}

.chat-messages {
    flex: 1;
    min-height: 0;
    overflow-y: auto;
    overflow-x: hidden;
}
        /* Button animations */
        .quick-action {
            transition: all 0.3s ease;
        }

        .quick-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        /* Send button styling */
        #send-btn {
            transition: all 0.2s ease;
        }

        #send-btn:hover {
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        /* Loading spinner */
        .animate-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Message input styling */
        #message-input {
            transition: all 0.3s ease;
        }

        #message-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .chat-messages {
                padding: 1rem;
            }
            
            .message-bubble {
                max-width: 90%;
            }
            
            .sidebar-transition {
                transform: translateX(-100%);
            }
            
            .sidebar-transition.open {
                transform: translateX(0);
            }
        }

        /* Firefox scrollbar support */
        @supports (scrollbar-width: thin) {
            .custom-scrollbar {
                scrollbar-width: thin;
                scrollbar-color: rgba(255, 255, 255, 0.2) rgba(255, 255, 255, 0.05);
            }
        }

        /* Focus styles for accessibility */
        .quick-action:focus,
        #send-btn:focus,
        #message-input:focus,
        .session-item:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        
    </style>
</head>
<body class="h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 overflow-hidden">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div id="sidebar" class="w-80 bg-black/20 backdrop-blur-sm border-r border-white/10 flex flex-col sidebar-transition">
            <!-- Sidebar Header -->
            <div class="p-4 border-b border-white/10">
                <div class="flex items-center justify-between">
                    <h2 class="text-white font-semibold text-lg">Chat History</h2>
                    <button id="new-chat-btn" class="bg-gradient-to-r from-primary to-secondary hover:from-primary/80 hover:to-secondary/80 text-white rounded-lg px-3 py-1 text-sm transition-all transform hover:scale-105">
                        New Chat
                    </button>
                </div>
            </div>

            <!-- Sessions List -->
            <div class="flex-1 overflow-y-auto custom-scrollbar">
                <div id="sessions-list" class="p-2">
                    <!-- Sessions will be loaded here -->
                </div>
            </div>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-white/10">
                <div class="flex items-center space-x-2 text-sm text-gray-400">
                    <div class="w-2 h-2 bg-success rounded-full"></div>
                    <span>Ako si Jhunbert Bojo Bayot Groomer</span>
                </div>
            </div>
        </div>

        <!-- Main Chat Area -->
       <div class="flex-1 flex flex-col main-chat-area">
            <!-- Header -->
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <button id="sidebar-toggle" class="lg:hidden text-white hover:text-gray-300 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-r from-primary to-secondary rounded-full mb-2">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <h1 class="text-2xl font-bold text-white mb-1">Hydra AI Assistant</h1>
                            <p class="text-gray-300 text-sm">Your intelligent Hydra transaction helper</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-xs text-gray-200 bg-white/20 px-2 py-1 rounded-full">Business Mode</span>
                        <div class="flex items-center space-x-2 text-sm text-gray-300">
                            <div class="w-2 h-2 bg-success rounded-full animate-pulse"></div>
                            <span>Online • Llama 3.3 70B</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Container -->
            <div class="flex-1 flex flex-col">
                <!-- Chat Messages -->
                <div id="chat-messages" class="flex-1 overflow-y-auto overflow-x-hidden p-4 space-y-4 custom-scrollbar" style="max-height: calc(95vh - 300px);">
                    <!-- Welcome Message -->
                    <div class="flex items-start space-x-3 animate-slide-up">
                        <div class="w-8 h-8 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="message-bubble bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2 text-white">
                            <p>Hello! I'm your AI assistant for transaction tracking and business analysis. I can help you with:</p>
                            <ul class="mt-2 text-sm text-gray-300">
                                <li>• Transaction queries and analysis</li>
                                <li>• Financial reporting insights</li>
                                <li>• Business performance metrics</li>
                                <li>• Payment processing questions</li>
                            </ul>
                            <span class="text-xs text-gray-400 mt-2 block">Just now</span>
                        </div>
                    </div>

                    <!-- Typing Indicator (hidden by default) -->
                    <div id="typing-indicator" class="flex items-start space-x-3 hidden">
                        <div class="w-8 h-8 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2">
                            <div class="flex space-x-1">
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s;"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chat Input -->
                <div class="p-6 bg-white/5 backdrop-blur-sm border-t border-white/10">
                    <form id="chat-form" class="flex items-center space-x-3">
                        <div class="flex-1 relative">
                            <input 
                                type="text" 
                                id="message-input"
                                placeholder="Ask about transactions, analytics, or business insights..."
                                class="w-full bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                required
                            >
                        </div>
                        
                        <button 
                            type="submit"
                            id="send-btn"
                            class="bg-gradient-to-r from-primary to-secondary hover:from-primary/80 hover:to-secondary/80 text-white rounded-xl px-6 py-3 font-medium transition-all transform hover:scale-105 active:scale-95 flex items-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                        >
                            <span>Send</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="p-6 pt-0">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <button class="quick-action glass-effect px-4 py-3 rounded-xl text-white text-sm hover:bg-white/20 transition-all transform hover:scale-105" data-message="Show me transaction summary for today">
                        📊 Today's Summary
                    </button>
                    <button class="quick-action glass-effect px-4 py-3 rounded-xl text-white text-sm hover:bg-white/20 transition-all transform hover:scale-105" data-message="Help me analyze payment trends">
                        📈 Payment Trends
                    </button>
                    <button class="quick-action glass-effect px-4 py-3 rounded-xl text-white text-sm hover:bg-white/20 transition-all transform hover:scale-105" data-message="What are common transaction errors?">
                        ⚠️ Common Errors
                    </button>
                    <button class="quick-action glass-effect px-4 py-3 rounded-xl text-white text-sm hover:bg-white/20 transition-all transform hover:scale-105" data-message="How to improve transaction processing?">
                        🚀 Optimization Tips
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Set up CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');
        const sendBtn = document.getElementById('send-btn');
        const chatMessages = document.getElementById('chat-messages');
        const typingIndicator = document.getElementById('typing-indicator');
        const quickActions = document.querySelectorAll('.quick-action');
        const sessionsList = document.getElementById('sessions-list');
        const newChatBtn = document.getElementById('new-chat-btn');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('sidebar');

        let currentSessionId = null;
        let isLoadingHistory = false;

        // Generate session ID
        function generateSessionId() {
            return 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        }

        // Initialize with new session
        function initializeNewSession() {
            currentSessionId = generateSessionId();
            clearChatMessages();
            addWelcomeMessage();
            updateActiveSession();
        }

        // Clear chat messages
        function clearChatMessages() {
            chatMessages.innerHTML = '';
        }

        // Add welcome message
        function addWelcomeMessage() {
            const welcomeDiv = document.createElement('div');
            welcomeDiv.className = 'flex items-start space-x-3 animate-slide-up';
            welcomeDiv.innerHTML = `
                <div class="w-8 h-8 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="message-bubble bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2 text-white">
                    <p>Hello! I'm your AI assistant for transaction tracking and business analysis. I can help you with:</p>
                    <ul class="mt-2 text-sm text-gray-300">
                        <li>• Transaction queries and analysis</li>
                        <li>• Financial reporting insights</li>
                        <li>• Business performance metrics</li>
                        <li>• Payment processing questions</li>
                    </ul>
                    <span class="text-xs text-gray-400 mt-2 block">Just now</span>
                </div>
            `;
            chatMessages.appendChild(welcomeDiv);
        }

        // Load chat sessions
        async function loadSessions() {
            try {
                const response = await fetch('{{ route("chat.sessions") }}', {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    displaySessions(data.sessions);
                }
            } catch (error) {
                console.error('Error loading sessions:', error);
            }
        }

        // Display sessions in sidebar
        function displaySessions(sessions) {
            sessionsList.innerHTML = '';
            
            sessions.forEach(session => {
                const sessionDiv = document.createElement('div');
                sessionDiv.className = `session-item p-3 rounded-lg cursor-pointer transition-all ${session.session_id === currentSessionId ? 'active' : ''}`;
                sessionDiv.dataset.sessionId = session.session_id;
                
                sessionDiv.innerHTML = `
                    <div class="flex justify-between items-start">
                        <div class="flex-1 min-w-0">
                            <h3 class="text-white text-sm font-medium truncate">${session.title}</h3>
                            <p class="text-gray-400 text-xs mt-1">${session.last_activity}</p>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="text-xs text-gray-500">${session.message_count} messages</span>
                            </div>
                        </div>
                        <button class="delete-session text-gray-400 hover:text-red-400 transition-colors ml-2" data-session-id="${session.session_id}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                `;
                
                sessionsList.appendChild(sessionDiv);
            });
        }

        // Load chat history for a session
        async function loadChatHistory(sessionId) {
            if (isLoadingHistory) return;
            
            isLoadingHistory = true;
            try {
                const response = await fetch(`{{ route("chat.history") }}?session_id=${sessionId}`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    clearChatMessages();
                    
                    if (data.history.length === 0) {
                        addWelcomeMessage();
                    } else {
                        data.history.forEach(message => {
                            addMessage(message.message, message.role === 'user', message.timestamp);
                        });
                    }
                    
                    currentSessionId = sessionId;
                    updateActiveSession();
                }
            } catch (error) {
                console.error('Error loading chat history:', error);
            } finally {
                isLoadingHistory = false;
            }
        }

        // Update active session styling
        function updateActiveSession() {
            document.querySelectorAll('.session-item').forEach(item => {
                item.classList.remove('active');
                if (item.dataset.sessionId === currentSessionId) {
                    item.classList.add('active');
                }
            });
        }

        // Delete session
        async function deleteSession(sessionId) {
            if (!confirm('Are you sure you want to delete this chat session?')) return;
            
            try {
                const response = await fetch('{{ route("chat.delete") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ session_id: sessionId })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    if (sessionId === currentSessionId) {
                        initializeNewSession();
                    }
                    loadSessions();
                }
            } catch (error) {
                console.error('Error deleting session:', error);
            }
        }

        function addMessage(message, isUser = false, timestamp = null) {
            message = message.replace(/\$/g, '₱');
    const messageDiv = document.createElement('div');
    messageDiv.className = `flex items-start space-x-3 animate-slide-up ${isUser ? 'justify-end' : ''}`;
    
    const time = timestamp || new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    
    messageDiv.innerHTML = `
        ${!isUser ? `
            <div class="w-8 h-8 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
        ` : ''}
        <div class="message-bubble ${isUser ? 'bg-gradient-to-r from-primary to-secondary' : 'bg-white/10 backdrop-blur-sm'} rounded-xl px-4 py-3 text-white max-w-none">
            <div class="message-content ${isUser ? 'text-white' : 'text-gray-100'}">${isUser ? escapeHtml(message) : message}</div>
            <span class="text-xs ${isUser ? 'text-gray-200' : 'text-gray-400'} mt-2 block">${time}</span>
        </div>
        ${isUser ? `
            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
        ` : ''}
    `;
    
    chatMessages.appendChild(messageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Helper function to escape HTML for user messages
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

        function showTypingIndicator() {
            typingIndicator.classList.remove('hidden');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function hideTypingIndicator() {
            typingIndicator.classList.add('hidden');
        }

        

        function setLoading(loading) {
            sendBtn.disabled = loading;
            messageInput.disabled = loading;
            
            if (loading) {
                sendBtn.innerHTML = `
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                `;
            } else {
                sendBtn.innerHTML = `
                    <span>Send</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                `;
            }
        }

        async function sendMessage(message) {
            if (!message.trim()) return;
            
            // Initialize session if none exists
            if (!currentSessionId) {
                currentSessionId = generateSessionId();
            }
            
            addMessage(message, true);
            showTypingIndicator();
            setLoading(true);
            
            try {
                const response = await fetch('{{ route("chat.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ 
                        message: message, 
                        session_id: currentSessionId 
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    hideTypingIndicator();
                    addMessage(data.response);
                    loadSessions(); // Refresh sessions list
                } else {
                    hideTypingIndicator();
                    addMessage(`Sorry, I encountered an error: ${data.error}`, false);
                }
            } catch (error) {
                hideTypingIndicator();
                addMessage('Sorry, I\'m having trouble connecting. Please try again.', false);
                console.error('Error:', error);
            } finally {
                setLoading(false);
            }
        }

        // Event Listeners
        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = messageInput.value.trim();
            if (message) {
                messageInput.value = '';
                await sendMessage(message);
            }
        });

        // Quick actions
        quickActions.forEach(button => {
            button.addEventListener('click', () => {
                const message = button.dataset.message;
                sendMessage(message);
            });
        });

        // New chat button
        newChatBtn.addEventListener('click', () => {
            initializeNewSession();
            loadSessions();
        });

        // Session selection
        sessionsList.addEventListener('click', (e) => {
            const sessionItem = e.target.closest('.session-item');
            const deleteBtn = e.target.closest('.delete-session');
            
            if (deleteBtn) {
                e.stopPropagation();
                const sessionId = deleteBtn.dataset.sessionId;
                deleteSession(sessionId);
            } else if (sessionItem) {
                const sessionId = sessionItem.dataset.sessionId;
                loadChatHistory(sessionId);
            }
        });

        // Sidebar toggle for mobile
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        // Initialize
        initializeNewSession();
        loadSessions();
        messageInput.focus();
    </script>
</body>
</html>