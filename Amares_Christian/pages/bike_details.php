<?php
require_once '../config.php';
include '../assets/navbar.php';

if (!isset($_GET['id'])) {
    die("Bike not found!");
}

$bike_id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT b.*, c.name AS category_name, br.name AS brand_name 
                        FROM bikes b 
                        JOIN categories c ON b.category_id = c.id 
                        JOIN brands br ON b.brand_id = br.id 
                        WHERE b.id = ?");
$stmt->bind_param("i", $bike_id);
$stmt->execute();
$result = $stmt->get_result();
$bike = $result->fetch_assoc();

if (!$bike) {
    die("Bike not found!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $bike['name'] ?> - Details</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css"><!-- Include in all pages inside <head> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    <div class="container mt-5">
        <h2><?= $bike['name'] ?></h2>
        <hr>
        
        <img src="../uploads/<?= $bike['image'] ?>" width="400">
        <p><strong>Category:</strong> <?= $bike['category_name'] ?></p>
        <p><strong>Brand:</strong> <?= $bike['brand_name'] ?></p>
        <p><strong>Price per Day:</strong> $<?= $bike['price_per_day'] ?></p>

        <a href="booking.php?bike_id=<?= $bike['id'] ?>" class="btn btn-success">Rent This Bike</a>
        <a href="bikes.php" class="btn btn-secondary">Back</a>
    </div>
</body>
</html>
