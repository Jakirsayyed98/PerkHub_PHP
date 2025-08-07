@extends('admin.layouts.app')

@section('content')
<div class="bg-white p-4 sm:p-6 rounded-lg card-shadow">
    <h2 class="text-xl sm:text-2xl font-bold mb-6 text-gray-800">User Details</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-700 font-medium mb-1">ID</label>
            <p id="id" class="p-3 bg-gray-100 rounded-lg text-sm sm:text-base"></p>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-1">Name</label>
            <p id="name" class="p-3 bg-gray-100 rounded-lg text-sm sm:text-base"></p>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-1">Email</label>
            <p id="email" class="p-3 bg-gray-100 rounded-lg text-sm sm:text-base"></p>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-1">Mobile</label>
            <p id="mobile" class="p-3 bg-gray-100 rounded-lg text-sm sm:text-base"></p>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-1">Gender</label>
            <p id="gender" class="p-3 bg-gray-100 rounded-lg text-sm sm:text-base"></p>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-1">Date of Birth</label>
            <p id="dob" class="p-3 bg-gray-100 rounded-lg text-sm sm:text-base"></p>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-1">Orders</label>
            <p id="orders_count" class="p-3 bg-gray-100 rounded-lg text-sm sm:text-base"></p>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-1">Withdrawal Requests</label>
            <p id="withdrawal_requests_count" class="p-3 bg-gray-100 rounded-lg text-sm sm:text-base"></p>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-1">Support Tickets</label>
            <p id="support_tickets_count" class="p-3 bg-gray-100 rounded-lg text-sm sm:text-base"></p>
        </div>
    </div>
    <div class="mt-6">
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg font-medium text-sm sm:text-base">Back to Users</a>
    </div>
</div>

<script>
    async function fetchUser() {
        const id = window.location.pathname.split('/').pop();
        try {
            const response = await fetch(`/api/admin/users/${id}`, {
                headers: { 'Authorization': `Bearer ${localStorage.getItem('admin_token')}`, 'Accept': 'application/json' }
            });
            const result = await response.json();
            if (result.status) {
                document.getElementById('id').textContent = result.data.id;
                document.getElementById('name').textContent = result.data.name || '-';
                document.getElementById('email').textContent = result.data.email || '-';
                document.getElementById('mobile').textContent = result.data.mobile || '-';
                document.getElementById('gender').textContent = result.data.gender || '-';
                document.getElementById('dob').textContent = result.data.dob || '-';
                document.getElementById('orders_count').textContent = result.data.orders_count;
                document.getElementById('withdrawal_requests_count').textContent = result.data.withdrawal_requests_count;
                document.getElementById('support_tickets_count').textContent = result.data.support_tickets_count;
            } else {
                window.location.href = '{{ route("admin.login") }}';
            }
        } catch (error) {
            window.location.href = '{{ route("admin.login") }}';
        }
    }

    fetchUser();
</script>
@endsection