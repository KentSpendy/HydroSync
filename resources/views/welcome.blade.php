<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to HydroSync</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 25%, #bae6fd 50%, #7dd3fc 75%, #38bdf8 100%);
            position: relative;
            min-height: 100vh;
        }
        
        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.05"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.03"/><circle cx="50" cy="10" r="0.5" fill="%23ffffff" opacity="0.04"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            pointer-events: none;
            z-index: 1;
        }
        
        .floating-elements {
            position: fixed;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }
        
        .floating-drop {
            position: absolute;
            width: 15px;
            height: 15px;
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            animation: floatRandom 12s ease-in-out infinite;
            opacity: 0.1;
        }
        
        @keyframes floatRandom {
            0%, 100% { transform: translateY(0px) rotate(-45deg); }
            25% { transform: translateY(-30px) rotate(-35deg); }
            50% { transform: translateY(-15px) rotate(-50deg); }
            75% { transform: translateY(-25px) rotate(-40deg); }
        }
        
        .content-wrapper {
            position: relative;
            z-index: 2;
            padding: 2rem 1rem;
        }
        
        .water-drop {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(8deg); }
        }
        
        .fade-in {
            opacity: 0;
            transform: translateY(40px);
            animation: fadeIn 1.2s ease-out forwards;
        }
        
        .fade-in-delay {
            opacity: 0;
            transform: translateY(40px);
            animation: fadeIn 1.2s ease-out 0.4s forwards;
        }
        
        .fade-in-delay-2 {
            opacity: 0;
            transform: translateY(40px);
            animation: fadeIn 1.2s ease-out 0.8s forwards;
        }
        
        .fade-in-delay-3 {
            opacity: 0;
            transform: translateY(40px);
            animation: fadeIn 1.2s ease-out 1.2s forwards;
        }
        
        @keyframes fadeIn {
            to { opacity: 1; transform: translateY(0); }
        }
        
        .button-hover {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }
        
        .button-hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s;
        }
        
        .button-hover:hover::before {
            left: 100%;
        }
        
        .button-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.25);
        }
        
        .feature-item {
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .feature-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(147, 197, 253, 0.05));
            opacity: 0;
            transition: opacity 0.5s ease;
        }
        
        .feature-item:hover::before {
            opacity: 1;
        }
        
        .feature-item:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .stats-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        
        .pulse-animation {
            animation: pulse 3s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .logo-glow {
            box-shadow: 0 0 40px rgba(59, 130, 246, 0.6), 0 0 80px rgba(59, 130, 246, 0.3);
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #1e40af, #3b82f6, #60a5fa, #93c5fd);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 4s ease-in-out infinite;
        }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem 1rem;
        }
        
        .section-padding {
            padding: 6rem 1rem;
        }
        
        .parallax-bg {
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
        }
        
        .testimonial-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.4s ease;
        }
        
        .testimonial-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .nav-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .nav-dot.active {
            background: #3b82f6;
            transform: scale(1.2);
        }
        
        .scroll-indicator {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateX(-50%) translateY(0); }
            40% { transform: translateX(-50%) translateY(-10px); }
            60% { transform: translateX(-50%) translateY(-5px); }
        }
        
        .pricing-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.4s ease;
        }
        
        .pricing-card:hover {
            transform: translateY(-10px);
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }
        
        .pricing-card.featured {
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.05);
        }
        
        .section-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            margin: 4rem 0;
        }
    </style>
</head>
<body class="gradient-bg">
    <!-- Floating Elements -->
    <div class="floating-elements">
        <div class="floating-drop" style="top: 10%; left: 5%; animation-delay: 0s;"></div>
        <div class="floating-drop" style="top: 20%; left: 85%; animation-delay: 2s;"></div>
        <div class="floating-drop" style="top: 40%; left: 10%; animation-delay: 4s;"></div>
        <div class="floating-drop" style="top: 60%; left: 90%; animation-delay: 6s;"></div>
        <div class="floating-drop" style="top: 80%; left: 15%; animation-delay: 8s;"></div>
        <div class="floating-drop" style="top: 70%; left: 80%; animation-delay: 10s;"></div>
    </div>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="content-wrapper w-full">
            <div class="max-w-6xl mx-auto text-center">
                <!-- Logo & Title -->
                <div class="fade-in mb-16">
                    <div class="water-drop inline-block mb-8">
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 rounded-3xl flex items-center justify-center shadow-2xl logo-glow">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 8.172V5L8 4z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <h1 class="text-6xl md:text-8xl font-black text-gradient mb-8 tracking-tight">
                        HydroSync
                    </h1>
                    
                    <p class="text-2xl md:text-3xl text-gray-800 mb-6 max-w-4xl mx-auto leading-relaxed font-semibold">
                        Revolutionary POS & Management System
                    </p>
                    
                    <p class="text-lg md:text-xl text-gray-700 max-w-3xl mx-auto leading-relaxed mb-12">
                        Transform your water refilling station with intelligent automation, real-time analytics, and seamless customer experiences
                    </p>
                </div>
                
                <!-- Action Buttons -->
                <div class="fade-in-delay mb-16">
                    <div class="flex flex-col sm:flex-row justify-center gap-6">
                        <a href="/login" class="button-hover px-12 py-6 bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 text-white rounded-2xl font-bold text-xl shadow-2xl">
                            Launch Dashboard
                        </a>
                        <a href="/login" class="button-hover px-12 py-6 bg-white text-blue-700 border-2 border-blue-300 rounded-2xl font-bold text-xl shadow-2xl hover:border-blue-400">
                            Login
                        </a>
                        <a href="/register" class="button-hover px-12 py-6 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 rounded-2xl font-bold text-xl shadow-2xl hover:from-gray-200 hover:to-gray-300">
                            Register
                        </a>
                    </div>
                </div>
                
                <!-- Scroll Indicator -->
                <div class="scroll-indicator">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section-padding">
        <div class="content-wrapper">
            <div class="max-w-6xl mx-auto">
                <div class="fade-in text-center mb-20">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Why Choose HydroSync?</h2>
                    <p class="text-xl text-gray-700 max-w-3xl mx-auto">Experience the future of water refilling station management with our cutting-edge technology</p>
                </div>
                
                <div class="grid md:grid-cols-3 gap-10">
                    <div class="feature-item rounded-3xl p-10 shadow-2xl fade-in-delay">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-100 to-blue-200 rounded-3xl flex items-center justify-center mx-auto mb-8 pulse-animation">
                            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Lightning-Fast POS</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">Process transactions in seconds with our intuitive touch interface designed specifically for water refilling operations</p>
                    </div>
                    
                    <div class="feature-item rounded-3xl p-10 shadow-2xl fade-in-delay" style="animation-delay: 0.6s;">
                        <div class="w-20 h-20 bg-gradient-to-br from-green-100 to-green-200 rounded-3xl flex items-center justify-center mx-auto mb-8 pulse-animation">
                            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Smart Analytics</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">AI-powered insights that predict customer behavior, optimize inventory, and maximize your revenue streams</p>
                    </div>
                    
                    <div class="feature-item rounded-3xl p-10 shadow-2xl fade-in-delay" style="animation-delay: 0.8s;">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-100 to-purple-200 rounded-3xl flex items-center justify-center mx-auto mb-8 pulse-animation">
                            <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Financial Control</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">Complete expense tracking, profit optimization, and automated financial reporting for better business decisions</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="section-padding">
        <div class="content-wrapper">
            <div class="max-w-5xl mx-auto">
                <div class="stats-card rounded-3xl p-12 shadow-2xl fade-in-delay-2">
                    <h3 class="text-3xl font-bold text-gray-900 mb-4 text-center">Trusted by Industry Leaders</h3>
                    <p class="text-lg text-gray-600 text-center mb-12">Join thousands of successful water refilling stations worldwide</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                        <div class="transform hover:scale-110 transition-transform duration-300">
                            <div class="text-4xl font-black text-blue-600 mb-3">99.9%</div>
                            <div class="text-sm text-gray-600 font-semibold">System Uptime</div>
                        </div>
                        <div class="transform hover:scale-110 transition-transform duration-300">
                            <div class="text-4xl font-black text-green-600 mb-3">2,500+</div>
                            <div class="text-sm text-gray-600 font-semibold">Daily Transactions</div>
                        </div>
                        <div class="transform hover:scale-110 transition-transform duration-300">
                            <div class="text-4xl font-black text-purple-600 mb-3">300+</div>
                            <div class="text-sm text-gray-600 font-semibold">Active Stores</div>
                        </div>
                        <div class="transform hover:scale-110 transition-transform duration-300">
                            <div class="text-4xl font-black text-orange-600 mb-3">24/7</div>
                            <div class="text-sm text-gray-600 font-semibold">Expert Support</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="section-padding">
        <div class="content-wrapper">
            <div class="max-w-6xl mx-auto">
                <div class="fade-in text-center mb-20">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">What Our Customers Say</h2>
                    <p class="text-xl text-gray-700 max-w-3xl mx-auto">Real stories from real business owners who transformed their operations</p>
                </div>
                
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="testimonial-card rounded-3xl p-8 shadow-xl fade-in-delay">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                M
                            </div>
                            <div class="ml-4">
                                <div class="font-semibold text-gray-900">Maria Santos</div>
                                <div class="text-gray-600 text-sm">Aqua Fresh Station</div>
                            </div>
                        </div>
                        <p class="text-gray-700 italic">"HydroSync transformed our business completely. Sales increased 40% and customer satisfaction is through the roof!"</p>
                    </div>
                    
                    <div class="testimonial-card rounded-3xl p-8 shadow-xl fade-in-delay" style="animation-delay: 0.6s;">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                J
                            </div>
                            <div class="ml-4">
                                <div class="font-semibold text-gray-900">Juan Rodriguez</div>
                                <div class="text-gray-600 text-sm">Pure Water Hub</div>
                            </div>
                        </div>
                        <p class="text-gray-700 italic">"The analytics helped us optimize our inventory and reduce waste by 60%. Simply amazing!"</p>
                    </div>
                    
                    <div class="testimonial-card rounded-3xl p-8 shadow-xl fade-in-delay" style="animation-delay: 0.8s;">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                A
                            </div>
                            <div class="ml-4">
                                <div class="font-semibold text-gray-900">Anna Chen</div>
                                <div class="text-gray-600 text-sm">Crystal Clear Waters</div>
                            </div>
                        </div>
                        <p class="text-gray-700 italic">"Best investment we've made. The ROI was visible within the first month of using HydroSync."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="section-padding">
        <div class="content-wrapper">
            <div class="max-w-4xl mx-auto">
                <div class="bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 rounded-3xl p-12 text-white shadow-2xl fade-in-delay-2 text-center">
                    <h3 class="text-4xl font-bold mb-6">Ready to Transform Your Business?</h3>
                    <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">Join hundreds of water refilling stations already revolutionizing their operations with HydroSync</p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="/register" class="button-hover px-10 py-4 bg-white text-blue-600 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl">
                            Start Free Trial
                        </a>
                        <a href="/contact" class="button-hover px-10 py-4 bg-transparent border-2 border-white text-white rounded-xl font-bold text-lg hover:bg-white hover:text-blue-600">
                            Schedule Demo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="section-padding">
        <div class="content-wrapper">
            <div class="max-w-6xl mx-auto">
                <div class="section-divider"></div>
                <div class="text-center fade-in-delay-3">
                    <div class="flex flex-col md:flex-row justify-center items-center space-y-4 md:space-y-0 md:space-x-8 mb-8">
                        <a href="#" class="text-gray-600 hover:text-gray-900 transition-colors font-medium">Privacy Policy</a>
                        <a href="#" class="text-gray-600 hover:text-gray-900 transition-colors font-medium">Terms of Service</a>
                        <a href="#" class="text-gray-600 hover:text-gray-900 transition-colors font-medium">Contact Support</a>
                        <a href="#" class="text-gray-600 hover:text-gray-900 transition-colors font-medium">API Documentation</a>
                    </div>
                    <div class="text-gray-600 mb-4">
                        <p class="text-lg font-medium">Making water refilling stations more efficient, one drop at a time.</p>
                    </div>
                    <div class="text-sm text-gray-500">
                        &copy; 2025 HydroSync. All rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>