<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Invoice</h2>
    </x-slot>

    <div class="py-4 px-6">
        <form id="edit-invoice-form">
            <div class="mb-4">
                <label for="customer_id" class="block text-gray-700">Customer</label>
                <select id="customer_id" name="customer_id" class="w-full border rounded px-3 py-2" required></select>
            </div>

            <div class="mb-4">
                <label for="invoice_date" class="block text-gray-700">Invoice Date</label>
                <input type="date" id="invoice_date" name="invoice_date" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="total_amount" class="block text-gray-700">Total Amount</label>
                <input type="number" id="total_amount" name="total_amount" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-gray-700">Status</label>
                <select id="status" name="status" class="w-full border rounded px-3 py-2" required>

                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Invoice</button>
        </form>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const notyf = new Notyf();

        const invoiceId = "{{ $invoiceId }}";

        fetch('/api/list')
            .then(res => res.json())
            .then(data => {
                const select = document.getElementById('customer_id');
                const invoice = data.invoices.find(i => i.id == invoiceId);

                if (!invoice) return alert('Invoice not found');

                (data.customers || []).forEach(customer => {
                    const selected = invoice.customer_id == customer.id ? 'selected' : '';
                    select.insertAdjacentHTML('beforeend', `<option value="${customer.id}" ${selected}>${customer.name}</option>`);
                });

                const statusSelect = document.getElementById('status');
                
                (data.statuses || []).forEach(status => {
                    statusSelect.insertAdjacentHTML('beforeend', `<option value="${status.value}">${status.label}</option>`);
                });

                document.getElementById('invoice_date').value = invoice.date;
                document.getElementById('total_amount').value = invoice.amount;
                document.getElementById('status').value = invoice.status;
            });

        document.getElementById('edit-invoice-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const payload = {
                type: 'invoice',
                id: invoiceId,
                data: {
                    customer_id: this.customer_id.value,
                    date: this.invoice_date.value,
                    amount: this.total_amount.value,
                    status: this.status.value
                }
            };

            fetch(`/api/update`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if (data.invoice) {
                    notyf.success('Invoice updated successfully!');
                    setTimeout(() => window.location.href = '/invoices', 1000);
                } else if(data.errors) {
                        notyf.error(Object.values(data.errors).join('\n'));
                    } else {
                        notyf.error(data.error || 'Failed to update invoice');
                    }
            });
        });
    });
    </script>
</x-app-layout>
