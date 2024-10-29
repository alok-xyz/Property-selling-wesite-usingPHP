<?php
session_start();
if (!isset($_SESSION['seller_id'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $price = htmlspecialchars($_POST['price']);
    $negotiable = htmlspecialchars($_POST['negotiable']);
    $category = implode(',', $_POST['category']);
    $images = [];

    // Handle file uploads
    foreach ($_FILES['images']['name'] as $key => $name) {
        $tmp_name = $_FILES['images']['tmp_name'][$key];
        $target_file = "assets/images/properties/" . basename($name);
        
        if (move_uploaded_file($tmp_name, $target_file)) {
            $images[] = $name;
        }
    }

    // Insert property into the database
    require 'config.php';
    $stmt = $pdo->prepare("INSERT INTO properties (title, description, price, negotiable, category, images, seller_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $description, $price, $negotiable, $category, json_encode($images), $_SESSION['seller_id']]);
    
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Your Property</title>
    <!-- CSS CDN Links -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@1.9.6/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="form-container">
            <h1 class="text-center mb-4">List Your Property</h1>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Property Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Property Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price (in INR)</label>
                    <input type="number" name="price" id="price" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Price Negotiable?</label>
                    <select name="negotiable" class="form-select" required>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Categories</label>
                    <select name="category[]" id="category" class="form-select" multiple required>
                        <option value="Houses">Houses</option>
                        <option value="Bungalow">Bungalow</option>
                        <option value="Cars">Cars</option>
                        <option value="Land">Land</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="images" class="form-label">Upload Images</label>
                    <input type="file" name="images[]" id="images" class="form-control" multiple required>
                </div>
                <button type="submit" class="btn btn-primary w-100">List Property</button>
            </form>
        </div>
    </div>

    <!-- JS CDN Links -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
