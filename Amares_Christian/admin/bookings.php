<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/login.php");
    exit();
}
require_once '../config.php';
include '../assets/navbar.php';
// Fetch bookings
$result = $conn->query("SELECT bk.id, b.name, u.username, bk.start_date, bk.end_date, bk.status 
                        FROM bookings bk 
                        JOIN bikes b ON bk.bike_id = b.id 
                        JOIN users u ON bk.user_id = u.id");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Bookings</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <!-- Include in all pages inside <head> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    <div class="container mt-5">
        <h2>Manage Bookings</h2>
        <hr>

        <table class="table">
            <tr>
                <th>Bike</th>
                <th>User</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['start_date'] ?></td>
                <td><?= $row['end_date'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                    <?php if ($row['status'] == 'Pending'): ?>
                        <a href="../handlers/bookingHandler.php?action=approve&id=<?= $row['id'] ?>">✅ Approve</a>
                        <a href="../handlers/bookingHandler.php?action=reject&id=<?= $row['id'] ?>">❌ Reject</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
