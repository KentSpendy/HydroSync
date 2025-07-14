@extends('layouts.app-sidebar')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800 leading-tight">👥 Staff Management</h2>
@endsection

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Top Bar: Add + Search --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
            @can('admin')
                <a href="{{ route('staff.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full sm:w-auto text-center">
                    + Add Staff
                </a>
            @endcan

            <form method="GET" action="{{ route('staff.index') }}" class="flex gap-2 w-full sm:w-auto">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by name or email"
                    class="w-full sm:w-64 px-4 py-2 border rounded shadow-sm focus:ring focus:ring-blue-200">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Search
                </button>
            </form>
        </div>

        {{-- Search Info --}}
        @if(request('search'))
            <div class="text-sm text-gray-600">
                Showing results for: <strong>{{ request('search') }}</strong>
                <a href="{{ route('staff.index') }}" class="ml-2 text-blue-600 hover:underline">Clear</a>
            </div>
        @endif

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="p-4 bg-green-100 text-green-800 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Staff Table --}}
        <div class="bg-white p-4 rounded shadow">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staff as $user)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">
                                <div class="flex gap-3">
                                    <a href="{{ route('staff.edit', $user) }}" class="text-blue-600 hover:underline">Edit</a>

                                    <form method="POST" action="{{ route('staff.destroy', $user) }}"
                                          onsubmit="return confirm('Are you sure you want to delete this staff?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-6 text-gray-500">No staff accounts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $staff->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
