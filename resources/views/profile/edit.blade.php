@extends('layouts.app-sidebar')

@section('header')
    <div class="bg-gradient-to-r from-slate-50 to-purple-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Profile</h2>
            <p class="mt-1 text-sm text-gray-600">Update your personal information and profile photo</p>
        </div>
    </div>
@endsection

@section('content')
<div class="py-8 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Status Message --}}
        @if (session('status') === 'profile-updated')
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">Profile updated successfully.</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-5 bg-white border-b border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium text-gray-900">Profile Information</h3>
                        <p class="text-sm text-gray-500">Update your account's profile information and photo.</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="px-6 py-6">
                @csrf
                @method('PATCH')

                <div class="space-y-8">
                    {{-- Profile Photo Section --}}
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Profile Photo</h4>
                        <div class="flex items-center space-x-6">
                            <div class="flex-shrink-0">
                                @if($user->profile_photo)
                                    <img src="{{ asset('storage/avatars/' . $user->profile_photo) }}"
                                         alt="Profile Photo"
                                         class="w-20 h-20 object-cover rounded-full border-4 border-white shadow-lg">
                                @else
                                    <div class="w-20 h-20 bg-gray-300 rounded-full flex items-center justify-center shadow-lg">
                                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <label for="profile_photo" class="block text-sm font-medium text-gray-700 mb-2">
                                    Choose new photo
                                </label>
                                <input type="file" 
                                       name="profile_photo" 
                                       id="profile_photo"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 file:cursor-pointer cursor-pointer border border-gray-300 rounded-md" 
                                       accept="image/*">
                                <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                            </div>
                        </div>
                        @error('profile_photo')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Personal Information Section --}}
                    <div class="space-y-6">
                        <h4 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Personal Information</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Name --}}
                            <div class="space-y-1">
                                <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                                <input id="name" 
                                       name="name" 
                                       type="text" 
                                       value="{{ old('name', $user->name) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"
                                       placeholder="Enter your full name">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="space-y-1">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address *</label>
                                <input id="email" 
                                       name="email" 
                                       type="email" 
                                       value="{{ old('email', $user->email) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"
                                       placeholder="Enter your email address">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="pt-6 border-t border-gray-200">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('profile.show') }}" 
                               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="px-6 py-2 text-sm font-medium text-white bg-purple-600 border border-transparent rounded-md shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection