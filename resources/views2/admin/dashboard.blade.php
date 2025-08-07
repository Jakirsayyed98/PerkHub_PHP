@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-semibold">Stores</h3>
                <p id="store_count" class="text-2xl">0</p>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-semibold">Affiliates</h3>
                <p id="affiliate_count" class="text-2xl">0</p>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-semibold">Users</h3>
                <p id="user_count" class="text-2xl">0</p>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-semibold">Transactions</h3>
                <p id="transaction_count" class="text-2xl">0</p>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-semibold">Withdrawal Requests</h3>
                <p id="withdrawal_request_count" class="text-2xl">0</p>
            </div>
        </div>
    </div>

    <script>
        async function fetchDashboardData() {
            try {
                const response = await fetch('/api/admin/dashboard', {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('admin_token')}`,
                        'Accept': 'application/json'
                    }
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
                console.error('Dashboard fetch error:', error);
                localStorage.removeItem('admin_token');
                window.location.href = '{{ route("admin.login") }}';
            }
        }
        fetchDashboardData();
    </script>
@endsection