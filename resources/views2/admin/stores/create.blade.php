@extends('admin.layouts.app')

@section('content')
<div class="bg-white p-4 sm:p-6 rounded-lg card-shadow">
    <h2 class="text-xl sm:text-2xl font-bold mb-6 text-gray-800">Add New Store</h2>
    <form id="storeForm">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="name" class="block text-gray-700 font-medium mb-1">Store Name</label>
                <input type="text" id="name" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label for="affiliate_provider_id" class="block text-gray-700 font-medium mb-1">Affiliate Provider</label>
                <select id="affiliate_provider_id" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Select Provider</option>
                </select>
            </div>
            <div>
                <label for="icon" class="block text-gray-700 font-medium mb-1">Icon URL</label>
                <input type="url" id="icon" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="logo" class="block text-gray-700 font-medium mb-1">Logo URL</label>
                <input type="url" id="logo" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="banner" class="block text-gray-700 font-medium mb-1">Banner URL</label>
                <input type="url" id="banner" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="cashback" class="block text-gray-700 font-medium mb-1">Cashback (%)</label>
                <input type="number" id="cashback" step="0.01" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label for="active" class="block text-gray-700 font-medium mb-1">Status</label>
                <select id="active" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>
        <div class="mt-4">
            <label for="about_store" class="block text-gray-700 font-medium mb-1">About Store</label>
            <textarea id="about_store" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4"></textarea>
        </div>
        <div class="mt-4">
            <label for="terms_and_conditions" class="block text-gray-700 font-medium mb-1">Terms & Conditions</label>
            <textarea id="terms_and_conditions" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4"></textarea>
        </div>
        <div class="mt-4">
            <label for="label" class="block text-gray-700 font-medium mb-1">Label</label>
            <input type="text" id="label" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mt-6 flex space-x-4">
            <button type="submit" class="btn-primary text-white px-4 py-2 rounded-lg font-medium">Add Store</button>
            <a href="{{ route('admin.stores.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg font-medium">Cancel</a>
        </div>
    </form>
    <div id="error" class="text-red-500 mt-4 hidden"></div>
</div>

<script>
    async function fetchProviders() {
        try {
            const response = await fetch('/api/admin/affiliates', {
                headers: { 'Authorization': `Bearer ${localStorage.getItem('admin_token')}`, 'Accept': 'application/json' }
            });
            const result = await response.json();
            if (result.status) {
                const select = document.getElementById('affiliate_provider_id');
                result.data.data.forEach(provider => {
                    const option = document.createElement('option');
                    option.value = provider.id;
                    option.textContent = provider.name;
                    select.appendChild(option);
                });
            }
        } catch (error) {
            document.getElementById('error').textContent = 'Failed to load affiliate providers';
            document.getElementById('error').classList.remove('hidden');
        }
    }

    document.getElementById('storeForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = {
            name: document.getElementById('name').value,
            affiliate_provider_id: document.getElementById('affiliate_provider_id').value,
            icon: document.getElementById('icon').value,
            logo: document.getElementById('logo').value,
            banner: document.getElementById('banner').value,
            about_store: document.getElementById('about_store').value,
            terms_and_conditions: document.getElementById('terms_and_conditions').value,
            label: document.getElementById('label').value,
            cashback: document.getElementById('cashback').value,
            active: document.getElementById('active').value === '1'
        };
        const errorDiv = document.getElementById('error');

        try {
            const response = await fetch('/api/admin/stores', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('admin_token')}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(formData)
            });
            const result = await response.json();
            if (result.status) {
                window.location.href = '{{ route("admin.stores.index") }}';
            } else {
                errorDiv.textContent = result.message || 'Failed to add store';
                errorDiv.classList.remove('hidden');
            }
        } catch (error) {
            errorDiv.textContent = 'Error adding store';
            errorDiv.classList.remove('hidden');
        }
    });

    fetchProviders();
</script>
@endsection