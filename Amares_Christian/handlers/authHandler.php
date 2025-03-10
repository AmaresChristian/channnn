<?php
require_once '../config.php';
require_once '../class/Auth.php';
include '../assets/navbar.php';
$auth = new Auth($conn);

if (isset($_POST['action'])) {
    if ($_POST['action'] == "register") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($auth->register($username, $email, $password)) {
            echo "success";
        } else {
            echo "error";
        }
    }

    if ($_POST['action'] == "login") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($auth->login($email, $password)) {
            echo "success";
        } else {
            echo "error";
        }
    }
}
?>
