<?php include '../config.php'; ?>
<?php include '../assets/navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title><!-- Include in all pages inside <head> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="../handlers/authHandler.php">
        <input type="hidden" name="action" value="login">
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
