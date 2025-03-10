<?php
session_start();
require_once '../config.php';
include '../assets/navbar.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT b.id, bk.start_date, bk.end_date, bk.status, bk.id AS booking_id, b.name 
                        FROM bookings bk 
                        JOIN bikes b ON bk.bike_id = b.id 
                        WHERE bk.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$bookings = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Bookings</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <!-- Include in all pages inside <head> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    <div class="container mt-5">
        <h2>My Bookings</h2>
        <hr>
        
        <table class="table">
            <tr>
                <th>Bike</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
            </tr>
            <?php while ($booking = $bookings->fetch_assoc()): ?>
            <tr>
                <td><?= $booking['name'] ?></td>
                <td><?= $booking['start_date'] ?></td>
                <td><?= $booking['end_date'] ?></td>
                <td><?= $booking['status'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
