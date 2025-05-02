<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Pension Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-r from-violet-400 to-blue-600">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Create Account</h2>
                <p class="mt-2 text-gray-600">Join PensionPro Management System</p>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo $error; ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <!-- Personal Information Section -->
                <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">
                        <i class="fas fa-user mr-2"></i>Personal Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" id="name" name="name" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   placeholder="Enter your full name">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" id="email" name="email" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   placeholder="your.email@example.com">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" id="phone" name="phone" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   placeholder="Enter your phone number">
                        </div>
                        <div>
                            <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                            <input type="date" id="dob" name="dob" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>

                <!-- Pension Details Section -->
                <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">
                        <i class="fas fa-file-alt mr-2"></i>Pension Details
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="one_id" class="block text-sm font-medium text-gray-700">One ID</label>
                            <input type="text" id="one_id" name="one_id" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   placeholder="Enter your One ID">
                        </div>
                        <div>
                            <label for="ppo_number" class="block text-sm font-medium text-gray-700">PPO Number</label>
                            <input type="text" id="ppo_number" name="ppo_number" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   placeholder="Enter PPO number">
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">
                        <i class="fas fa-lock mr-2"></i>Security
                    </h3>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" required 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="Create a strong password">
                        <p class="mt-1 text-sm text-gray-500">Password must be at least 8 characters long</p>
                    </div>
                </div>

                <!-- Create Account Button in Rectangle Box -->
                <div class="bg-gray-50 p-4 rounded-lg text-center">
                    <button type="submit" class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
                        <i class="fas fa-user-plus mr-2"></i>Create Account
                    </button>
                </div>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                Already have an account? 
                <a href="login.php" class="font-medium text-indigo-600 hover:text-indigo-500">Login here</a>
            </p>
        </div>
    </div>

    <script>
        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const phone = document.getElementById('phone').value;
            
            if (password.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long');
                return;
            }

            // Basic phone number validation
            if (!/^\d{10}$/.test(phone)) {
                e.preventDefault();
                alert('Please enter a valid 10-digit phone number');
                return;
            }
        });
    </script>
</body>
</html>