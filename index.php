<?php
require 'config.php';

// Fetch all properties from the database
$categoryFilter = '';
if (isset($_GET['category']) && !empty($_GET['category'])) {
    $categoryFilter = htmlspecialchars($_GET['category']);
}

// Fetch properties based on selected category
if ($categoryFilter) {
    $stmt = $pdo->prepare("SELECT p.*, s.full_name, s.mobile_number FROM properties p JOIN sellers s ON p.seller_id = s.id WHERE FIND_IN_SET(?, p.category)");
    $stmt->execute([$categoryFilter]);
} else {
    $stmt = $pdo->query("SELECT p.*, s.full_name, s.mobile_number FROM properties p JOIN sellers s ON p.seller_id = s.id");
}

$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch unique categories for filtering
$categoryStmt = $pdo->query("SELECT DISTINCT category FROM properties");
$categories = $categoryStmt->fetchAll(PDO::FETCH_COLUMN);
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
    <title>Property Listings</title>
</head>
<body class="bg-gray-100 font-roboto">
    <header class="flex justify-between items-center p-4 bg-white shadow">
        <div class="text-2xl font-bold">Property Listings</div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="signup.php" class="btn btn-outline-primary">Sign Up</a>
            <a href="login.php" class="btn btn-outline-secondary">Login</a>            
            <a href="admin/admin_login.php" class="btn btn-outline-danger">Admin Login</a> 
        </div>
    </header>

    <main class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold mb-6">All Properties</h1>
        
        <!-- Filter Section -->
        <div class="mb-4">
            <form action="index.php" method="GET" class="flex justify-between">
                <select name="category" class="border p-2 rounded w-1/4">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category) ?>" <?= $categoryFilter === $category ? 'selected' : '' ?>><?= htmlspecialchars($category) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="bg-blue-500 text-white p-2 rounded">Filter</button>
            </form>
        </div>

        <div class="row">
            <?php foreach ($properties as $property): ?>
                <div class="col-md-4 property-card">
                    <div class="card shadow-sm">
                        <?php $images = json_decode($property['images']); ?>
                        <img src="assets/images/properties/<?= htmlspecialchars($images[0]) ?>" class="card-img-top" alt="Property Image">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($property['title']) ?></h5>
                            <p class="card-text">Price: ₹<?= htmlspecialchars($property['price']) ?></p>
                            <p class="card-text">Negotiable: <?= htmlspecialchars($property['negotiable']) ?></p>
                            <a href="property_details.php?id=<?= htmlspecialchars($property['id']) ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script src="assets/js/scripts.js"></script>
    <script>
        function toggleContactDetails(name, phone) {
            const detailsDiv = event.target.nextElementSibling;
            if (detailsDiv.classList.contains('hidden')) {
                detailsDiv.innerHTML = `<strong>Name:</strong> ${name}<br><strong>Phone:</strong> ${phone}`;
                detailsDiv.classList.remove('hidden');
            } else {
                detailsDiv.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
