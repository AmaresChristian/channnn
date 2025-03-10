<?php
session_start();
require_once '../config.php';
include '../assets/navbar.php';
if ($_POST['action'] == "book") {
    $user_id = intval($_POST['user_id']);
    $bike_id = intval($_POST['bike_id']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $end_date = htmlspecialchars($_POST['end_date']);

    // Validate date format
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $start_date) || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $end_date)) {
        header("Location: ../pages/booking.php?error=Invalid date format");
        exit();
    }

    // Secure database query
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, bike_id, start_date, end_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $user_id, $bike_id, $start_date, $end_date);
    $stmt->execute();

    header("Location: ../pages/bookings.php?success=Booking submitted!");
}


?>
