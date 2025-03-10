<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/login.php");
    exit();
}
require_once '../config.php';
include '../assets/navbar.php';
// Fetch bikes
$result = $conn->query("SELECT bikes.*, categories.name AS category_name, brands.name AS brand_name 
                        FROM bikes 
                        JOIN categories ON bikes.category_id = categories.id
                        JOIN brands ON bikes.brand_id = brands.id");

$categories = $conn->query("SELECT * FROM categories");
$brands = $conn->query("SELECT * FROM brands");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Bikes</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    <div class="container mt-5">
        <h2>Manage Bikes</h2>
        <a href="dashboard.php">⬅ Back to Dashboard</a>
        <hr>

        <!-- Add Bike Form -->
        <form action="../handlers/bikeHandler.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <label>Bike Name:</label>
            <input type="text" name="name" required><br>
            
            <label>Category:</label>
            <select name="category_id">
                <?php while ($cat = $categories->fetch_assoc()): ?>
                    <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                <?php endwhile; ?>
            </select><br>

            <label>Brand:</label>
            <select name="brand_id">
                <?php while ($brand = $brands->fetch_assoc()): ?>
                    <option value="<?= $brand['id'] ?>"><?= $brand['name'] ?></option>
                <?php endwhile; ?>
            </select><br>

            <label>Price per Day:</label>
            <input type="number" name="price" required><br>

            <label>Upload Image:</label>
            <input type="file" name="image" required><br>

            <button type="submit">Add Bike</button>
        </form>

        <h4 class="mt-4">Bike List</h4>
        <table class="table">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><img src="../uploads/<?= $row['image'] ?>" width="100"></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['category_name'] ?></td>
                <td><?= $row['brand_name'] ?></td>
                <td>$<?= $row['price_per_day'] ?>/day</td>
                <td>
                    <a href="../handlers/bikeHandler.php?action=delete&id=<?= $row['id'] ?>">🗑 Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
