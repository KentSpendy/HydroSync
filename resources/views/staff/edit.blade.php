@extends('layouts.app-sidebar')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800 leading-tight">✏️ Edit Staff</h2>
@endsection

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded shadow">

            @if(session('success'))
                <div class="mb-4 bg-green-100 text-green-800 p-3 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('staff.update', $staff->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ old('name', $staff->name) }}"
                        class="w-full border border-gray-300 rounded p-2 mt-1" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $staff->email) }}"
                        class="w-full border border-gray-300 rounded p-2 mt-1" required>
                </div>

                <hr class="my-6">

                <h3 class="font-semibold text-gray-600 mb-2">🔒 Reset Password (Optional)</h3>

                <div class="mb-4">
                    <label class="block font-medium text-gray-700">New Password</label>
                    <input type="password" name="password"
                        class="w-full border border-gray-300 rounded p-2 mt-1">
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full border border-gray-300 rounded p-2 mt-1">
                </div>

                <div class="flex justify-between items-center mt-6">
                    <a href="{{ route('staff.index') }}" class="text-gray-600 hover:underline">← Back to Staff</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Update Staff
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
