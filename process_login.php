<?php
require 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_identifier = $_POST['login_identifier'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM sellers WHERE email = ? OR mobile_number = ?");
    $stmt->execute([$login_identifier, $login_identifier]);
    $seller = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($seller && password_verify($password, $seller['password'])) {
        // Start session and redirect to dashboard
        session_start();
        $_SESSION['seller_id'] = $seller['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        // Handle invalid login
        echo "Invalid email/mobile number or password.";
    }
}
?>
