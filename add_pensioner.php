<?php
require_once 'config.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    
    // Validate and sanitize input
    $address = $conn->real_escape_string($_POST['address']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $retirement_date = $conn->real_escape_string($_POST['retirement_date']);
    $basic_pension = floatval($_POST['basic_pension']);
    $bank_name = $conn->real_escape_string($_POST['bank_name']);
    $account_number = $conn->real_escape_string($_POST['account_number']);
    $ifsc_code = $conn->real_escape_string($_POST['ifsc_code']);

    // Check if pensioner details already exist
    $check_stmt = $conn->prepare("SELECT id FROM pensioner_details WHERE user_id = ?");
    $check_stmt->bind_param("i", $user_id);
    $check_stmt->execute();
    $existing = $check_stmt->get_result()->fetch_assoc();

    if ($existing) {
        // Update existing record
        $sql = "UPDATE pensioner_details SET 
                address = ?, 
                phone = ?, 
                retirement_date = ?, 
                basic_pension = ?, 
                bank_name = ?, 
                account_number = ?, 
                ifsc_code = ? 
                WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdsssi", $address, $phone, $retirement_date, $basic_pension, $bank_name, $account_number, $ifsc_code, $user_id);
    } else {
        // Insert new record
        $sql = "INSERT INTO pensioner_details (user_id, address, phone, retirement_date, basic_pension, bank_name, account_number, ifsc_code) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issdssss", $user_id, $address, $phone, $retirement_date, $basic_pension, $bank_name, $account_number, $ifsc_code);
    }

    if ($stmt->execute()) {
        header('Location: dashboard.php?success=1');
        exit();
    } else {
        header('Location: dashboard.php?error=1');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Pensioner Details - Pension Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-violet-400 to-blue-600 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Add Pensioner Details</h2>
            
            <form action="add_pensioner.php" method="POST" class="space-y-6">
                <div>
                    <label class="block text-gray-700 mb-2" for="address">Address</label>
                    <textarea id="address" name="address" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required></textarea>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2" for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2" for="retirement_date">Retirement Date</label>
                    <input type="date" id="retirement_date" name="retirement_date" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2" for="basic_pension">Basic Pension Amount</label>
                    <input type="number" step="0.01" id="basic_pension" name="basic_pension" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2" for="bank_name">Bank Name</label>
                    <input type="text" id="bank_name" name="bank_name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2" for="account_number">Account Number</label>
                    <input type="text" id="account_number" name="account_number" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2" for="ifsc_code">IFSC Code</label>
                    <input type="text" id="ifsc_code" name="ifsc_code" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500" required>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="flex-1 bg-indigo-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-indigo-700">Save Details</button>
                    <a href="dashboard.php" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-300 text-center">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', (e) => {
            const phone = document.getElementById('phone').value;
            const accountNumber = document.getElementById('account_number').value;
            const ifscCode = document.getElementById('ifsc_code').value;

            if (!/^\d{10}$/.test(phone)) {
                e.preventDefault();
                alert('Please enter a valid 10-digit phone number');
                return;
            }

            if (!/^\d{10}$/.test(accountNumber)) {
                e.preventDefault();
                alert('Please enter a valid account number');
                return;
            }

            if (!/^[A-Z]{4}0[A-Z0-9]{6}$/.test(ifscCode)) {
                e.preventDefault();
                alert('Please enter a valid IFSC code');
                return;
            }
        });
    </script>
</body>
</html>
