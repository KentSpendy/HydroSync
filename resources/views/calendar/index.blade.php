@extends('layouts.app-sidebar')

@section('header')
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Calendar</h2>
                <p class="text-sm text-gray-600">Manage deliveries and track schedules</p>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                <span class="w-2 h-2 bg-yellow-400 rounded-full mr-1"></span>
                Pending
            </span>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                <span class="w-2 h-2 bg-red-400 rounded-full mr-1"></span>
                Unpaid
            </span>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Calendar Stats -->
            {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Today's Deliveries</p>
                            <p class="text-2xl font-bold text-gray-900" id="todayCount">-</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-8 h-8 bg-yellow-100 rounded-lg">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Pending Orders</p>
                            <p class="text-2xl font-bold text-gray-900" id="pendingCount">-</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-8 h-8 bg-green-100 rounded-lg">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Revenue This Month</p>
                            <p class="text-2xl font-bold text-gray-900">₱<span id="monthlyRevenue">-</span></p>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Calendar Container -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Delivery Schedule</h3>
                    <p class="text-sm text-gray-600 mt-1">Click on any date to view transactions and deliveries</p>
                </div>
                <div class="p-6">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Custom Calendar Styles */
    .fc-theme-standard td, .fc-theme-standard th {
        border: 1px solid #e5e7eb;
    }
    
    .fc-theme-standard .fc-scrollgrid {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
    }
    
    .fc-header-toolbar {
        margin-bottom: 1.5rem !important;
    }
    
    .fc-toolbar-title {
        font-size: 1.5rem !important;
        font-weight: 700 !important;
        color: #1f2937 !important;
    }
    
    .fc-button {
        background: #f9fafb !important;
        border: 1px solid #d1d5db !important;
        color: #374151 !important;
        padding: 0.5rem 1rem !important;
        border-radius: 0.375rem !important;
        font-weight: 500 !important;
        transition: all 0.2s ease !important;
    }
    
    .fc-button:hover {
        background: #f3f4f6 !important;
        border-color: #9ca3af !important;
    }
    
    .fc-button:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
    }
    
    .fc-button-primary:not(:disabled):active,
    .fc-button-primary:not(:disabled).fc-button-active {
        background: #3b82f6 !important;
        border-color: #3b82f6 !important;
        color: white !important;
    }
    
    .fc-day-today .fc-daygrid-day-number {
        background: #3b82f6 !important;
        color: white !important;
        border-radius: 50% !important;
        width: 2rem !important;
        height: 2rem !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    
    .fc-daygrid-day:hover {
        background: #f8fafc !important;
        cursor: pointer !important;
    }
    
    .fc-event {
        border: none !important;
        border-radius: 0.25rem !important;
        padding: 0.125rem 0.375rem !important;
        font-size: 0.75rem !important;
        font-weight: 500 !important;
        margin: 0.125rem 0 !important;
    }
    
    .fc-event-pending {
        background: #fef3c7 !important;
        color: #92400e !important;
    }
    
    .fc-event-unpaid {
        background: #fee2e2 !important;
        color: #991b1b !important;
    }
    
    .fc-event-paid {
        background: #d1fae5 !important;
        color: #065f46 !important;
    }
    
    .fc-daygrid-day-number {
        font-weight: 600 !important;
        color: #374151 !important;
    }
    
    .fc-col-header-cell {
        background: #f9fafb !important;
        font-weight: 600 !important;
        color: #6b7280 !important;
        text-transform: uppercase !important;
        font-size: 0.75rem !important;
        letter-spacing: 0.05em !important;
    }
    
    /* Custom SweetAlert2 Styles */
    .swal2-popup {
        border-radius: 0.75rem !important;
    }
    
    .swal2-title {
        font-size: 1.5rem !important;
        font-weight: 700 !important;
        color: #1f2937 !important;
    }
    
    .swal2-confirm {
        background: #3b82f6 !important;
        border-radius: 0.375rem !important;
        font-weight: 500 !important;
        padding: 0.75rem 1.5rem !important;
    }
    
    .transaction-item {
        background: #f8fafc;
        border-radius: 0.5rem;
        padding: 1rem;
        margin: 0.5rem 0;
        border-left: 4px solid #3b82f6;
    }
    
    .transaction-item.pending {
        border-left-color: #f59e0b;
    }
    
    .transaction-item.unpaid {
        border-left-color: #ef4444;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');
        let calendar;

        // Initialize calendar
        calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [FullCalendar.dayGridPlugin, FullCalendar.interactionPlugin],
            initialView: 'dayGridMonth',
            selectable: true,
            height: 'auto',
            headerToolbar: {
                start: 'title',
                center: '',
                end: 'prev,next today'
            },
            events: '/calendar/events',
            eventClassNames: function(arg) {
                return ['fc-event-' + arg.event.extendedProps.status];
            },
            dateClick: function (info) {
                showTransactionDetails(info.dateStr);
            },
            eventDidMount: function(info) {
                // Add tooltip for events
                info.el.setAttribute('title', info.event.title);
            }
        });

        calendar.render();

        // Load dashboard stats
        // loadDashboardStats();

        // function loadDashboardStats() {
        //     fetch('/calendar/stats')
        //         .then(response => response.json())
        //         .then(data => {
        //             document.getElementById('todayCount').textContent = data.today || 0;
        //             document.getElementById('pendingCount').textContent = data.pending || 0;
        //             document.getElementById('monthlyRevenue').textContent = formatCurrency(data.monthlyRevenue || 0);
        //         })
        //         .catch(err => console.error('Failed to load stats:', err));
        // }

        function showTransactionDetails(dateStr) {
            // Show loading state
            Swal.fire({
                title: 'Loading...',
                html: '<div class="flex justify-center items-center py-4"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div></div>',
                showConfirmButton: false,
                allowOutsideClick: false
            });

            fetch(`/calendar/day/${dateStr}`)
                .then(response => response.json())
                .then(data => {
                    if (data.transactions.length === 0) {
                        Swal.fire({
                            icon: 'info',
                            title: 'No Transactions',
                            text: `No transactions scheduled for ${formatDate(dateStr)}`,
                            confirmButtonText: 'Close',
                            customClass: {
                                confirmButton: 'swal2-confirm'
                            }
                        });
                        return;
                    }

                    const filtered = data.transactions.filter(tx => tx.payment_status !== 'paid');
                    
                    if (filtered.length === 0) {
                        Swal.fire({
                            icon: 'success',
                            title: 'All Deliveries Complete',
                            text: `All deliveries for ${formatDate(dateStr)} have been completed and paid.`,
                            confirmButtonText: 'Close',
                            customClass: {
                                confirmButton: 'swal2-confirm'
                            }
                        });
                        return;
                    }

                    let html = '<div class="space-y-3">';
                    
                    filtered.forEach(tx => {
                        const statusClass = tx.payment_status === 'pending' ? 'pending' : 'unpaid';
                        const statusColor = tx.payment_status === 'pending' ? '#f59e0b' : '#ef4444';
                        const statusText = tx.payment_status.charAt(0).toUpperCase() + tx.payment_status.slice(1);
                        
                        html += `
                            <div class="transaction-item ${statusClass}">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">${tx.customer_name}</h4>
                                        <p class="text-sm text-gray-600 mt-1">Amount: <span class="font-medium">₱${formatCurrency(tx.amount)}</span></p>
                                        <div class="flex items-center mt-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: ${statusColor}20; color: ${statusColor};">
                                                <span class="w-2 h-2 rounded-full mr-1" style="background-color: ${statusColor};"></span>
                                                ${statusText}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    html += '</div>';

                    Swal.fire({
                        title: `📅 ${formatDate(dateStr)}`,
                        html: html,
                        width: '600px',
                        showCloseButton: true,
                        confirmButtonText: 'Close',
                        customClass: {
                            popup: 'swal2-popup',
                            title: 'swal2-title',
                            confirmButton: 'swal2-confirm'
                        }
                    });
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch transaction details. Please try again.',
                        confirmButtonText: 'Close',
                        customClass: {
                            confirmButton: 'swal2-confirm'
                        }
                    });
                });
        }

        function formatDate(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        function formatCurrency(amount) {
            return parseFloat(amount).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
    });
</script>
@endpush