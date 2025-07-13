<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Add Expense</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
            <form method="POST" action="{{ route('expenses.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block font-medium">Description</label>
                    <input name="description" class="w-full border p-2 rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Category</label>
                    <select name="category" class="w-full border p-2 rounded" required>
                        <option value="fuel">Fuel</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="others">Others</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Amount</label>
                    <input type="number" step="0.01" name="amount" class="w-full border p-2 rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Date</label>
                    <input type="date" name="date" class="w-full border p-2 rounded" required>
                </div>

                <button class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">
                    Save Expense
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
