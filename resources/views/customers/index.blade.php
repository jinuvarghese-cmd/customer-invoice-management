<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Customers</h2>
    </x-slot>

    <div class="py-4 px-6">
        <a href="{{ route('customers.create') }}" class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">+ Add Customer</a>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
            <table class="min-w-full table-auto border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2 text-left">ID</th>
                        <th class="border px-4 py-2 text-left">Name</th>
                        <th class="border px-4 py-2 text-left">Phone</th>
                        <th class="border px-4 py-2 text-left">Email</th>
                        <th class="border px-4 py-2 text-left">Address</th>
                        <th class="border px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="customer-table-body">
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
                    const tbody = document.getElementById('customer-table-body');
                    const customers = data.customers || [];

                    customers.forEach(customer => {
                        const row = `
                            <tr>
                                <td class="border px-4 py-2">${customer.id}</td>
                                <td class="border px-4 py-2">${customer.name}</td>
                                <td class="border px-4 py-2">${customer.phone || '-'}</td>
                                <td class="border px-4 py-2">${customer.email || '-'}</td>
                                <td class="border px-4 py-2">${customer.address || '-'}</td>
                                <td class="border px-4 py-2">
                                    <a href="/customers/${customer.id}/edit" class="text-blue-600 hover:underline">Edit</a>
                                </td>
                            </tr>`;
                        tbody.insertAdjacentHTML('beforeend', row);
                    });
                });
        });
    </script>
</x-app-layout>