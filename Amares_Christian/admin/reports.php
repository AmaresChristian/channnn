<?php

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/login.php");
    exit();
}
require_once '../config.php';
include '../assets/navbar.php';
$whereSQL = "";
if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $whereSQL = "WHERE bk.start_date BETWEEN '$start_date' AND '$end_date'";
}

$query = "SELECT bk.id, b.name AS bike_name, u.username, bk.start_date, bk.end_date, bk.status 
          FROM bookings bk 
          JOIN bikes b ON bk.bike_id = b.id 
          JOIN users u ON bk.user_id = u.id 
          $whereSQL
          ORDER BY bk.start_date DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Booking Report</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css"><!-- Include in all pages inside <head> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    <div class="container mt-5">
        <h2>Booking Report</h2>
        <hr>

        <!-- Filter Form -->
        <form method="GET" action="reports.php" class="mb-3">
            <label>Start Date:</label>
            <input type="date" name="start_date" required>
            <label>End Date:</label>
            <input type="date" name="end_date" required>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="reports.php" class="btn btn-secondary">Reset</a>
            <button onclick="printReport()" class="btn btn-success">🖨 Print</button>
        </form>

        <!-- Booking Report Table -->
        <div id="reportSection">
            <table class="table">
                <tr>
                    <th>Booking ID</th>
                    <th>Bike</th>
                    <th>User</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['bike_name'] ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['start_date'] ?></td>
                    <td><?= $row['end_date'] ?></td>
                    <td><?= $row['status'] ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>

    <script>
        function printReport() {
            var reportContent = document.getElementById('reportSection').innerHTML;
            var originalContent = document.body.innerHTML;
            document.body.innerHTML = reportContent;
            window.print();
            document.body.innerHTML = originalContent;
        }
    </script>
</body>
</html>
