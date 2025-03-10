<?php
require_once '../config.php';
include '../assets/navbar.php';
if (isset($_POST['action']) && $_POST['action'] == "add") {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $brand_id = $_POST['brand_id'];
    $price = $_POST['price'];

    // Image Upload
    $image = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $uploadDir = "../uploads/";
    $imagePath = $uploadDir . basename($image);
    
    if (move_uploaded_file($imageTmp, $imagePath)) {
        $stmt = $conn->prepare("INSERT INTO bikes (name, category_id, brand_id, price_per_day, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siids", $name, $category_id, $brand_id, $price, $image);
        if ($stmt->execute()) {
            header("Location: ../admin/bikes.php?success=added");
        } else {
            header("Location: ../admin/bikes.php?error=failed");
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] == "delete") {
    $id = $_GET['id'];

    // Get the image path
    $stmt = $conn->prepare("SELECT image FROM bikes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($image);
    $stmt->fetch();
    $stmt->close();

    // Delete from database
    $stmt = $conn->prepare("DELETE FROM bikes WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        if (file_exists("../uploads/" . $image)) {
            unlink("../uploads/" . $image);
        }
        header("Location: ../admin/bikes.php?success=deleted");
    } else {
        header("Location: ../admin/bikes.php?error=failed");
    }
}
?>
