<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PerkHub Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .gradient-bg { background: linear-gradient(135deg, #1e3a8a, #3b82f6); }
        .sidebar { min-width: 250px; }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="sidebar bg-gray-800 text-white p-4">
            <h2 class="text-2xl font-bold mb-6">PerkHub Admin</h2>
            <nav>
                <ul>
                    <li><a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Dashboard</a></li>
                    <li><a href="{{ route('admin.stores.index') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Stores</a></li>
                    <li><a href="{{ route('admin.affiliates.index') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Affiliates</a></li>
                    <li><a href="{{ route('admin.users.index') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Users</a></li>
                    <li><a href="{{ route('admin.withdrawals.index') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Withdrawals</a></li>
                    <li><a href="{{ route('admin.tickets.index') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Tickets</a></li>
                    <li><a href="{{ route('admin.notifications.index') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Notifications</a></li>
                    <li><a href="#" onclick="logout()" class="block py-2 px-4 hover:bg-gray-700 rounded">Logout</a></li>
                </ul>
            </nav>
        </div>
        <!-- Content -->
        <div class="flex-1 p-6">
            @yield('content')
        </div>
    </div>
    <script>
        function logout() {
            localStorage.removeItem('admin_token');
            window.location.href = '{{ route("admin.login") }}';
        }
    </script>
</body>
</html>