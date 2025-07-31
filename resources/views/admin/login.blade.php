<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - PerkHub</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .gradient-bg { background: linear-gradient(135deg, #1e3a8a, #3b82f6); }
        .card-shadow { box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); }
        .btn-primary { background: linear-gradient(90deg, #2563eb, #1e40af); transition: background 0.3s ease; }
        .btn-primary:hover { background: linear-gradient(90deg, #1e40af, #2563eb); }
        .btn-primary:disabled { background: #6b7280; cursor: not-allowed; }
        .error-message, .success-message { transition: opacity 0.3s ease; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen px-4">
    <div class="bg-white p-6 sm:p-8 rounded-lg card-shadow w-full max-w-md">
        <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-center text-gray-800">Admin Login</h2>
        <form id="loginForm">
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" id="email" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                <input type="password" id="password" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <button type="submit" id="submitBtn" class="w-full btn-primary text-white p-3 rounded-lg font-medium">Login</button>
        </form>
        <div id="error" class="text-red-500 mt-4 text-center hidden error-message"></div>
        <div id="success" class="text-green-500 mt-4 text-center hidden success-message"></div>
    </div>
    <script>
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            // Get form elements
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const submitBtn = document.getElementById('submitBtn');
            const errorDiv = document.getElementById('error');
            const successDiv = document.getElementById('success');

            // Reset feedback divs
            errorDiv.classList.add('hidden');
            errorDiv.textContent = '';
            successDiv.classList.add('hidden');
            successDiv.textContent = '';

            // Sanitize inputs
            const email = emailInput.value.trim().toLowerCase();
            const password = passwordInput.value;

            // Validate inputs
            if (!email || !password) {
                errorDiv.textContent = 'Please enter both email and password.';
                errorDiv.classList.remove('hidden');
                return;
            }

            // Disable button and show loading state
            submitBtn.disabled = true;
            submitBtn.textContent = 'Logging in...';

            console.log('Submitting:', { email, password });

            try {
                // Create abort controller for timeout
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 10000); // 10s timeout

                // Make API request
                const response = await fetch('/api/admin/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({ email, password }),
                    signal: controller.signal
                });

                clearTimeout(timeoutId); // Clear timeout on success

                console.log('Response status:', response.status);
                const result = await response.json();
                console.log('Response data:', result);

                // Handle response statuses
                if (response.status === 200 && result.status) {
                    localStorage.setItem('admin_token', result.data.token);
                    successDiv.textContent = 'Login successful! Redirecting...';
                    successDiv.classList.remove('hidden');
                    setTimeout(() => {
                        window.location.href = '/admin/dashboard';
                    }, 1000);
                } else if (response.status === 401) {
                    errorDiv.textContent = result.message || 'Invalid email or password.';
                    errorDiv.classList.remove('hidden');
                } else if (response.status === 419) {
                    errorDiv.textContent = 'Session expired. Please refresh the page and try again.';
                    errorDiv.classList.remove('hidden');
                } else if (response.status === 404) {
                    errorDiv.textContent = 'Login endpoint not found. Please check server configuration.';
                    errorDiv.classList.remove('hidden');
                } else if (response.status >= 500) {
                    errorDiv.textContent = 'Server error. Please try again later or contact support.';
                    errorDiv.classList.remove('hidden');
                } else {
                    errorDiv.textContent = result.message || 'An unexpected error occurred.';
                    errorDiv.classList.remove('hidden');
                }
            } catch (error) {
                console.error('Fetch error:', error);
                let errorMessage = 'Error during login: Unable to connect to the server.';
                if (error.name === 'AbortError') {
                    errorMessage = 'Request timed out. Please try again.';
                } else if (error.message.includes('Failed to fetch')) {
                    errorMessage = 'Network error. Ensure the server is running and try again.';
                }
                errorDiv.textContent = errorMessage;
                errorDiv.classList.remove('hidden');
            } finally {
                // Re-enable button
                submitBtn.disabled = false;
                submitBtn.textContent = 'Login';
            }
        });
    </script>
</body>
</html>