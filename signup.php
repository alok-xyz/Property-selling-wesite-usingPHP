<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@1.9.6/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Seller Signup</title>
</head>
<body class="bg-cover bg-center" style="background-image: url('https://wallpaperboat.com/wp-content/uploads/2021/08/05/78116/iOS-13-liquid-08-920x518.jpg');">
    <div class="max-w-md mx-auto bg-white p-8 rounded shadow mt-10">
        <h1 class="text-2xl font-bold text-center">Seller Signup</h1>
        <form action="process_signup.php" method="POST" class="mt-4">
            <input type="text" name="full_name" placeholder="Full Name" required class="border p-2 rounded w-full mb-4">
            <input type="text" name="mobile_number" placeholder="Mobile Number" required class="border p-2 rounded w-full mb-4">
            <input type="email" name="email" placeholder="Email" required class="border p-2 rounded w-full mb-4">
            <input type="password" name="password" placeholder="Password" required class="border p-2 rounded w-full mb-4">
            <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full">Signup</button>
        </form>
        <p class="text-center mt-4">Already have an account? <a href="login.php" class="text-blue-500">Login</a></p>
        <hr>
        <p class="mt-3 text-center"> <a href="index.php">Home</a></p>
    </div>
</body>
</html>
