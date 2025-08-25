<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); exit;
}
?>
<link rel="stylesheet" href="style.css">
<div class="container">
    <h2>Selamat Datang, <?= $_SESSION['username'] ?> (<?= ucfirst($_SESSION['level']) ?>)</h2>
    <a href="rental_form.php">Form Rental PS</a> | 
    <a href="laporan.php">Laporan Transaksi</a> | 
    <a href="logout.php">Logout</a>
</div>
