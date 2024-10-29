<?php
session_start();
if (!isset($_SESSION['seller_id'])) {
    header("Location: login.php");
    exit();
}

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['property_id'])) {
    $property_id = $_POST['property_id'];

    // Fetch the property to delete
    $stmt = $pdo->prepare("SELECT images FROM properties WHERE id = ? AND seller_id = ?");
    $stmt->execute([$property_id, $_SESSION['seller_id']]);
    $property = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($property) {
        // Delete images from the server
        $images = json_decode($property['images'], true);
        foreach ($images as $image) {
            $file_path = "assets/images/properties/" . $image;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        // Delete property from the database
        $deleteStmt = $pdo->prepare("DELETE FROM properties WHERE id = ? AND seller_id = ?");
        $deleteStmt->execute([$property_id, $_SESSION['seller_id']]);
    }
    
    header("Location: dashboard.php");
    exit();
}
?>
