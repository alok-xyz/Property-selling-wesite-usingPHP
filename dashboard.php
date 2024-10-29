<?php
session_start();
if (!isset($_SESSION['seller_id'])) {
    header("Location: login.php");
    exit();
}

require 'config.php';

// Fetch properties listed by the seller
$stmt = $pdo->prepare("SELECT * FROM properties WHERE seller_id = ?");
$stmt->execute([$_SESSION['seller_id']]);
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

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
    <title>Seller Dashboard</title>
</head>
<body class="bg-gray-100 font-roboto">
    <header class="flex justify-between items-center p-4 bg-white shadow">
        <div class="text-2xl font-bold">Dashboard</div>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </header>

    <main class="container mx-auto mt-8">
    <a href="list_property.php" class="mt-4 inline-block bg-blue-500 text-white p-2 rounded">List a New Property</a>
        <h1 class="text-3xl font-bold mb-6">Your Properties</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($properties as $property): ?>
                <div class='border p-4 rounded shadow'>
                    <h2 class='text-xl font-bold'><?= htmlspecialchars($property['title']) ?></h2>
                    <?php $images = json_decode($property['images']); ?>
                    <?php foreach ($images as $image): ?>
                        <img src="assets/images/properties/<?= htmlspecialchars($image) ?>" alt="Property Image" class="w-full h-48 object-cover mb-4">
                    <?php endforeach; ?>
                    <p><?= htmlspecialchars($property['description']) ?></p>
                    <p class='text-lg font-semibold'>₹<?= htmlspecialchars($property['price']) ?></p>
                    <p>Negotiable: <?= htmlspecialchars($property['negotiable']) ?></p>
                    <form action="delete_property.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this property?');">
                        <input type="hidden" name="property_id" value="<?= htmlspecialchars($property['id']) ?>">
                        <button type="submit" class="text-red-500">Delete Property</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
       
    </main>
</body>
</html>
