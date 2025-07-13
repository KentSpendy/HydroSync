@extends('layouts.app-sidebar')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Dashboard</h1>
                <p class="text-slate-500 mt-1">Welcome back, {{ Auth::user()->name }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-slate-600">{{ now()->format('l, F j, Y') }}</p>
                <p class="text-xs text-slate-400">{{ now()->format('g:i A') }}</p>
            </div>
        </div>

        {{-- Key Metrics --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Total Sales Card --}}
            <div class="bg-white rounded-xl border border-slate-200 p-6 hover:border-slate-300 transition-colors duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-600">Total Sales Today</p>
                        <p class="text-2xl font-semibold text-slate-900 mt-1">₱{{ number_format($totalSales, 2) }}</p>
                        <div class="flex items-center mt-3">
                            <span class="text-xs text-emerald-700 bg-emerald-50 px-2 py-1 rounded-md border border-emerald-200">
                                +12.5% from yesterday
                            </span>
                        </div>
                    </div>
                    <div class="w-11 h-11 bg-emerald-50 rounded-lg flex items-center justify-center border border-emerald-200">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Active Customers Card --}}
            <div class="bg-white rounded-xl border border-slate-200 p-6 hover:border-slate-300 transition-colors duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-600">Active Customers Today</p>
                        <p class="text-2xl font-semibold text-slate-900 mt-1">{{ $activeCustomers }}</p>
                        <div class="flex items-center mt-3">
                            <span class="text-xs text-blue-700 bg-blue-50 px-2 py-1 rounded-md border border-blue-200">
                                +{{ $activeCustomers > 10 ? '8' : '2' }} new customers
                            </span>
                        </div>
                    </div>
                    <div class="w-11 h-11 bg-blue-50 rounded-lg flex items-center justify-center border border-blue-200">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Pending Transactions Card --}}
            <div class="bg-white rounded-xl border border-slate-200 p-6 hover:border-slate-300 transition-colors duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-600">Pending Transactions</p>
                        <p class="text-2xl font-semibold text-slate-900 mt-1">{{ $pendingTransactions ?? 0 }}</p>
                        <div class="flex items-center mt-3">
                            @if(($pendingTransactions ?? 0) > 0)
                                <span class="text-xs text-amber-700 bg-amber-50 px-2 py-1 rounded-md border border-amber-200">
                                    Requires attention
                                </span>
                            @else
                                <span class="text-xs text-emerald-700 bg-emerald-50 px-2 py-1 rounded-md border border-emerald-200">
                                    All caught up
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="w-11 h-11 bg-amber-50 rounded-lg flex items-center justify-center border border-amber-200">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Sales Chart --}}
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-medium text-slate-900">Sales This Week</h3>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-indigo-500 rounded-full"></div>
                        <span class="text-sm text-slate-600">Revenue</span>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="text-lg font-medium text-slate-900 mb-6">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('transactions.index') }}" class="flex items-center p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors duration-200 border border-slate-100">
                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-4 border border-indigo-200">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-slate-900">View All Transactions</p>
                            <p class="text-sm text-slate-500">Manage and track transactions</p>
                        </div>
                    </a>

                    <a href="{{ route('expenses.index') }}" class="flex items-center p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors duration-200 border border-slate-100">
                        <div class="w-10 h-10 bg-rose-100 rounded-lg flex items-center justify-center mr-4 border border-rose-200">
                            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-slate-900">Track Expenses</p>
                            <p class="text-sm text-slate-500">Monitor business expenses</p>
                        </div>
                    </a>

                    <a href="{{ route('sales.history') }}" class="flex items-center p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors duration-200 border border-slate-100">
                        <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center mr-4 border border-emerald-200">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-slate-900">Sales History</p>
                            <p class="text-sm text-slate-500">View detailed sales reports</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Sales (₱)',
                    data: {!! json_encode($chartData) !!},
                    backgroundColor: 'rgba(99, 102, 241, 0.05)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(148, 163, 184, 0.1)',
                            borderDash: [2, 2]
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                size: 12
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    </script>
@endsection