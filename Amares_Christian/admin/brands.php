<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/login.php");
    exit();
}
require_once '../config.php';
include '../assets/navbar.php';
// Fetch brands
$result = $conn->query("SELECT * FROM brands");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Brands</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <!-- Include in all pages inside <head> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    <div class="container mt-5">
        <h2>Manage Bike Brands</h2>
        <a href="dashboard.php">⬅ Back to Dashboard</a>
        <hr>
        
        <!-- Add Brand Form -->
        <form action="../handlers/brandHandler.php" method="POST">
            <input type="hidden" name="action" value="add">
            <label>Brand Name:</label>
            <input type="text" name="name" required>
            <button type="submit">Add Brand</button>
        </form>

        <h4 class="mt-4">Brand List</h4>
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td>
                    <a href="../handlers/brandHandler.php?action=delete&id=<?= $row['id'] ?>">🗑 Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
