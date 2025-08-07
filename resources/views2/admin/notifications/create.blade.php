@extends('admin.layouts.app')

@section('content')
<div class="bg-white p-4 sm:p-6 rounded-lg card-shadow">
    <h2 class="text-xl sm:text-2xl font-bold mb-6 text-gray-800">Add New Notification</h2>
    <form id="notificationForm">
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label for="title" class="block text-gray-700 font-medium mb-1">Title</label>
                <input type="text" id="title" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label for="message" class="block text-gray-700 font-medium mb-1">Message</label>
                <textarea id="message" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4" required></textarea>
            </div>
            <div>
                <label for="user_id" class="block text-gray-700 font-medium mb-1">User (Optional)</label>
                <select id="user_id" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select User (or leave blank for all)</option>
                </select>
            </div>
        </div>
        <div class="mt-6 flex space-x-4">
            <button type="submit" class="btn-primary text-white px-4 py-2 rounded-lg font-medium">Send Notification</button>
            <a href="{{ route('admin.notifications.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg font-medium text-sm sm:text-base">Cancel</a>
        </div>
    </form>
    <div id="error" class="text-red-500 mt-4 hidden"></div>
</div>

<script>
    async function fetchUsers() {
        try {
            const response = await fetch('/api/admin/users', {
                headers: { 'Authorization': `Bearer ${localStorage.getItem('admin_token')}`, 'Accept': 'application/json' }
            });
            const result = await response.json();
            if (result.status) {
                const select = document.getElementById('user_id');
                result.data.data.forEach(user => {
                    const option = document.createElement('option');
                    option.value = user.id;
                    option.textContent = user.name || user.email || user.mobile || `User ${user.id}`;
                    select.appendChild(option);
                });
            }
        } catch (error) {
            document.getElementById('error').textContent = 'Failed to load users';
            document.getElementById('error').classList.remove('hidden');
        }
    }

    document.getElementById('notificationForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = {
            title: document.getElementById('title').value,
            message: document.getElementById('message').value,
            user_id: document.getElementById('user_id').value || null
        };
        const errorDiv = document.getElementById('error');

        try {
            const response = await fetch('/api/admin/notifications', {
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
                window.location.href = '{{ route("admin.notifications.index") }}';
            } else {
                errorDiv.textContent = result.message || 'Failed to send notification';
                errorDiv.classList.remove('hidden');
            }
        } catch (error) {
            errorDiv.textContent = 'Error sending notification';
            errorDiv.classList.remove('hidden');
        }
    });

    fetchUsers();
</script>
@endsection