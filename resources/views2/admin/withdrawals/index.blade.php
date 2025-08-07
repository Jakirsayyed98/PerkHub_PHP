@extends('admin.layouts.app')

@section('content')
<div class="bg-white p-4 sm:p-6 rounded-lg card-shadow">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Withdrawal Requests</h2>
    </div>
    <div class="mb-4">
        <input type="text" id="search" placeholder="Search withdrawals..." class="w-full sm:w-1/2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="p-3 text-left text-sm sm:text-base">ID</th>
                    <th class="p-3 text-left text-sm sm:text-base">User</th>
                    <th class="p-3 text-left text-sm sm:text-base">Amount</th>
                    <th class="p-3 text-left text-sm sm:text-base">Method</th>
                    <th class="p-3 text-left text-sm sm:text-base">Status</th>
                    <th class="p-3 text-left text-sm sm:text-base">Requested At</th>
                    <th class="p-3 text-left text-sm sm:text-base">Actions</th>
                </tr>
            </thead>
            <tbody id="withdrawalsTable"></tbody>
        </table>
    </div>
    <div id="pagination" class="mt-4 flex flex-col sm:flex-row justify-between items-center"></div>
</div>

<script>
    let currentPage = 1;

    async function fetchWithdrawals(page = 1, search = '') {
        try {
            const response = await fetch(`/api/admin/withdrawals?page=${page}&search=${search}`, {
                headers: { 'Authorization': `Bearer ${localStorage.getItem('admin_token')}`, 'Accept': 'application/json' }
            });
            const result = await response.json();
            if (result.status) {
                const tableBody = document.getElementById('withdrawalsTable');
                tableBody.innerHTML = '';
                result.data.data.forEach(withdrawal => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="p-3 text-sm sm:text-base">${withdrawal.id}</td>
                        <td class="p-3 text-sm sm:text-base">${withdrawal.user ? withdrawal.user.name : '-'}</td>
                        <td class="p-3 text-sm sm:text-base">${withdrawal.amount}</td>
                        <td class="p-3 text-sm sm:text-base">${withdrawal.method}</td>
                        <td class="p-3 text-sm sm:text-base">${withdrawal.status}</td>
                        <td class="p-3 text-sm sm:text-base">${new Date(withdrawal.requested_at).toLocaleString()}</td>
                        <td class="p-3">
                            ${withdrawal.status === 'pending' ? `
                                <select onchange="reviewWithdrawal(${withdrawal.id}, this.value)" class="p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-base">
                                    <option value="">Select Action</option>
                                    <option value="approved">Approve</option>
                                    <option value="rejected">Reject</option>
                                </select>
                            ` : ''}
                        </td>
                    `;
                    tableBody.appendChild(row);
                });

                const pagination = document.getElementById('pagination');
                pagination.innerHTML = `
                    <button onclick="fetchWithdrawals(${result.data.current_page - 1})" ${result.data.current_page === 1 ? 'disabled' : ''} class="px-4 py-2 bg-gray-200 rounded disabled:opacity-50 text-sm sm:text-base">Previous</button>
                    <span class="text-gray-700 text-sm sm:text-base">Page ${result.data.current_page} of ${result.data.last_page}</span>
                    <button onclick="fetchWithdrawals(${result.data.current_page + 1})" ${result.data.current_page === result.data.last_page ? 'disabled' : ''} class="px-4 py-2 bg-gray-200 rounded disabled:opacity-50 text-sm sm:text-base">Next</button>
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

    async function reviewWithdrawal(id, status) {
        if (!status) return;
        const adminNote = prompt('Enter admin note (optional):');
        try {
            const response = await fetch(`/api/admin/withdrawals/${id}/review`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('admin_token')}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status, admin_note: adminNote })
            });
            const result = await response.json();
            if (result.status) {
                fetchWithdrawals(currentPage);
            } else {
                alert(result.message || 'Failed to review withdrawal');
            }
        } catch (error) {
            alert('Error reviewing withdrawal');
        }
    }

    document.getElementById('search').addEventListener('input', (e) => {
        currentPage = 1;
        fetchWithdrawals(currentPage, e.target.value);
    });

    fetchWithdrawals();
</script>
@endsection