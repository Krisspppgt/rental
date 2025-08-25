<?php
session_start();
require_once "classes/User.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user = new User();

$currentLevel = $user->updateLevel($_SESSION['user_id']);
$_SESSION['level'] = $currentLevel;
?>
<link rel="stylesheet" href="style.css">

<div class="container">
    <h2>Selamat Datang, <?= htmlspecialchars($_SESSION['username']) ?> 👋</h2>
    <p><b>Status Akun:</b> <?= ucfirst($_SESSION['level']) ?></p>

    <div class="menu">
        <a href="rental_form.php">🕹 Form Rental PS</a> |
        <a href="laporan.php">📑 Laporan Transaksi</a> |
        <a href="logout.php">🚪 Logout</a>
    </div>
</div>
