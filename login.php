<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pension Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-violet-400 to-blue-600 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Welcome</h2>
                <p class="text-gray-600 mt-3">Login with your One ID</p>
            </div>
            <form action="auth.php" method="POST" class="space-y-6">
                <div>
                    <label class="block text-gray-700 mb-2" for="oneId">One ID</label>
                    <input type="text" id="oneId" name="oneId" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" placeholder=" Enter Your id" required>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2" for="password">Password</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500 " placeholder="Enter Your Password" required>
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox text-indigo-600">
                        <span class="ml-2 text-gray-600">Save Details</span>
                    </label>
                    <a href="#" class="text-indigo-600 hover:text-indigo-800">Forgot password?</a>
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-indigo-700">Login</button>
            </form>
            <div class="mt-6 text-center">
                <p class="text-gray-600">Don't have an account? <a href="register.php" class="text-indigo-600 hover:text-indigo-800">Register here</a></p>
            </div>
        </div>
    </div>

    <script>
        // Form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const oneId = document.getElementById('oneId').value;
            const password = document.getElementById('password').value;

            if (!oneId || !password) {
                alert('Please fill in all fields');
                return;
            }

            // In a real application, you would handle the form submission here
            form.submit();
        });
    </script>
</body>
</html>
