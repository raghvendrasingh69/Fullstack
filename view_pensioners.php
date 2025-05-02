<?php
require_once 'config.php';
requireLogin();

// Get filter and sort parameters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'name';
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';

// Base query
$sql = "SELECT u.name, u.one_id, u.ppo_number, u.email, pd.* 
        FROM users u 
        INNER JOIN pensioner_details pd ON u.id = pd.user_id";

// Add search condition if search parameter exists
if ($search) {
    $search = "%{$search}%";
    $sql .= " WHERE u.name LIKE ? OR u.one_id LIKE ? OR u.ppo_number LIKE ? OR pd.phone LIKE ?";
}

// Add sorting
$validColumns = ['name', 'one_id', 'ppo_number', 'basic_pension', 'retirement_date'];
$sort = in_array($sort, $validColumns) ? $sort : 'name';
$order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';

if ($sort === 'name' || $sort === 'one_id' || $sort === 'ppo_number') {
    $sql .= " ORDER BY u.{$sort} {$order}";
} else {
    $sql .= " ORDER BY pd.{$sort} {$order}";
}

// Prepare and execute query
$stmt = $conn->prepare($sql);
if ($search) {
    $stmt->bind_param('ssss', $search, $search, $search, $search);
}
$stmt->execute();
$result = $stmt->get_result();
$pensioners = $result->fetch_all(MYSQLI_ASSOC);

// Get total count for pagination
$totalPensioners = count($pensioners);
?>` 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Pensioners - Pension Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sortable:hover {
            cursor: pointer;
            background-color: #f3f4f6;
        }
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .hover-trigger .hover-target {
            display: none;
        }
        .hover-trigger:hover .hover-target {
            display: flex;
        }
    </style>
</head>
<body class="bg-gradient-to-r from-violet-400 to-blue-600 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <a href="dashboard.php" class="text-2xl font-bold text-indigo-600">PensionPro</a>
                    <div class="hidden md:flex space-x-4">
                        <a href="dashboard.php" class="text-gray-600 hover:text-indigo-600">Dashboard</a>
                        <a href="view_pensioners.php" class="text-indigo-600">Pensioners</a>
                        <a href="add_pensioner.php" class="text-gray-600 hover:text-indigo-600">Add Pensioner</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="logout.php" class="text-red-600 hover:text-red-800">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8 flex-grow">
        <div class="bg-white rounded-lg shadow-lg p-6 animate-fade-in">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Pensioners Directory</h2>
                    <p class="text-gray-600">Total Records: <?php echo $totalPensioners; ?></p>
                </div>
                <div class="flex space-x-4">
                    <div class="relative">
                        <input type="text" id="searchInput" 
                               class="pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                               placeholder="Search pensioners..." 
                               value="<?php echo htmlspecialchars($search); ?>">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <a href="add_pensioner.php" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>Add New
                    </a>
                    <button onclick="exportToPDF()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                        <i class="fas fa-download mr-2"></i>Export
                    </button>
                </div>
            </div>

            <!-- Filters and Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-indigo-50 p-4 rounded-lg hover-trigger">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600">Active Pensioners</p>
                            <p class="text-2xl font-bold text-indigo-600"><?php echo $totalPensioners; ?></p>
                        </div>
                        <i class="fas fa-users text-indigo-400 text-3xl"></i>
                    </div>
                    <div class="hover-target mt-2 text-sm text-gray-600">
                        <p>Currently registered and active pensioners in the system</p>
                    </div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg hover-trigger">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600">Average Pension</p>
                            <p class="text-2xl font-bold text-green-600">₹25,000</p>
                        </div>
                        <i class="fas fa-chart-line text-green-400 text-3xl"></i>
                    </div>
                    <div class="hover-target mt-2 text-sm text-gray-600">
                        <p>Average monthly pension amount across all pensioners</p>
                    </div>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg hover-trigger">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600">New This Month</p>
                            <p class="text-2xl font-bold text-blue-600">5</p>
                        </div>
                        <i class="fas fa-user-plus text-blue-400 text-3xl"></i>
                    </div>
                    <div class="hover-target mt-2 text-sm text-gray-600">
                        <p>New pensioners registered in the current month</p>
                    </div>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg hover-trigger">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600">Total Disbursed</p>
                            <p class="text-2xl font-bold text-purple-600">₹1.2Cr</p>
                        </div>
                        <i class="fas fa-money-bill-wave text-purple-400 text-3xl"></i>
                    </div>
                    <div class="hover-target mt-2 text-sm text-gray-600">
                        <p>Total pension amount disbursed this fiscal year</p>
                    </div>
                </div>
            </div>

            <!-- Pensioners Table -->
            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left">
                                <div class="flex items-center space-x-2 text-xs font-medium text-gray-500 uppercase tracking-wider sortable"
                                     onclick="sortTable('name')">
                                    <span>Name</span>
                                    <i class="fas fa-sort"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left">
                                <div class="flex items-center space-x-2 text-xs font-medium text-gray-500 uppercase tracking-wider sortable"
                                     onclick="sortTable('one_id')">
                                    <span>One ID</span>
                                    <i class="fas fa-sort"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left">
                                <div class="flex items-center space-x-2 text-xs font-medium text-gray-500 uppercase tracking-wider sortable"
                                     onclick="sortTable('basic_pension')">
                                    <span>Basic Pension</span>
                                    <i class="fas fa-sort"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left">
                                <div class="flex items-center space-x-2 text-xs font-medium text-gray-500 uppercase tracking-wider sortable"
                                     onclick="sortTable('retirement_date')">
                                    <span>Retirement Date</span>
                                    <i class="fas fa-sort"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left">
                                <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Status</div>
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-right">
                                <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="pensionersTableBody">
                        <?php foreach ($pensioners as $pensioner): ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img class="h-8 w-8 rounded-full" 
                                         src="https://ui-avatars.com/api/?name=<?php echo urlencode($pensioner['name']); ?>&background=6366f1&color=fff" 
                                         alt="<?php echo htmlspecialchars($pensioner['name']); ?>">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($pensioner['name']); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo htmlspecialchars($pensioner['email']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?php echo htmlspecialchars($pensioner['one_id']); ?></div>
                                <div class="text-sm text-gray-500">PPO: <?php echo htmlspecialchars($pensioner['ppo_number']); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">₹<?php echo number_format($pensioner['basic_pension'], 2); ?></div>
                                <div class="text-xs text-gray-500">Monthly</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?php echo date('d M Y', strtotime($pensioner['retirement_date'])); ?></div>
                                <div class="text-xs text-gray-500"><?php 
                                    $retirement_date = new DateTime($pensioner['retirement_date']);
                                    $now = new DateTime();
                                    $diff = $retirement_date->diff($now);
                                    if ($retirement_date > $now) {
                                        echo 'In ' . $diff->y . ' years';
                                    } else {
                                        echo $diff->y . ' years ago';
                                    }
                                ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php 
                                    $retirement_date = new DateTime($pensioner['retirement_date']);
                                    $now = new DateTime();
                                    if ($retirement_date > $now):
                                ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Upcoming</span>
                                <?php else: ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button onclick="viewDetails(<?php echo htmlspecialchars(json_encode($pensioner)); ?>)" 
                                        class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button onclick="editPensioner(<?php echo htmlspecialchars($pensioner['user_id']); ?>)" 
                                        class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="downloadStatement(<?php echo htmlspecialchars($pensioner['user_id']); ?>)" 
                                        class="text-green-600 hover:text-green-900">
                                    <i class="fas fa-download"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- No Results Message -->
            <?php if (empty($pensioners)): ?>
            <div class="text-center py-8">
                <div class="text-gray-500 mb-4">
                    <i class="fas fa-search text-4xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No pensioners found</h3>
                <p class="text-gray-500">Try adjusting your search or filters to find what you're looking for.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal -->
    <div id="detailsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full items-center justify-center z-50">
        <div class="relative mx-auto p-8 w-11/12 md:w-3/4 lg:w-2/3 max-w-4xl max-h-[90vh] overflow-y-auto bg-white rounded-xl shadow-2xl transform transition-all">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-4 mb-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="bg-indigo-100 p-2 rounded-lg">
                        <i class="fas fa-user-circle text-indigo-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Pensioner Profile</h3>
                </div>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500 transition-colors duration-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Modal Content -->
            <div id="modalContent" class="">
                <!-- Content will be dynamically populated -->
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end items-center space-x-4 mt-8 pt-6 border-t border-gray-200">
                <button onclick="downloadStatement()" class="flex items-center px-4 py-2 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition-colors duration-200">
                    <i class="fas fa-download mr-2"></i>
                    Download Statement
                </button>
                <button onclick="closeModal()" class="flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        // Enhanced search functionality with debouncing
        const searchInput = document.getElementById('searchInput');
        let searchTimeout;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const searchParams = new URLSearchParams(window.location.search);
                searchParams.set('search', this.value);
                window.location.href = `${window.location.pathname}?${searchParams.toString()}`;
            }, 500);
        });

        // Sorting functionality
        function sortTable(column) {
            const searchParams = new URLSearchParams(window.location.search);
            const currentSort = searchParams.get('sort');
            const currentOrder = searchParams.get('order');
            
            let newOrder = 'asc';
            if (currentSort === column && currentOrder === 'asc') {
                newOrder = 'desc';
            }
            
            searchParams.set('sort', column);
            searchParams.set('order', newOrder);
            window.location.href = `${window.location.pathname}?${searchParams.toString()}`;
        }

        // Enhanced modal functionality
        function viewDetails(pensioner) {
            const modal = document.getElementById('detailsModal');
            const content = document.getElementById('modalContent');

            const retirementDate = new Date(pensioner.retirement_date);
            const now = new Date();
            const status = retirementDate > now ? 'Upcoming' : 'Active';
            const statusClass = retirementDate > now ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800';

            content.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Personal Information</h4>
                            <div class="mt-2 space-y-2">
                                <p class="flex justify-between">
                                    <span class="text-gray-600">Name:</span>
                                    <span class="font-medium">${pensioner.name}</span>
                                </p>
                                <p class="flex justify-between">
                                    <span class="text-gray-600">One ID:</span>
                                    <span class="font-medium">${pensioner.one_id}</span>
                                </p>
                                <p class="flex justify-between">
                                    <span class="text-gray-600">PPO Number:</span>
                                    <span class="font-medium">${pensioner.ppo_number}</span>
                                </p>
                                <p class="flex justify-between">
                                    <span class="text-gray-600">Status:</span>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">${status}</span>
                                </p>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Contact Details</h4>
                            <div class="mt-2 space-y-2">
                                <p class="flex justify-between">
                                    <span class="text-gray-600">Phone:</span>
                                    <span class="font-medium">${pensioner.phone}</span>
                                </p>
                                <p class="flex justify-between">
                                    <span class="text-gray-600">Email:</span>
                                    <span class="font-medium">${pensioner.email}</span>
                                </p>
                                <p>
                                    <span class="text-gray-600">Address:</span>
                                    <span class="font-medium block mt-1">${pensioner.address}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Pension Details</h4>
                            <div class="mt-2 space-y-2">
                                <p class="flex justify-between">
                                    <span class="text-gray-600">Basic Pension:</span>
                                    <span class="font-medium">₹${parseFloat(pensioner.basic_pension).toLocaleString('en-IN', { minimumFractionDigits: 2 })}</span>
                                </p>
                                <p class="flex justify-between">
                                    <span class="text-gray-600">Retirement Date:</span>
                                    <span class="font-medium">${new Date(pensioner.retirement_date).toLocaleDateString('en-IN')}</span>
                                </p>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Bank Details</h4>
                            <div class="mt-2 space-y-2">
                                <p class="flex justify-between">
                                    <span class="text-gray-600">Bank Name:</span>
                                    <span class="font-medium">${pensioner.bank_name}</span>
                                </p>
                                <p class="flex justify-between">
                                    <span class="text-gray-600">Account Number:</span>
                                    <span class="font-medium">${pensioner.account_number}</span>
                                </p>
                                <p class="flex justify-between">
                                    <span class="text-gray-600">IFSC Code:</span>
                                    <span class="font-medium">${pensioner.ifsc_code}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('detailsModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Edit pensioner
        function editPensioner(userId) {
            window.location.href = `add_pensioner.php?id=${userId}`;
        }

        // Download statement
        function downloadStatement(userId) {
            // Show loading toast
            showToast('Generating statement...', 'info');
            
            // Simulate download delay
            setTimeout(() => {
                showToast('Statement downloaded successfully!', 'success');
            }, 1500);
        }

        // Export to PDF
        function exportToPDF() {
            showToast('Generating PDF...', 'info');
            
            // Simulate export delay
            setTimeout(() => {
                showToast('PDF exported successfully!', 'success');
            }, 2000);
        }

        // Toast notifications
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg text-white ${type === 'success' ? 'bg-green-600' : 'bg-blue-600'} animate-fade-in`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('detailsModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>
