@extends('admin.layouts.app')

@section('content')
<div class="bg-white p-4 sm:p-6 rounded-lg card-shadow">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Stores</h2>
        <a href="{{ route('admin.stores.create') }}" class="btn-primary text-white px-4 py-2 rounded-lg font-medium mt-2 sm:mt-0">Add New Store</a>
    </div>
    <div class="mb-4">
        <input type="text" id="search" placeholder="Search stores..." class="w-full sm:w-1/2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="p-3 text-left text-sm sm:text-base">ID</th>
                    <th class="p-3 text-left text-sm sm:text-base">Name</th>
                    <th class="p-3 text-left text-sm sm:text-base">Affiliate Provider</th>
                    <th class="p-3 text-left text-sm sm:text-base">Cashback</th>
                    <th class="p-3 text-left text-sm sm:text-base">Status</th>
                    <th class="p-3 text-left text-sm sm:text-base">Actions</th>
                </tr>
            </thead>
            <tbody id="storesTable"></tbody>
        </table>
    </div>
    <div id="pagination" class="mt-4 flex flex-col sm:flex-row justify-between items-center"></div>
</div>

<script>
    let currentPage = 1;

    async function fetchStores(page = 1, search = '') {
        try {
            const response = await fetch(`/api/admin/stores?page=${page}&search=${search}`, {
                headers: { 'Authorization': `Bearer ${localStorage.getItem('admin_token')}`, 'Accept': 'application/json' }
            });
            const result = await response.json();
            if (result.status) {
                const tableBody = document.getElementById('storesTable');
                tableBody.innerHTML = '';
                result.data.data.forEach(store => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="p-3 text-sm sm:text-base">${store.id}</td>
                        <td class="p-3 text-sm sm:text-base">${store.name}</td>
                        <td class="p-3 text-sm sm:text-base">${store.affiliate_provider ? store.affiliate_provider.name : '-'}</td>
                        <td class="p-3 text-sm sm:text-base">${store.cashback}%</td>
                        <td class="p-3">
                            <select onchange="updateStatus(${store.id}, this.value)" class="p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-base">
                                <option value="1" ${store.active ? 'selected' : ''}>Active</option>
                                <option value="0" ${!store.active ? 'selected' : ''}>Inactive</option>
                            </select>
                        </td>
                        <td class="p-3 flex space-x-2">
                            <a href="/admin/stores/${store.id}/edit" class="text-blue-500 hover:underline text-sm sm:text-base">Edit</a>
                            <button onclick="deleteStore(${store.id})" class="text-red-500 hover:underline text-sm sm:text-base">Delete</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });

                const pagination = document.getElementById('pagination');
                pagination.innerHTML = `
                    <button onclick="fetchStores(${result.data.current_page - 1})" ${result.data.current_page === 1 ? 'disabled' : ''} class="px-4 py-2 bg-gray-200 rounded disabled:opacity-50 text-sm sm:text-base">Previous</button>
                    <span class="text-gray-700 text-sm sm:text-base">Page ${result.data.current_page} of ${result.data.last_page}</span>
                    <button onclick="fetchStores(${result.data.current_page + 1})" ${result.data.current_page === result.data.last_page ? 'disabled' : ''} class="px-4 py-2 bg-gray-200 rounded disabled:opacity-50 text-sm sm:text-base">Next</button>
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

    async function updateStatus(id, active) {
        try {
            const response = await fetch(`/api/admin/stores/${id}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('admin_token')}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ active: active === '1' })
            });
            const result = await response.json();
            if (!result.status) {
                alert(result.message || 'Failed to update status');
                fetchStores(currentPage);
            }
        } catch (error) {
            alert('Error updating status');
            fetchStores(currentPage);
        }
    }

    async function deleteStore(id) {
        if (confirm('Are you sure you want to delete this store?')) {
            try {
                const response = await fetch(`/api/admin/stores/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('admin_token')}`,
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const result = await response.json();
                if (result.status) {
                    fetchStores(currentPage);
                } else {
                    alert(result.message || 'Failed to delete store');
                }
            } catch (error) {
                alert('Error deleting store');
            }
        }
    }

    document.getElementById('search').addEventListener('input', (e) => {
        currentPage = 1;
        fetchStores(currentPage, e.target.value);
    });

    fetchStores();
</script>
@endsection