<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PerkHub Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .sidebar {
            transition: transform 0.3s ease-in-out;
            z-index: 50;
        }
        .sidebar-hidden {
            transform: translateX(-100%);
        }
        .sidebar-active {
            transform: translateX(0);
        }
        .content-shift {
            transition: margin-left 0.3s ease-in-out;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar-active {
                transform: translateX(0);
            }
            .content-shift {
                margin-left: 0 !important;
            }
        }
        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        }
        .card-shadow {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        .btn-primary {
            background: linear-gradient(90deg, #2563eb, #1e40af);
            transition: background 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #1e40af, #2563eb);
        }
        .nav-link {
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        .nav-link:hover, .nav-link.active {
            background-color: #1f2937;
            color: #ffffff;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar w-64 bg-gray-900 text-white fixed h-full lg:static lg:translate-x-0">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-white">PerkHub Admin</h1>
            </div>
            <nav class="mt-4">
                <a href="{{ route('admin.dashboard') }}" class="nav-link block py-3 px-6 text-gray-200 {{ Route::is('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.stores.index') }}" class="nav-link block py-3 px-6 text-gray-200 {{ Route::is('admin.stores.*') ? 'active' : '' }}">Stores</a>
                <a href="{{ route('admin.affiliates.index') }}" class="nav-link block py-3 px-6 text-gray-200 {{ Route::is('admin.affiliates.*') ? 'active' : '' }}">Affiliate Providers</a>
                <a href="{{ route('admin.users.index') }}" class="nav-link block py-3 px-6 text-gray-200 {{ Route::is('admin.users.*') ? 'active' : '' }}">Users</a>
                <a href="{{ route('admin.withdrawals.index') }}" class="nav-link block py-3 px-6 text-gray-200 {{ Route::is('admin.withdrawals.*') ? 'active' : '' }}">Withdrawals</a>
                <a href="{{ route('admin.tickets.index') }}" class="nav-link block py-3 px-6 text-gray-200 {{ Route::is('admin.tickets.*') ? 'active' : '' }}">Support Tickets</a>
                <a href="{{ route('admin.notifications.index') }}" class="nav-link block py-3 px-6 text-gray-200 {{ Route::is('admin.notifications.*') ? 'active' : '' }}">Notifications</a>
                <a href="#" onclick="logout()" class="nav-link block py-3 px-6 text-gray-200">Logout</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-64 content-shift">
            <header class="bg-white shadow p-4 flex justify-between items-center">
                <button id="toggleSidebar" class="lg:hidden text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600 font-medium">{{ auth()->user()->name }}</span>
                    <div class="gradient-bg w-10 h-10 rounded-full flex items-center justify-center text-white font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </header>
            <main class="p-4 sm:p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        const token = localStorage.getItem('admin_token');
        if (!token) {
            window.location.href = '{{ route("admin.login") }}';
        }

        fetch('/api/admin/dashboard', {
            headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
        }).catch(() => {
            localStorage.removeItem('admin_token');
            window.location.href = '{{ route("admin.login") }}';
        });

        document.getElementById('toggleSidebar').addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('sidebar-hidden');
            sidebar.classList.toggle('sidebar-active');
        });

        function logout() {
            fetch('/api/admin/logout', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(() => {
                localStorage.removeItem('admin_token');
                window.location.href = '{{ route("admin.login") }}';
            });
        }
    </script>
</body>
</html>