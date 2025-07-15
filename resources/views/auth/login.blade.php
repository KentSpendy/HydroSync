@extends('layouts.guest')

@section('content')
<div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
    {{-- Session Status --}}
    @if (session('status'))
        <div class="mb-4 text-green-700 bg-green-100 border border-green-300 p-3 rounded">
            {{ session('status') }}
        </div>
    @endif

    {{-- Login Header --}}
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-800">Login to Your Account</h1>
        <p class="text-sm text-gray-500 mt-1">Welcome back!</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input id="email" name="email" type="email" required autofocus value="{{ old('email') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" name="password" type="password" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div class="flex items-center justify-between mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-800">Forgot password?</a>
            @endif
        </div>

        {{-- Submit --}}
        <button type="submit"
            class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 transition">
            Login
        </button>
    </form>

    {{-- Register Link --}}
    @if (Route::has('register'))
        <p class="mt-6 text-sm text-center text-gray-600">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Register</a>
        </p>
    @endif
</div>
@endsection
