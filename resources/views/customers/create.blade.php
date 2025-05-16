<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Add Customer</h2>
    </x-slot>

    <div class="p-6">
        <form id="customer-form">
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

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const notyf = new Notyf();

            document.getElementById('customer-form').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = {
                    type: 'customer',
                    data: {
                        name: this.name.value,
                        phone: this.phone.value,
                        email: this.email.value,
                        address: this.address.value
                    }
                };

                fetch('/api/create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(formData)
                })
                .then(res => res.json())
                .then(data => {
                    if(data.message === 'Customer created') {
                        notyf.success('Customer created successfully!');
                        setTimeout(() => window.location.href = '/customers', 1000);
                    } else if(data.errors) {
                        notyf.error(Object.values(data.errors).join('\n'));
                    } else {
                        notyf.error(data.error || 'Failed to create customer');
                    }
                })
                .catch(err => alert('An error occurred: ' + err.message));
            });
        });
    </script>
</x-app-layout>