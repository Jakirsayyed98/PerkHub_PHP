@extends('admin.layouts.app')

@section('content')
<div class="bg-white p-4 sm:p-6 rounded-lg card-shadow">
    <h2 class="text-xl sm:text-2xl font-bold mb-6 text-gray-800">Dashboard</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-blue-50 p-4 rounded-lg card-shadow">
            <h3 class="text-base sm:text-lg font-semibold text-gray-700">Stores</h3>
            <p id="store_count" class="text-xl sm:text-2xl font-bold text-blue-600">0</p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg card-shadow">
            <h3 class="text-base sm:text-lg font-semibold text-gray-700">Affiliate Providers</h3>
            <p id="affiliate_count" class="text-xl sm:text-2xl font-bold text-green-600">0</p>
        </div>
        <div class="bg-yellow-50 p-4 rounded-lg card-shadow">
            <h3 class="text-base sm:text-lg font-semibold text-gray-700">Users</h3>
            <p id="user_count" class="text-xl sm:text-2xl font-bold text-yellow-600">0</p>
        </div>
        <div class="bg-purple-50 p-4 rounded-lg card-shadow">
            <h3 class="text-base sm:text-lg font-semibold text-gray-700">Transactions</h3>
            <p id="transaction_count" class="text-xl sm:text-2xl font-bold text-purple-600">0</p>
        </div>
        <div class="bg-red-50 p-4 rounded-lg card-shadow">
            <h3 class="text-base sm:text-lg font-semibold text-gray-700">Withdrawal Requests</h3>
            <p id="withdrawal_request_count" class="text-xl sm:text-2xl font-bold text-red-600">0</p>
        </div>
    </div>
</div>

<script>
    async function fetchDashboardData() {
        try {
            const response = await fetch('/api/admin/dashboard', {
                headers: { 'Authorization': `Bearer ${localStorage.getItem('admin_token')}`, 'Accept': 'application/json' }
            });
            const result = await response.json();
            if (result.status) {
                document.getElementById('store_count').textContent = result.data.store_count || 0;
                document.getElementById('affiliate_count').textContent = result.data.affiliate_count || 0;
                document.getElementById('user_count').textContent = result.data.user_count || 0;
                document.getElementById('transaction_count').textContent = result.data.transaction_count || 0;
                document.getElementById('withdrawal_request_count').textContent = result.data.withdrawal_request_count || 0;
            } else {
                localStorage.removeItem('admin_token');
                window.location.href = '{{ route("admin.login") }}';
            }
        } catch (error) {
            localStorage.removeItem('admin_token');
            window.location.href = '{{ route("admin.login") }}';
        }
    }
    fetchDashboardData();
</script>
@endsection