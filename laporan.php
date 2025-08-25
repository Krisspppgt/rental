<?php
session_start();
require_once "classes/Database.php";
require_once "classes/Rental.php";

$db = new Database();
$rental = new Rental($db);

$result = $rental->getTransaksiByUser($_SESSION['user_id']);
?>
<link rel="stylesheet" href="style.css">
<div class="container">
    <h2>Laporan Transaksi Saya</h2>
    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <tr style="background:#f2f2f2;">
            <th>No</th><th>PS</th><th>Lama</th><th>Total Asli</th><th>Cashback</th><th>Total Bayar</th><th>Status</th>
        </tr>
        <?php $no=1; while($row=$result->fetch_assoc()): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama_ps'] ?></td>
            <td><?= $row['lama_sewa'] ?></td>
            <td>Rp<?= number_format($row['total_asli'],0,',','.') ?></td>
            <td>Rp<?= number_format($row['cashback'],0,',','.') ?></td>
            <td>Rp<?= number_format($row['total_bayar'],0,',','.') ?></td>
            <td><?= $row['status'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="dashboard.php">⬅ Kembali</a>
</div>
