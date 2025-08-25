<?php
require_once "classes/Database.php";
require_once "classes/User.php";

$db = new Database();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($user->register($_POST['username'], $_POST['password'])) {
        $msg = "Akun berhasil dibuat. <a href='index.php'>Login sekarang</a>";
    } else {
        $msg = "Username sudah terdaftar.";
    }
}
?>
<link rel="stylesheet" href="style.css">
<div class="container">
    <h2>Register Akun</h2>
    <?php if (!empty($msg)) echo "<p style='color:blue;'>$msg</p>"; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
</div>
