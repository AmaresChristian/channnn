<?php
require_once '../config.php';
include '../assets/navbar.php';

if (isset($_POST['action']) && $_POST['action'] == "add") {
    $name = $_POST['name'];
    $stmt = $conn->prepare("INSERT INTO brands (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    if ($stmt->execute()) {
        header("Location: ../admin/brands.php?success=added");
    } else {
        header("Location: ../admin/brands.php?error=failed");
    }
}

if (isset($_GET['action']) && $_GET['action'] == "delete") {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM brands WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: ../admin/brands.php?success=deleted");
    } else {
        header("Location: ../admin/brands.php?error=failed");
    }
}
?>
