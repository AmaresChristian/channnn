if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // 🔒 Hash password

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'client')");
    $stmt->bind_param("sss", $name, $email, $password);
    $stmt->execute();

    header("Location: ../pages/login.php?success=Account created!");
}
