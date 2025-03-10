<?php
session_start();
require_once '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['role'] = $role;

            if ($role == 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../pages/bikes.php");
            }
            exit();
        } else {
            header("Location: ../pages/login.php?error=Invalid credentials");
        }
    } else {
        header("Location: ../pages/login.php?error=User not found");
    }
}
?>
