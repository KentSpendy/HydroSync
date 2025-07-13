@extends('layouts.app-sidebar')

@section('header')
    <h2 class="font-semibold text-2xl text-gray-900 leading-tight tracking-tight">
        Expenses — Admin + Employee
    </h2>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Page Header --}}
        <div class="mb-8">
            <div class="border-b border-gray-200 pb-4">
                <h1 class="text-3xl font-bold text-gray-900">Expenses</h1>
                <p class="mt-2 text-sm text-gray-600">Track and manage business expenses across all categories</p>
            </div>
        </div>

        {{-- Top Action Buttons --}}
        <div class="flex flex-wrap gap-3 mb-6">
            <a href="{{ route('expenses.create') }}"
               class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Expense
            </a>

            <a href="{{ route('expenses.export.excel') }}"
               class="inline-flex items-center px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium text-sm rounded-lg shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export Excel
            </a>

            <a href="{{ route('expenses.export.pdf') }}"
               class="inline-flex items-center px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium text-sm rounded-lg shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export PDF
            </a>
        </div>

        {{-- Success Alert --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        {{-- Filter Form --}}
        <form method="GET" action="{{ route('expenses.index') }}" class="mb-6">
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <div class="flex flex-wrap items-center gap-4">
                    <label for="category" class="text-sm font-medium text-gray-700">Filter by Category:</label>
                    <select name="category" id="category" onchange="this.form.submit()" 
                            class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        <option value="">All Categories</option>
                        <option value="fuel" {{ request('category') == 'fuel' ? 'selected' : '' }}>Fuel</option>
                        <option value="maintenance" {{ request('category') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="others" {{ request('category') == 'others' ? 'selected' : '' }}>Others</option>
                    </select>
                    @if(request('category'))
                        <a href="{{ route('expenses.index') }}" 
                           class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors duration-150">
                            Clear Filter
                        </a>
                    @endif
                </div>
            </div>
        </form>

        {{-- Expenses Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($expenses as $expense)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $expense->description }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($expense->category === 'fuel') bg-yellow-100 text-yellow-800
                                        @elseif($expense->category === 'maintenance') bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        @if($expense->category === 'fuel')
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                            </svg>
                                        @elseif($expense->category === 'maintenance')
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                                            </svg>
                                        @else
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                        {{ ucfirst($expense->category) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">₱{{ number_format($expense->amount, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($expense->date)->format('M d, Y') }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="text-gray-400">
                                        <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                        <p class="text-sm font-medium">No expenses recorded yet</p>
                                        <p class="text-xs mt-1">Add your first expense to get started</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($expenses->hasPages())
                <div class="bg-gray-50 border-t border-gray-200 px-6 py-3">
                    {{ $expenses->links() }}
                </div>
            @endif
        </div>

        {{-- Total Footer --}}
        <div class="mt-6 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="flex justify-between items-center">
                <span class="text-sm font-medium text-gray-600">Total Expenses:</span>
                <span class="text-2xl font-bold text-gray-900">₱{{ number_format($totalAmount, 2) }}</span>
            </div>
        </div>
    </div>
</div>
@endsection