<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-slate-50 to-red-50 border-b border-gray-200">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Add Expense</h2>
                <p class="mt-1 text-sm text-gray-600">Record a new business expense</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Expense Details</h3>
                </div>
                
                <form method="POST" action="{{ route('expenses.store') }}" class="px-6 py-6 space-y-6" id="expenseForm">
                    @csrf

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700">Description *</label>
                        <input name="description" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors" 
                               placeholder="Enter expense description"
                               required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Category *</label>
                            <select name="category" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors bg-white" 
                                    required>
                                <option value="">Select category</option>
                                <option value="fuel">⛽ Fuel</option>
                                <option value="maintenance">🔧 Maintenance</option>
                                <option value="others">📋 Others</option>
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Amount (₱) *</label>
                            <input type="number" 
                                   step="0.01" 
                                   name="amount" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors" 
                                   placeholder="0.00"
                                   required>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700">Date *</label>
                        <input type="date" 
                               name="date" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors" 
                               required>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex justify-end space-x-3">
                            <button type="button" 
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                                Cancel
                            </button>
                            <button type="button" 
                                    id="saveExpenseBtn"
                                    class="px-6 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                                Save Expense
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const saveBtn = document.getElementById('saveExpenseBtn');
            const form = document.getElementById('expenseForm');
            
            saveBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Get form data for preview
                const description = form.querySelector('input[name="description"]').value;
                const category = form.querySelector('select[name="category"]').value;
                const amount = form.querySelector('input[name="amount"]').value;
                const date = form.querySelector('input[name="date"]').value;
                
                // Validate form first
                if (!description || !category || !amount || !date) {
                    Swal.fire({
                        title: 'Missing Information',
                        text: 'Please fill in all required fields.',
                        icon: 'warning',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#dc2626'
                    });
                    return;
                }
                
                // Get category display name
                const categoryDisplay = {
                    'fuel': '⛽ Fuel',
                    'maintenance': '🔧 Maintenance',
                    'others': '📋 Others'
                }[category];
                
                // Show confirmation dialog
                Swal.fire({
                    title: 'Confirm Expense',
                    html: `
                        <div class="text-left space-y-2">
                            <p><strong>Description:</strong> ${description}</p>
                            <p><strong>Category:</strong> ${categoryDisplay}</p>
                            <p><strong>Amount:</strong> ₱${parseFloat(amount).toFixed(2)}</p>
                            <p><strong>Date:</strong> ${date}</p>
                        </div>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Save Expense',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        Swal.fire({
                            title: 'Saving...',
                            text: 'Please wait while we save your expense.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        // Submit the form
                        form.submit();
                    }
                });
            });
        });
        
        // Show success message if there's a success session
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc2626'
                });
            });
        @endif
        
        // Show error message if there are validation errors
        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Validation Error',
                    html: `
                        <div class="text-left">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    `,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc2626'
                });
            });
        @endif
    </script>
</x-app-layout>