@extends('admin.layouts.app')

@section('content')
<div class="bg-white p-4 sm:p-6 rounded-lg card-shadow">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Affiliate Providers</h2>
        <a href="{{ route('admin.affiliates.create') }}" class="btn-primary text-white px-4 py-2 rounded-lg font-medium mt-2 sm:mt-0">Add New Provider</a>
    </div>
    <div class="mb-4">
        <input type="text" id="search" placeholder="Search providers..." class="w-full sm:w-1/2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="p-3 text-left text-sm sm:text-base">ID</th>
                    <th class="p-3 text-left text-sm sm:text-base">Name</th>
                    <th class="p-3 text-left text-sm sm:text-base">Base URL</th>
                    <th class="p-3 text-left text-sm sm:text-base">Status</th>
                    <th class="p-3 text-left text-sm sm:text-base">Actions</th>
                </tr>
            </thead>
            <tbody id="affiliatesTable"></tbody>
        </table>
    </div>
    <div id="pagination" class="mt-4 flex flex-col sm:flex-row justify-between items-center"></div>
</div>

<script>
    let currentPage = 1;

    async function fetchAffiliates(page = 1, search = '') {
        try {
            const response = await fetch(`/api/admin/affiliates?page=${page}&search=${search}`, {
                headers: { 'Authorization': `Bearer ${localStorage.getItem('admin_token')}`, 'Accept': 'application/json' }
            });
            const result = await response.json();
            if (result.status) {
                const tableBody = document.getElementById('affiliatesTable');
                tableBody.innerHTML = '';
                result.data.data.forEach(provider => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="p-3 text-sm sm:text-base">${provider.id}</td>
                        <td class="p-3 text-sm sm:text-base">${provider.name}</td>
                        <td class="p-3 text-sm sm:text-base">${provider.base_url}</td>
                        <td class="p-3">
                            <select onchange="updateStatus(${provider.id}, this.value)" class="p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-base">
                                <option value="active" ${provider.status === 'active' ? 'selected' : ''}>Active</option>
                                <option value="inactive" ${provider.status === 'inactive' ? 'selected' : ''}>Inactive</option>
                            </select>
                        </td>
                        <td class="p-3 flex space-x-2">
                            <a href="/admin/affiliates/${provider.id}/edit" class="text-blue-500 hover:underline text-sm sm:text-base">Edit</a>
                            <button onclick="deleteAffiliate(${provider.id})" class="text-red-500 hover:underline text-sm sm:text-base">Delete</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });

                const pagination = document.getElementById('pagination');
                pagination.innerHTML = `
                    <button onclick="fetchAffiliates(${result.data.current_page - 1})" ${result.data.current_page === 1 ? 'disabled' : ''} class="px-4 py-2 bg-gray-200 rounded disabled:opacity-50 text-sm sm:text-base">Previous</button>
                    <span class="text-gray-700 text-sm sm:text-base">Page ${result.data.current_page} of ${result.data.last_page}</span>
                    <button onclick="fetchAffiliates(${result.data.current_page + 1})" ${result.data.current_page === result.data.last_page ? 'disabled' : ''} class="px-4 py-2 bg-gray-200 rounded disabled:opacity-50 text-sm sm:text-base">Next</button>
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

    async function updateStatus(id, status) {
        try {
            const response = await fetch(`/api/admin/affiliates/${id}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('admin_token')}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status })
            });
            const result = await response.json();
            if (!result.status) {
                alert(result.message || 'Failed to update status');
                fetchAffiliates(currentPage);
            }
        } catch (error) {
            alert('Error updating status');
            fetchAffiliates(currentPage);
        }
    }

    async function deleteAffiliate(id) {
        if (confirm('Are you sure you want to delete this affiliate provider?')) {
            try {
                const response = await fetch(`/api/admin/affiliates/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('admin_token')}`,
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const result = await response.json();
                if (result.status) {
                    fetchAffiliates(currentPage);
                } else {
                    alert(result.message || 'Failed to delete provider');
                }
            } catch (error) {
                alert('Error deleting provider');
            }
        }
    }

    document.getElementById('search').addEventListener('input', (e) => {
        currentPage = 1;
        fetchAffiliates(currentPage, e.target.value);
    });

    fetchAffiliates();
</script>
@endsection