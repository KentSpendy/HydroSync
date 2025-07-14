@extends('layouts.app-sidebar')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800">Edit Profile</h2>
@endsection

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    {{-- Status Message --}}
    @if (session('status') === 'profile-updated')
        <div class="mb-4 text-green-600 font-semibold">
            Profile updated successfully.
        </div>
    @endif

    {{-- Profile Update Form --}}
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PATCH')

        {{-- Profile Photo --}}
        <div>
            <label for="profile_photo" class="block text-sm font-medium text-gray-700">Profile Photo</label>
            <input type="file" name="profile_photo" id="profile_photo"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" accept="image/*">
            
            @if($user->profile_photo)
                <div class="mt-2">
                    <img src="{{ asset('storage/avatars/' . $user->profile_photo) }}"
                         alt="Profile Photo"
                         class="w-20 h-20 object-cover rounded-full border border-gray-200">
                </div>
            @endif

            @error('profile_photo')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Name --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('name')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('email')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 text-right">
            <a href="{{ route('profile.show') }}" class="text-gray-600 hover:text-gray-800 mr-4">Cancel</a>
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
