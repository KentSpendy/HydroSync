@extends('layouts.guest')

@section('content')
<div class="w-full max-w-md bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-100/50 p-8">
    {{-- Session Status --}}
    @if (session('status'))
        <div class="mb-6 text-emerald-800 bg-emerald-50 border border-emerald-200 p-4 rounded-xl text-sm font-medium">
            {{ session('status') }}
        </div>
    @endif

    {{-- Login Header --}}
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome Back</h1>
        <p class="text-gray-600">Sign in to your account</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        {{-- Email --}}
        <div class="group">
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
            <input id="email" name="email" type="email" required autofocus value="{{ old('email') }}"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all duration-200 ease-in-out">
            @error('email')
                <p class="text-sm text-red-500 mt-2 font-medium">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="group">
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
            <input id="password" name="password" type="password" required
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all duration-200 ease-in-out">
            @error('password')
                <p class="text-sm text-red-500 mt-2 font-medium">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div class="flex items-center justify-between">
            <label class="flex items-center group cursor-pointer">
                <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500/20 focus:ring-2 transition-all duration-200">
                <span class="ml-3 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors">Forgot password?</a>
            @endif
        </div>

        {{-- Submit --}}
        <button type="submit"
            class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:ring-offset-2 transform hover:scale-[1.02] transition-all duration-200 ease-in-out shadow-lg hover:shadow-xl">
            Sign In
        </button>
    </form>

    {{-- Register Link --}}
    @if (Route::has('register'))
        <div class="mt-8 text-center">
            <p class="text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors">Create one</a>
            </p>
        </div>
    @endif
</div>
@endsection