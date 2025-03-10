<?php
session_start();
require_once '../config.php';
include '../assets/navbar.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['bike_id'])) {
    die("Bike not found!");
}

$bike_id = intval($_GET['bike_id']);
$stmt = $conn->prepare("SELECT * FROM bikes WHERE id = ?");
$stmt->bind_param("i", $bike_id);
$stmt->execute();
$bike = $stmt->get_result()->fetch_assoc();

if (!$bike) {
    die("Bike not found!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Book <?= $bike['name'] ?></title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <!-- Include in all pages inside <head> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    <div class="container mt-5">
        <h2>Book <?= $bike['name'] ?></h2>
        <hr>

        <form action="../handlers/bookingHandler.php" method="POST" class="p-4 bg-light shadow-sm rounded">
    <input type="hidden" name="action" value="book">
    <input type="hidden" name="bike_id" value="<?= $bike['id'] ?>">
    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">

    <div class="mb-3">
        <label class="form-label">Start Date:</label>
        <input type="date" name="start_date" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">End Date:</label>
        <input type="date" name="end_date" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success w-100">Submit Booking</button>
</form>

    </div>
</body>
</html>
