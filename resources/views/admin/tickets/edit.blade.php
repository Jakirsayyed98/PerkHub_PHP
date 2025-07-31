@extends('admin.layouts.app')

@section('content')
<div class="bg-white p-4 sm:p-6 rounded-lg card-shadow">
    <h2 class="text-xl sm:text-2xl font-bold mb-6 text-gray-800">Support Ticket Details</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-700 font-medium mb-1">ID</label>
            <p id="id" class="p-3 bg-gray-100 rounded-lg text-sm sm:text-base"></p>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-1">User</label>
            <p id="user" class="p-3 bg-gray-100 rounded-lg text-sm sm:text-base"></p>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-1">Subject</label>
            <p id="subject" class="p-3 bg-gray-100 rounded-lg text-sm sm:text-base"></p>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-1">Status</label>
            <select id="status" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-base">
                <option value="open">Open</option>
                <option value="in_progress">In Progress</option>
                <option value="closed">Closed</option>
            </select>
        </div>
        <div class="sm:col-span-2">
            <label class="block text-gray-700 font-medium mb-1">Description</label>
            <p id="description" class="p-3 bg-gray-100 rounded-lg text-sm sm:text-base"></p>
        </div>
        <div class="sm:col-span-2">
            <label for="admin_note" class="block text-gray-700 font-medium mb-1">Admin Note</label>
            <textarea id="admin_note" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4"></textarea>
        </div>
    </div>
    <div class="mt-6 flex space-x-4">
        <button onclick="updateTicket()" class="btn-primary text-white px-4 py-2 rounded-lg font-medium">Update Ticket</button>
        <a href="{{ route('admin.tickets.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg font-medium text-sm sm:text-base">Back to Tickets</a>
    </div>
    <div id="error" class="text-red-500 mt-4 hidden"></div>
</div>

<script>
    async function fetchTicket() {
        const id = window.location.pathname.split('/').pop();
        try {
            const response = await fetch(`/api/admin/tickets/${id}`, {
                headers: { 'Authorization': `Bearer ${localStorage.getItem('admin_token')}`, 'Accept': 'application/json' }
            });
            const result = await response.json();
            if (result.status) {
                document.getElementById('id').textContent = result.data.id;
                document.getElementById('user').textContent = result.data.user ? result.data.user.name : '-';
                document.getElementById('subject').textContent = result.data.subject;
                document.getElementById('status').value = result.data.status;
                document.getElementById('description').textContent = result.data.description || '-';
                document.getElementById('admin_note').value = result.data.admin_note || '';
            } else {
                window.location.href = '{{ route("admin.login") }}';
            }
        } catch (error) {
            window.location.href = '{{ route("admin.login") }}';
        }
    }

    async function updateTicket() {
        const id = window.location.pathname.split('/').pop();
        const formData = {
            status: document.getElementById('status').value,
            admin_note: document.getElementById('admin_note').value
        };
        const errorDiv = document.getElementById('error');

        try {
            const response = await fetch(`/api/admin/tickets/${id}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('admin_token')}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(formData)
            });
            const result = await response.json();
            if (result.status) {
                window.location.href = '{{ route("admin.tickets.index") }}';
            } else {
                errorDiv.textContent = result.message || 'Failed to update ticket';
                errorDiv.classList.remove('hidden');
            }
        } catch (error) {
            errorDiv.textContent = 'Error updating ticket';
            errorDiv.classList.remove('hidden');
        }
    }

    fetchTicket();
</script>
@endsection