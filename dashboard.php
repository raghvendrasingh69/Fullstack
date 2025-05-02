<?php
require_once 'config.php';
requireLogin();

// Fetch user details
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Pension Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-r from-violet-400 to-blue-600 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold text-indigo-600">Pension Portal</h1>
                    <div class="hidden md:flex space-x-4">
                        <a href="dashboard.php" class="text-gray-600 hover:text-indigo-600 transition-colors duration-200">Dashboard</a>
                        <a href="view_pensioners.php" class="text-gray-600 hover:text-indigo-600 transition-colors duration-200">Pensioners</a>
                        <a href="#" onclick="showPensionCalculator(); return false;" class="text-gray-600 hover:text-indigo-600 transition-colors duration-200">Calculator</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative" id="profileDropdown">
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600 focus:outline-none">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['name']); ?>&background=6366f1&color=fff" 
                                 alt="Profile" class="w-8 h-8 rounded-full">
                            <span class="font-semibold"><?php echo htmlspecialchars($user['name']); ?></span>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>
                        <div class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-lg shadow-xl hidden" id="profileMenu">
                            <a href="#" onclick="showProfileModal(); return false;" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">
                                <i class="fas fa-user mr-2"></i>View Profile
                            </a>
                            <a href="add_pensioner.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">
                                <i class="fas fa-plus mr-2"></i>Add Pensioner
                            </a>
                            <a href="logout.php" class="block px-4 py-2 text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8 flex-grow">
        <!-- Welcome Banner -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
                    <p class="text-gray-600">One ID: <?php echo htmlspecialchars($user['one_id']); ?></p>
                </div>
                <div class="flex space-x-4">
                    <button onclick="showPensionCalculator()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                        <i class="fas fa-calculator mr-2"></i>Pension Calculator
                    </button>
                    <button onclick="window.location.href='view_pensioners.php'" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200">
                        <i class="fas fa-users mr-2"></i>View Pensioners
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Personal Details Card -->
            <div class="bg-white p-6 rounded-lg shadow-md" id="personalDetails">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Personal Details</h2>
                    <button onclick="refreshProfile()" class="text-indigo-600 hover:text-indigo-800" title="Refresh Profile">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Name:</span>
                        <span class="font-medium" id="profileName"><?php echo htmlspecialchars($user['name']); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">One ID:</span>
                        <span class="font-medium" id="profileOneId"><?php echo htmlspecialchars($user['one_id']); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">DOB:</span>
                        <span class="font-medium" id="profileDob"><?php echo date('d/m/Y', strtotime($user['dob'])); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">PPO Number:</span>
                        <span class="font-medium" id="profilePpo"><?php echo htmlspecialchars($user['ppo_number']); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Email:</span>
                        <span class="font-medium" id="profileEmail"><?php echo htmlspecialchars($user['email']); ?></span>
                    </div>
                </div>
            </div>

            <!-- Pension Amount Card -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Pension Details</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Monthly Amount:</span>
                        <span class="font-medium">₹25,000</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Last Payment:</span>
                        <span class="font-medium">March 2025</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Next Payment:</span>
                        <span class="font-medium">April 2025</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="text-green-600 font-medium">Active</span>
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="bg-white p-6 rounded-lg shadow-md transform hover:scale-105 transition-transform duration-200">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">
                    <i class="fas fa-chart-line text-indigo-600 mr-2"></i>Statistics
                </h2>
                <div class="space-y-4">
                    <div class="bg-indigo-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Total Pension Received</p>
                        <p class="text-2xl font-bold text-indigo-600">₹2,75,000</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Last Payment</p>
                        <p class="text-2xl font-bold text-green-600">₹25,000</p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Next Payment Date</p>
                        <p class="text-2xl font-bold text-blue-600">May 1, 2025</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pension Calculator Modal -->
        <div id="calculatorModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="relative top-20 mx-auto p-5 border w-[500px] shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-gray-900">Pension Calculator</h3>
                        <button onclick="closeCalculator()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Basic Pay (₹)</label>
                                <input type="number" id="basicPay" min="0" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Years of Service</label>
                                <input type="number" id="yearsOfService" min="0" max="50" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Age at Retirement</label>
                                <input type="number" id="retirementAge" min="50" max="75" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">DA Rate (%)</label>
                                <input type="number" id="daRate" value="38" min="0" max="100" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Commutation Rate (%)</label>
                            <input type="number" id="commutationRate" value="40" min="0" max="40" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <button onclick="calculatePension()" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-3 rounded-lg hover:opacity-90 transition-all duration-300 transform hover:scale-[1.02] flex items-center justify-center">
                            <i class="fas fa-calculator mr-2"></i>
                            Calculate Pension
                        </button>
                        <div id="result" class="hidden space-y-4 bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Basic Pension:</h4>
                                    <p id="basicPensionAmount" class="text-lg font-bold text-indigo-600"></p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">DA Amount:</h4>
                                    <p id="daAmount" class="text-lg font-bold text-purple-600"></p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Commutation Amount:</h4>
                                    <p id="commutationAmount" class="text-lg font-bold text-green-600"></p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Net Monthly Pension:</h4>
                                    <p id="netPensionAmount" class="text-lg font-bold text-blue-600"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pensioners List Modal -->
        <div id="pensionersListModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="relative top-20 mx-auto p-5 border max-w-4xl shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Pensioners List</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PPO Number</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pension Amount</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Sample data - In real application, this would be populated from database -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">John Doe</td>
                                    <td class="px-6 py-4 whitespace-nowrap">PPO987654</td>
                                    <td class="px-6 py-4 whitespace-nowrap">₹25,000</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-green-600">Active</td>
                                </tr>
                                <!-- Add more rows as needed -->
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <button onclick="closePensionersList()" class="w-full bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pension Calculator Modal -->
    <div id="calculatorModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">
                        <i class="fas fa-calculator text-indigo-600 mr-2"></i>Pension Calculator
                    </h3>
                    <button onclick="closeCalculator()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Basic Pay</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">₹</span>
                            <input type="number" id="basicPay" class="w-full pl-8 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter your basic pay">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Years of Service</label>
                        <input type="number" id="yearsOfService" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter years of service">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Current Age</label>
                        <input type="number" id="age" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter your current age">
                    </div>
                    <button onclick="calculatePension()" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                        Calculate Pension
                    </button>
                    <div id="result" class="hidden space-y-4 bg-gray-50 p-4 rounded-lg">
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Estimated Monthly Pension</p>
                            <p id="monthlyPension" class="text-2xl font-bold text-indigo-600"></p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Annual Pension</p>
                            <p id="annualPension" class="text-2xl font-bold text-green-600"></p>
                        </div>
                        <div class="text-xs text-gray-500 text-center mt-2">
                            * Calculations are based on standard pension rules
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="hidden fixed bottom-4 right-4 px-6 py-3 rounded-lg text-white"></div>

    <!-- Footer -->
    <footer class="bg-white shadow-lg mt-8">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-center md:text-left">
                    <h3 class="text-lg font-semibold text-gray-800">PensionPro</h3>
                    <p class="text-gray-600 text-sm">Managing pensions with excellence</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors duration-200">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors duration-200">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors duration-200">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
                <div class="text-center md:text-right">
                    <p class="text-gray-600 text-sm">&copy; 2025 PensionPortal. All rights reserved.</p>
                    <div class="flex space-x-4 justify-center md:justify-end mt-2">
                        <a href="#" class="text-sm text-gray-600 hover:text-indigo-600">Privacy Policy</a>
                        <a href="#" class="text-sm text-gray-600 hover:text-indigo-600">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Profile and Header Functions
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize profile dropdown
            const profileDropdown = document.getElementById('profileDropdown');
            const profileMenu = document.getElementById('profileMenu');
            
            profileDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
                profileMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', function() {
                profileMenu.classList.add('hidden');
            });

            // Initialize tooltips
            const tooltips = document.querySelectorAll('[title]');
            tooltips.forEach(tooltip => {
                tooltip.addEventListener('mouseover', showTooltip);
                tooltip.addEventListener('mouseout', hideTooltip);
            });
        });

        function showTooltip(e) {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip absolute bg-gray-800 text-white px-2 py-1 rounded text-sm -mt-8';
            tooltip.textContent = e.target.getAttribute('title');
            tooltip.style.left = e.pageX + 'px';
            tooltip.style.top = e.pageY - 30 + 'px';
            document.body.appendChild(tooltip);
        }

        function hideTooltip() {
            const tooltips = document.querySelectorAll('.tooltip');
            tooltips.forEach(t => t.remove());
        }

        // Real-time profile updates
        async function refreshProfile() {
            const refreshBtn = document.querySelector('#personalDetails button');
            const icon = refreshBtn.querySelector('i');
            
            // Add spinning animation
            icon.classList.add('fa-spin');
            
            try {
                const response = await fetch('get_profile.php');
                if (!response.ok) throw new Error('Failed to fetch profile');
                
                const data = await response.json();
                
                // Update profile fields
                document.getElementById('profileName').textContent = data.name;
                document.getElementById('profileOneId').textContent = data.one_id;
                document.getElementById('profileDob').textContent = formatDate(data.dob);
                document.getElementById('profilePpo').textContent = data.ppo_number;
                document.getElementById('profileEmail').textContent = data.email;
                
                showToast('Profile updated successfully', 'success');
            } catch (error) {
                showToast('Failed to update profile', 'error');
            } finally {
                // Remove spinning animation
                setTimeout(() => icon.classList.remove('fa-spin'), 500);
            }
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-IN', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        }

        // Enhanced Pension Calculator Functions
        function showPensionCalculator() {
            document.getElementById('calculatorModal').classList.remove('hidden');
            document.getElementById('calculatorModal').classList.add('flex');
        }

        function closeCalculator() {
            document.getElementById('calculatorModal').classList.add('hidden');
            document.getElementById('calculatorModal').classList.remove('flex');
            resetCalculator();
        }

        function resetCalculator() {
            document.getElementById('basicPay').value = '';
            document.getElementById('yearsOfService').value = '';
            document.getElementById('age').value = '';
            document.getElementById('result').classList.add('hidden');
        }

        function calculatePension() {
            // Get input values
            const basicPay = parseFloat(document.getElementById('basicPay').value) || 0;
            const yearsOfService = parseInt(document.getElementById('yearsOfService').value) || 0;
            const retirementAge = parseInt(document.getElementById('retirementAge').value) || 60;
            const daRate = parseFloat(document.getElementById('daRate').value) || 38;
            const commutationRate = parseFloat(document.getElementById('commutationRate').value) || 40;

            // Validate inputs
            if (basicPay <= 0 || yearsOfService <= 0) {
                alert('Please enter valid Basic Pay and Years of Service');
                return;
            }

            // Calculate pension components
            let basicPension = 0;
            if (yearsOfService >= 10) {
                // 50% of basic pay for 10 years of service, additional 2.5% for each additional year
                let pensionPercentage = 50;
                if (yearsOfService > 10) {
                    pensionPercentage += Math.min((yearsOfService - 10) * 2.5, 20); // Cap at 70%
                }
                basicPension = (basicPay * pensionPercentage) / 100;
            } else {
                alert('Minimum 10 years of service required for pension');
                return;
            }

            // Calculate DA amount
            const daAmount = (basicPension * daRate) / 100;

            // Calculate commutation amount (if opted)
            const commutationAmount = (basicPension * commutationRate) / 100;

            // Calculate net monthly pension
            const netPension = basicPension + daAmount - commutationAmount;

            // Display results
            document.getElementById('result').classList.remove('hidden');
            document.getElementById('basicPensionAmount').textContent = '₹' + basicPension.toFixed(2);
            document.getElementById('daAmount').textContent = '₹' + daAmount.toFixed(2);
            document.getElementById('commutationAmount').textContent = '₹' + commutationAmount.toFixed(2);
            document.getElementById('netPensionAmount').textContent = '₹' + netPension.toFixed(2);

            if (!basicPay || !yearsOfService || !age) {
                showToast('Please fill in all fields', 'error');
                return;
            }

            if (age < 50 || age > 90) {
                showToast('Age must be between 50 and 90 years', 'error');
                return;
            }

            // Enhanced pension calculation formula
            let pensionAmount = (basicPay * yearsOfService * 0.5) / 12;
            
            // Age-based adjustments
            if (age >= 80) pensionAmount *= 1.2; // 20% additional for 80+ years
            else if (age >= 70) pensionAmount *= 1.1; // 10% additional for 70+ years

            document.getElementById('result').classList.remove('hidden');
            document.getElementById('pensionAmount').textContent = `₹${pensionAmount.toFixed(2)}`;
            
            // Show monthly and annual breakdowns
            document.getElementById('monthlyPension').textContent = `₹${pensionAmount.toFixed(2)}`;
            document.getElementById('annualPension').textContent = `₹${(pensionAmount * 12).toFixed(2)}`;
            
            showToast('Pension calculated successfully!', 'success');
        }

        function showToast(message, type) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg text-white ${type === 'error' ? 'bg-red-600' : 'bg-green-600'}`;
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 3000);
        }

        // Pensioners List Functions
        function showPensionersList() {
            document.getElementById('pensionersListModal').classList.remove('hidden');
        }

        function closePensionersList() {
            document.getElementById('pensionersListModal').classList.add('hidden');
        }

        function downloadStatement() {
            alert('Statement download initiated!');
            // In a real application, this would trigger a download of the pension statement
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const calculatorModal = document.getElementById('calculatorModal');
            const pensionersListModal = document.getElementById('pensionersListModal');
            
            if (event.target === calculatorModal) {
                calculatorModal.classList.add('hidden');
            }
            if (event.target === pensionersListModal) {
                pensionersListModal.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
