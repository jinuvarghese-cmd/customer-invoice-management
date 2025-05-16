<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Invoices</h2>
    </x-slot>

    <div class="py-4 px-6">
        <a href="{{ route('invoices.create') }}" class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">+ Add Invoice</a>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
            <table class="min-w-full table-auto border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2 text-left">ID</th>
                        <th class="border px-4 py-2 text-left">Customer</th>
                        <th class="border px-4 py-2 text-left">Date</th>
                        <th class="border px-4 py-2 text-left">Amount</th>
                        <th class="border px-4 py-2 text-left">Status</th>
                        <th class="border px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="invoice-table-body">
                    <!-- JS will fill this -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch('/api/list')
                .then(res => res.json())
                .then(data => {
                    const tbody = document.getElementById('invoice-table-body');
                    const invoices = data.invoices || [];

                    invoices.forEach(invoice => {
                        const row = `
                            <tr>
                                <td class="border px-4 py-2">${invoice.id}</td>
                                <td class="border px-4 py-2">${invoice.customer.name}</td>
                                <td class="border px-4 py-2">${invoice.date}</td>
                                <td class="border px-4 py-2">${invoice.amount}</td>
                                <td class="border px-4 py-2">${invoice.status}</td>
                                <td class="border px-4 py-2">
                                    <a href="/invoices/${invoice.id}/edit" class="text-blue-600 hover:underline">Edit</a>
                                </td>
                            </tr>`;
                        tbody.insertAdjacentHTML('beforeend', row);
                    });
                });
        });
    </script>
</x-app-layout>
