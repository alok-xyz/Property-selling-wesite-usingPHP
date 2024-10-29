<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO sellers (full_name, mobile_number, email, password) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$full_name, $mobile_number, $email, $password])) {
        // Redirect to login page with success message
        header("Location: login.php?signup=success");
        exit();
    } else {
        // Handle error (e.g., email already exists)
        echo "Error: Unable to create account.";
    }
}
?>
