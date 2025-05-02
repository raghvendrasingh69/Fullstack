<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oneId = $conn->real_escape_string($_POST['oneId']);
    $name = $conn->real_escape_string($_POST['name']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $ppo = $conn->real_escape_string($_POST['ppo']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if One ID already exists
    $check_sql = "SELECT id FROM users WHERE one_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $oneId);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        header('Location: register.php?error=exists');
        exit();
    }

    // Insert new user
    $sql = "INSERT INTO users (one_id, name, dob, ppo_number, email, password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $oneId, $name, $dob, $ppo, $email, $password);

    if ($stmt->execute()) {
        header('Location: login.php?registered=1');
        exit();
    } else {
        header('Location: register.php?error=1');
        exit();
    }
}
?>
