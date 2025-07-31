@extends('admin.layouts.app')

@section('content')
<div class="bg-white p-4 sm:p-6 rounded-lg card-shadow">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Users</h2>
    </div>
    <div class="mb-4">
        <input type="text" id="search" placeholder="Search users..." class="w-full sm:w-1/2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="p-3 text-left text-sm sm:text-base">ID</th>
                    <th class="p-3 text-left text-sm sm:text-base">Name</th>
                    <th class="p-3 text-left text-sm sm:text-base">Email</th>
                    <th class="p-3 text-left text-sm sm:text-base">Mobile</th>
                    <th class="p-3 text-left text-sm sm:text-base">Orders</th>
                    <th class="p-3 text-left text-sm sm:text-base">Withdrawals</th>
                    <th class="p-3 text-left text-sm sm:text-base">Tickets</th>
                    <th class="p-3 text-left text-sm sm:text-base">Actions</th>
                </tr>
            </thead>
            <tbody id="usersTable"></tbody>
        </table>
    </div>
    <div id="pagination" class="mt-4 flex flex-col sm:flex-row justify-between items-center"></div>
</div>

<script>
    let currentPage = 1;

    async function fetchUsers(page = 1, search = '') {
        try {
            const response = await fetch(`/api/admin/users?page=${page}&search=${search}`, {
                headers: { 'Authorization': `Bearer ${localStorage.getItem('admin_token')}`, 'Accept': 'application/json' }
            });
            const result = await response.json();
            if (result.status) {
                const tableBody = document.getElementById('usersTable');
                tableBody.innerHTML = '';
                result.data.data.forEach(user => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="p-3 text-sm sm:text-base">${user.id}</td>
                        <td class="p-3 text-sm sm:text-base">${user.name || '-'}</td>
                        <td class="p-3 text-sm sm:text-base">${user.email || '-'}</td>
                        <td class="p-3 text-sm sm:text-base">${user.mobile || '-'}</td>
                        <td class="p-3 text-sm sm:text-base">${user.orders_count}</td>
                        <td class="p-3 text-sm sm:text-base">${user.withdrawal_requests_count}</td>
                        <td class="p-3 text-sm sm:text-base">${user.support_tickets_count}</td>
                        <td class="p-3">
                            <a href="/admin/users/${user.id}" class="text-blue-500 hover:underline text-sm sm:text-base">View</a>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });

                const pagination = document.getElementById('pagination');
                pagination.innerHTML = `
                    <button onclick="fetchUsers(${result.data.current_page - 1})" ${result.data.current_page === 1 ? 'disabled' : ''} class="px-4 py-2 bg-gray-200 rounded disabled:opacity-50 text-sm sm:text-base">Previous</button>
                    <span class="text-gray-700 text-sm sm:text-base">Page ${result.data.current_page} of ${result.data.last_page}</span>
                    <button onclick="fetchUsers(${result.data.current_page + 1})" ${result.data.current_page === result.data.last_page ? 'disabled' : ''} class="px-4 py-2 bg-gray-200 rounded disabled:opacity-50 text-sm sm:text-base">Next</button>
                `;
            } else {
                localStorage.removeItem('admin_token');
                window.location.href = '{{ route("admin.login") }}';
            }
        } catch (error) {
            localStorage.removeItem('admin_token');
            window.location.href = '{{ route("admin.login") }}';
        }
    }

    document.getElementById('search').addEventListener('input', (e) => {
        currentPage = 1;
        fetchUsers(currentPage, e.target.value);
    });

    fetchUsers();
</script>
@endsection