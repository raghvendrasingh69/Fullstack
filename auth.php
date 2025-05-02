<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oneId = $conn->real_escape_string($_POST['oneId']);
    $password = $_POST['password'];

    $sql = "SELECT id, one_id, password, name FROM users WHERE one_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $oneId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['one_id'] = $user['one_id'];
            $_SESSION['name'] = $user['name'];
            
            header('Location: dashboard.php');
            exit();
        }
    }

    // If login fails
    header('Location: login.php?error=1');
    exit();
}
?>
