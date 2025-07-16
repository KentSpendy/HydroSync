<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-slate-50 to-blue-50 border-b border-gray-200">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Add Transaction</h2>
                <p class="mt-1 text-sm text-gray-600">Create a new transaction record</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Transaction Details</h3>
                </div>
                
                <form method="POST" action="{{ route('transactions.store') }}" class="px-6 py-6 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Customer Name *</label>
                            <input name="customer_name" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" 
                                   placeholder="Enter customer name"
                                   required>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Amount (₱) *</label>
                            <input type="number" 
                                   step="0.01" 
                                   name="amount" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" 
                                   placeholder="0.00"
                                   required>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700">Order Details</label>
                        <input name="order_details" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" 
                               placeholder="Describe the order details">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Payment Status *</label>
                            <select name="payment_status" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors bg-white" 
                                    required>
                                <option value="">Select status</option>
                                <option value="paid">Paid</option>
                                <option value="debt">Debt</option>
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Delivery Group</label>
                            <input name="delivery_group" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" 
                                   placeholder="Enter delivery group">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex justify-end space-x-3">
                            <button type="button" 
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                Save Transaction
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>