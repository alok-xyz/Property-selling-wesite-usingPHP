<?php
session_start();
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_id = $_POST['admin_id'];
    $password = $_POST['password'];

    // Fixed admin credentials
    if ($admin_id === '1' && $password === '1') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@1.9.6/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<body class="bg-cover bg-center" style="background-image: url('https://wallpaperboat.com/wp-content/uploads/2021/08/05/78116/iOS-13-liquid-15-920x518.jpg');">
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="max-w-md mx-auto bg-white p-8 rounded shadow mt-10">
            <h2 class="text-2xl font-bold text-center">Admin Login</h2>
                <label for="admin_id" class="form-label">Admin ID</label>
                <input type="text" class="form-control" name="admin_id" required>
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
                <hr>
                <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full">Login</button>
                <hr>
                <p class="mt-3 text-center"> <a href="../index.php">Home</a></p>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
