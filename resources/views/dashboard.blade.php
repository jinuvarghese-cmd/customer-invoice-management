<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-4 px-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

            <!-- Total Customers Card -->
            <a href="{{ route('customers.index') }}" class="block bg-white shadow rounded-lg p-6 hover:bg-gray-50 transition">
                <h3 class="text-lg font-medium text-gray-900">Total Customers</h3>
                <p class="mt-2 text-3xl font-bold text-blue-600">{{ $customerCount }}</p>
            </a>

            <!-- Total Invoices Card -->
            <a href="{{ route('invoices.index') }}" class="block bg-white shadow rounded-lg p-6 hover:bg-gray-50 transition">
                <h3 class="text-lg font-medium text-gray-900">Total Invoices</h3>
                <p class="mt-2 text-3xl font-bold text-green-600">{{ $invoiceCount }}</p>
            </a>

        </div>
    </div>
</x-app-layout>
