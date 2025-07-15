<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to HydroSync</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #bae6fd 100%);
        }
        
        .water-drop {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(3deg); }
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .button-hover {
            transition: all 0.3s ease;
        }
        
        .button-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .feature-item {
            transition: all 0.3s ease;
        }
        
        .feature-item:hover {
            transform: translateY(-3px);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <!-- Main Container -->
    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-8">
        <div class="max-w-4xl w-full text-center">
            
            <!-- Logo & Title -->
            <div class="fade-in mb-12">
                <div class="water-drop inline-block mb-6">
                    <div class="w-16 h-16 bg-blue-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 8.172V5L8 4z"></path>
                        </svg>
                    </div>
                </div>
                
                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
                    HydroSync
                </h1>
                
                <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                    Your complete POS and monitoring system for water refilling stations. 
                    Simple, efficient, and powerful.
                </p>
            </div>
            
            <!-- Action Buttons -->
            <div class="fade-in mb-16">
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="/dashboard" class="button-hover px-8 py-4 bg-blue-500 text-white rounded-xl font-medium text-lg hover:bg-blue-600 shadow-lg">
                        Go to Dashboard
                    </a>
                    <a href="/login" class="button-hover px-8 py-4 bg-white text-blue-500 border-2 border-blue-500 rounded-xl font-medium text-lg hover:bg-blue-50 shadow-lg">
                        Login
                    </a>
                    <a href="/register" class="button-hover px-8 py-4 bg-gray-100 text-gray-700 rounded-xl font-medium text-lg hover:bg-gray-200 shadow-lg">
                        Register
                    </a>
                </div>
            </div>
            
            <!-- Features -->
            <div class="fade-in mb-16">
                <div class="grid md:grid-cols-3 gap-8 max-w-3xl mx-auto">
                    <div class="feature-item bg-white rounded-2xl p-6 shadow-sm">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Smart POS</h3>
                        <p class="text-gray-600 text-sm">Fast and intuitive point-of-sale system</p>
                    </div>
                    
                    <div class="feature-item bg-white rounded-2xl p-6 shadow-sm">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Analytics</h3>
                        <p class="text-gray-600 text-sm">Track sales and monitor performance</p>
                    </div>
                    
                    <div class="feature-item bg-white rounded-2xl p-6 shadow-sm">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Expenses</h3>
                        <p class="text-gray-600 text-sm">Manage costs and track profitability</p>
                    </div>
                </div>
            </div>
            
            <!-- Stats -->
            <div class="fade-in mb-16">
                <div class="bg-white rounded-2xl p-8 shadow-sm max-w-2xl mx-auto">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                        <div>
                            <div class="text-2xl font-bold text-blue-500 mb-1">99.9%</div>
                            <div class="text-sm text-gray-600">Uptime</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-green-500 mb-1">1000+</div>
                            <div class="text-sm text-gray-600">Daily Transactions</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-purple-500 mb-1">50+</div>
                            <div class="text-sm text-gray-600">Active Stores</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-orange-500 mb-1">24/7</div>
                            <div class="text-sm text-gray-600">Support</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="fade-in">
                <div class="text-center">
                    <p class="text-gray-500 text-sm mb-4">
                        Ready to streamline your water refilling business?
                    </p>
                    <div class="text-xs text-gray-400">
                        &copy; 2024 HydroSync. All rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>