<?php
session_start();
require 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$property_id = $_GET['id'];

// Fetch property details from the database
$stmt = $pdo->prepare("SELECT * FROM properties WHERE id = ?");
$stmt->execute([$property_id]);
$property = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$property) {
    header("Location: index.php");
    exit();
}

// Fetch seller details (Assuming you have seller details in the properties table or linked via seller_id)
$seller_id = $property['seller_id'];
$seller_stmt = $pdo->prepare("SELECT * FROM sellers WHERE id = ?");
$seller_stmt->execute([$seller_id]);
$seller = $seller_stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Details</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4"><?= htmlspecialchars($property['title']) ?></h1>
        <div class="row">
            <div class="col-md-8">
                <?php $images = json_decode($property['images']); ?>
                <?php foreach ($images as $image): ?>
                    <img src="assets/images/properties/<?= htmlspecialchars($image) ?>" class="img-fluid mb-3" alt="Property Image">
                <?php endforeach; ?>
            </div>
            <div class="col-md-4">
                <h3>Property Details</h3>
                <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($property['description'])) ?></p>
                <p><strong>Price:</strong> ₹<?= htmlspecialchars($property['price']) ?></p>
                <p><strong>Negotiable:</strong> <?= htmlspecialchars($property['negotiable']) ?></p>
                <p><strong>Category:</strong> <?= htmlspecialchars($property['category']) ?></p>
                <h4>Contact Seller</h4>
                <p><strong>Name:</strong> <?= htmlspecialchars($seller['full_name']) ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($seller['mobile_number']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($seller['email']) ?></p>
            </div>
        </div>
        <a href="index.php" class="btn btn-secondary mt-4">Back to Listings</a>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
