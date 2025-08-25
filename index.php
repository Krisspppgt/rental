<?php
session_start();
require_once "classes/Database.php";
require_once "classes/User.php";

$db = new Database();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = $user->login($_POST['username'], $_POST['password']);
    if ($data) {
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['level'] = $data['level'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Login gagal!";
    }
}
?>
<link rel="stylesheet" href="style.css">
<div class="container">
    <h2>Login Rental PS</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p>Belum punya akun? <a href="register.php">Register</a></p>
</div>
