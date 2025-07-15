@extends('layouts.guest') {{-- Or use 'layouts.app' if user is already logged in --}}

@section('content')
<div class="max-w-md mx-auto mt-10 p-6 bg-white shadow rounded">
    <h2 class="text-xl font-bold mb-4">🔐 Enter OTP</h2>

    @if($errors->any())
        <div class="mb-4 text-red-600">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('otp.verify') }}" method="POST">
        @csrf

        <label for="otp" class="block font-medium">OTP Code:</label>
        <input type="text" name="otp" id="otp" class="w-full p-2 border rounded mt-2 mb-4" required>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Verify OTP
        </button>
    </form>
</div>
@endsection
