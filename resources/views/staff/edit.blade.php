@extends('layouts.app-sidebar')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Staff</h1>

<form action="{{ route('staff.update', $staff) }}" method="POST" class="bg-white p-6 rounded shadow max-w-xl">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" name="name" value="{{ old('name', $staff->name) }}" class="mt-1 block w-full border-gray-300 rounded shadow-sm" required>
    </div>

    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email', $staff->email) }}" class="mt-1 block w-full border-gray-300 rounded shadow-sm" required>
    </div>

    <div class="flex justify-between">
        <a href="{{ route('staff.index') }}" class="text-sm text-gray-500 hover:underline">← Cancel</a>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Update
        </button>
    </div>
</form>
@endsection
