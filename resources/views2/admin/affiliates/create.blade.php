@extends('admin.layouts.app')

@section('content')
<div class="bg-white p-4 sm:p-6 rounded-lg card-shadow">
    <h2 class="text-xl sm:text-2xl font-bold mb-6 text-gray-800">Add New Affiliate Provider</h2>
    <form id="affiliateForm">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="name" class="block text-gray-700 font-medium mb-1">Provider Name</label>
                <input type="text" id="name" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label for="base_url" class="block text-gray-700 font-medium mb-1">Base URL</label>
                <input type="url" id="base_url" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label for="callback_secret" class="block text-gray-700 font-medium mb-1">Callback Secret</label>
                <input type="text" id="callback_secret" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="status" class="block text-gray-700 font-medium mb-1">Status</label>
                <select id="status" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
        <div class="mt-6 flex space-x-4">
            <button type="submit" class="btn-primary text-white px-4 py-2 rounded-lg font-medium">Add Provider</button>
            <a href="{{ route('admin.affiliates.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg font-medium">Cancel</a>
        </div>
    </form>
    <div id="error" class="text-red-500 mt-4 hidden"></div>
</div>

<script>
    document.getElementById('affiliateForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = {
            name: document.getElementById('name').value,
            base_url: document.getElementById('base_url').value,
            callback_secret: document.getElementById('callback_secret').value,
            status: document.getElementById('status').value
        };
        const errorDiv = document.getElementById('error');

        try {
            const response = await fetch('/api/admin/affiliates', {
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
                window.location.href = '{{ route("admin.affiliates.index") }}';
            } else {
                errorDiv.textContent = result.message || 'Failed to add provider';
                errorDiv.classList.remove('hidden');
            }
        } catch (error) {
            errorDiv.textContent = 'Error adding provider';
            errorDiv.classList.remove('hidden');
        }
    });
</script>
@endsection