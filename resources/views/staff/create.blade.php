@extends('layouts.app-sidebar')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800 leading-tight">➕ Add New Staff</h2>
@endsection

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white p-6 rounded shadow">
            @if($errors->any())
                <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('staff.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full border border-gray-300 rounded p-2 mt-1" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full border border-gray-300 rounded p-2 mt-1" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Password</label>
                    <input type="password" name="password"
                           class="w-full border border-gray-300 rounded p-2 mt-1" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                           class="w-full border border-gray-300 rounded p-2 mt-1" required>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('staff.index') }}" class="mr-4 text-gray-600 hover:underline">Cancel</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Create Staff
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
