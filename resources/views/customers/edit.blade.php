<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Edit Customer</h2>
    </x-slot>

    <div class="p-6">
        <form id="customer-edit-form">
            @csrf

            <div class="mb-4">
                <label>Name</label>
                <input type="text" name="name" required class="w-full border p-2" />
            </div>

            <div class="mb-4">
                <label>Phone</label>
                <input type="text" name="phone" class="w-full border p-2" />
            </div>

            <div class="mb-4">
                <label>Email</label>
                <input type="email" name="email" class="w-full border p-2" />
            </div>

            <div class="mb-4">
                <label>Address</label>
                <textarea name="address" class="w-full border p-2"></textarea>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const notyf = new Notyf();

        const customerId = "{{ $customerId }}";
        const form = document.getElementById('customer-edit-form');

        fetch('/api/list')
            .then(res => res.json())
            .then(data => {
                const customer = data.customers.find(c => c.id == customerId);
                if (customer) {
                    form.querySelector('input[name="name"]').value = customer.name;
                    form.querySelector('input[name="phone"]').value = customer.phone;
                    form.querySelector('input[name="email"]').value = customer.email;
                    form.querySelector('textarea[name="address"]').value = customer.address;
                }
            });

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const payload = {
                type: 'customer',
                id: customerId,
                data: {
                    name: form.querySelector('input[name="name"]').value,
                    phone: form.querySelector('input[name="phone"]').value,
                    email: form.querySelector('input[name="email"]').value,
                    address: form.querySelector('textarea[name="address"]').value
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
                if (data.customer) {
                    notyf.success('Customer updated successfully!');
                    setTimeout(() => window.location.href = '/customers', 1000);
                } else if(data.errors) {
                        notyf.error(Object.values(data.errors).join('\n'));
                    } else {
                        notyf.error(data.error || 'Failed to update customer');
                }
            })
            .catch(err => alert('An error occurred: ' + err.message));
        });
    });
    </script>
</x-app-layout>
