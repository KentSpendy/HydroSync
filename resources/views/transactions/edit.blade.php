<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Transaction</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
            <form method="POST" action="{{ route('transactions.update', $transaction) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium">Customer Name</label>
                    <input name="customer_name" class="w-full border p-2 rounded" value="{{ $transaction->customer_name }}" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Order Details</label>
                    <input name="order_details" class="w-full border p-2 rounded" value="{{ $transaction->order_details }}">
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Amount (₱)</label>
                    <input type="number" step="0.01" name="amount" class="w-full border p-2 rounded" value="{{ $transaction->amount }}" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Payment Status</label>
                    <select name="payment_status" class="w-full border p-2 rounded" required>
                        <option value="paid" {{ $transaction->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="debt" {{ $transaction->payment_status == 'debt' ? 'selected' : '' }}>Debt</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Delivery Group</label>
                    <input name="delivery_group" class="w-full border p-2 rounded" value="{{ $transaction->delivery_group }}">
                </div>

                <button class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">
                    Update Transaction
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
