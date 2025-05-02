<?php
require_once 'config.php';
requireLogin();

// Fetch user details
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name, one_id, dob, ppo_number, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($user);
