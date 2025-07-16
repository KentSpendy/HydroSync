@extends('layouts.guest') {{-- Or use 'layouts.app' if user is already logged in --}}

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Main Card -->
        <div class="bg-white/80 backdrop-blur-sm shadow-2xl rounded-3xl p-8 border border-white/20 relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full -translate-y-16 translate-x-16 opacity-60"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-blue-100 to-indigo-100 rounded-full translate-y-12 -translate-x-12 opacity-40"></div>
            
            <!-- Header -->
            <div class="relative z-10 text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl mb-4 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Verify Your Code</h2>
                <p class="text-gray-600 text-sm">Enter the verification code sent to your device</p>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl relative">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-red-700 text-sm font-medium">{{ $errors->first() }}</span>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('otp.verify') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label for="otp" class="block text-sm font-semibold text-gray-700 mb-3">
                        Verification Code
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            name="otp" 
                            id="otp" 
                            class="w-full px-4 py-4 text-center text-2xl font-mono tracking-widest border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 placeholder-gray-400 bg-gray-50 focus:bg-white" 
                            placeholder="000000"
                            maxlength="6"
                            required
                            autocomplete="one-time-code"
                        >
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-indigo-200"
                >
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Verify Code
                    </span>
                </button>
            </form>

            <!-- Timer Section -->
            <div class="mt-6 text-center">
                <div class="inline-flex items-center justify-center space-x-2 p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-xl border border-orange-200">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">Code expires in:</span>
                    <span id="timer" class="text-lg font-bold text-orange-600 font-mono">05:00</span>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500">
                    Didn't receive the code? 
                    <a href="#" id="resend-link" class="text-indigo-600 hover:text-indigo-700 font-medium hover:underline transition-colors">
                        Resend Code
                    </a>
                </p>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="mt-6 text-center">
            <p class="text-xs text-gray-500 flex items-center justify-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                Your information is secure and protected
            </p>
        </div>
    </div>
</div>

<style>
    /* Custom input animation */
    input[name="otp"]:focus {
        animation: pulse-border 2s infinite;
    }
    
    @keyframes pulse-border {
        0%, 100% { border-color: rgb(99 102 241); }
        50% { border-color: rgb(147 51 234); }
    }
    
    /* Timer pulse animation */
    .timer-warning {
        animation: timer-pulse 1s infinite;
    }
    
    @keyframes timer-pulse {
        0%, 100% { 
            background: linear-gradient(to right, rgb(254 215 170), rgb(254 202 202));
            color: rgb(234 88 12);
        }
        50% { 
            background: linear-gradient(to right, rgb(254 202 202), rgb(254 215 170));
            color: rgb(220 38 38);
        }
    }
    
    /* Expired state */
    .timer-expired {
        background: linear-gradient(to right, rgb(254 202 202), rgb(239 68 68)) !important;
        color: rgb(220 38 38) !important;
        animation: none;
    }
    
    /* Glassmorphism effect */
    .backdrop-blur-sm {
        backdrop-filter: blur(8px);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let timeLeft = 5 * 60; // 5 minutes in seconds
    const timerElement = document.getElementById('timer');
    const resendLink = document.getElementById('resend-link');
    const timerContainer = timerElement.closest('.inline-flex');
    const submitButton = document.querySelector('button[type="submit"]');
    const form = document.querySelector('form');
    
    function updateTimer() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        
        // Format time as MM:SS
        const formattedTime = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        timerElement.textContent = formattedTime;
        
        // Change styling based on time left
        if (timeLeft <= 0) {
            // Timer expired
            timerElement.textContent = '00:00';
            timerContainer.classList.add('timer-expired');
            timerContainer.classList.remove('timer-warning');
            
            // Disable form submission
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            submitButton.innerHTML = `
                <span class="flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Code Expired
                </span>
            `;
            
            // Show expiration message
            let expiredMessage = document.getElementById('expired-message');
            if (!expiredMessage) {
                expiredMessage = document.createElement('div');
                expiredMessage.id = 'expired-message';
                expiredMessage.className = 'mt-4 p-3 bg-red-50 border border-red-200 rounded-xl';
                expiredMessage.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-red-700 text-sm font-medium">Your verification code has expired. Please request a new code.</span>
                    </div>
                `;
                form.appendChild(expiredMessage);
            }
            
            return;
        } else if (timeLeft <= 60) {
            // Warning state (last minute)
            timerContainer.classList.add('timer-warning');
            timerContainer.classList.remove('from-orange-50', 'to-red-50', 'border-orange-200');
        }
        
        timeLeft--;
    }
    
    // Update timer immediately
    updateTimer();
    
    // Update timer every second
    const timerInterval = setInterval(updateTimer, 1000);
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        if (timeLeft <= 0) {
            e.preventDefault();
            alert('Your verification code has expired. Please request a new code.');
        }
    });
    
    // Handle resend link click
    resendLink.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Reset timer
        timeLeft = 5 * 60;
        timerContainer.classList.remove('timer-expired', 'timer-warning');
        timerContainer.classList.add('from-orange-50', 'to-red-50', 'border-orange-200');
        
        // Re-enable form
        submitButton.disabled = false;
        submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
        submitButton.innerHTML = `
            <span class="flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Verify Code
            </span>
        `;
        
        // Remove expired message
        const expiredMessage = document.getElementById('expired-message');
        if (expiredMessage) {
            expiredMessage.remove();
        }
        
        // Show resend confirmation
        const resendMessage = document.createElement('div');
        resendMessage.className = 'mt-4 p-3 bg-green-50 border border-green-200 rounded-xl';
        resendMessage.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-green-700 text-sm font-medium">New verification code sent successfully!</span>
            </div>
        `;
        form.appendChild(resendMessage);
        
        // Remove success message after 3 seconds
        setTimeout(() => {
            resendMessage.remove();
        }, 3000);
        
        // Here you would typically make an AJAX call to resend the OTP
        // Example: fetch('/resend-otp', { method: 'POST', ... })
    });
});
</script>
@endsection