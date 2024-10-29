<?php
session_start();
require '../config.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all properties from the database
$stmt = $pdo->prepare("SELECT properties.*, sellers.full_name, sellers.blocked FROM properties JOIN sellers ON properties.seller_id = sellers.id");
$stmt->execute();
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all sellers from the database
$sellers_stmt = $pdo->prepare("SELECT * FROM sellers");
$sellers_stmt->execute();
$sellers = $sellers_stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle property deletion
if (isset($_GET['delete'])) {
    $property_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM properties WHERE id = ?");
    $stmt->execute([$property_id]);
    header("Location: admin_dashboard.php");
    exit();
}

// Handle blocking and unblocking sellers
if (isset($_GET['block'])) {
    $seller_id = $_GET['block'];
    $stmt = $pdo->prepare("UPDATE sellers SET blocked = 1 WHERE id = ?");
    $stmt->execute([$seller_id]);
    header("Location: admin_dashboard.php");
    exit();
}

if (isset($_GET['unblock'])) {
    $seller_id = $_GET['unblock'];
    $stmt = $pdo->prepare("UPDATE sellers SET blocked = 0 WHERE id = ?");
    $stmt->execute([$seller_id]);
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@1.9.6/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Admin Dashboard</h2>
        <a href="admin_logout.php" class="btn btn-danger">Logout</a>
        
        <h4>Properties</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Negotiable</th>
                    <th>Category</th>
                    <th>Seller</th>
                    <th>Seller Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($properties as $property): ?>
                    <tr>
                        <td><?= htmlspecialchars($property['id']) ?></td>
                        <td><?= htmlspecialchars($property['title']) ?></td>
                        <td>₹<?= htmlspecialchars($property['price']) ?></td>
                        <td><?= htmlspecialchars($property['negotiable']) ?></td>
                        <td><?= htmlspecialchars($property['category']) ?></td>
                        <td><?= htmlspecialchars($property['full_name']) ?></td>
                        <td><?= $property['blocked'] ? '<span class="text-danger">Blocked</span>' : '<span class="text-success">Active</span>' ?></td>
                        <td>
                            <a href="property_details.php?id=<?= htmlspecialchars($property['id']) ?>" class="btn btn-info btn-sm">View</a>
                            <a href="?delete=<?= htmlspecialchars($property['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this property?');">Delete</a>
                            <?php if ($property['blocked']): ?>
                                <a href="?unblock=<?= htmlspecialchars($property['seller_id']) ?>" class="btn btn-success btn-sm">Unblock Seller</a>
                            <?php else: ?>
                                <a href="?block=<?= htmlspecialchars($property['seller_id']) ?>" class="btn btn-warning btn-sm">Block Seller</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4>Sellers</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sellers as $seller): ?>
                    <tr>
                        <td><?= htmlspecialchars($seller['id']) ?></td>
                        <td><?= htmlspecialchars($seller['full_name']) ?></td>
                        <td><?= htmlspecialchars($seller['email']) ?></td>
                        <td><?= htmlspecialchars($seller['mobile_number']) ?></td>
                        <td><?= $seller['blocked'] ? '<span class="text-danger">Blocked</span>' : '<span class="text-success">Active</span>' ?></td>
                        <td>
                            <?php if ($seller['blocked']): ?>
                                <a href="?unblock=<?= htmlspecialchars($seller['id']) ?>" class="btn btn-success btn-sm">Unblock</a>
                            <?php else: ?>
                                <a href="?block=<?= htmlspecialchars($seller['id']) ?>" class="btn btn-warning btn-sm">Block</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="admin_logout.php" class="btn btn-danger">Logout</a>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
