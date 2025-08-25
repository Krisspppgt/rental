<?php
session_start();
require_once "classes/User.php";
require_once "classes/Rental.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$rental = new Rental();
$transaksi = $rental->getTransaksiByUser($_SESSION['user_id']);
?>
<link rel="stylesheet" href="style.css">

<div class="container">
    <h2>Laporan Transaksi Saya</h2>
    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <tr style="background:#f2f2f2;">
            <th>No</th>
            <th>PS</th>
            <th>Lama Sewa (Jam)</th>
            <th>Total Asli</th>
            <th>Cashback</th>
            <th>Total Bayar</th>
            <th>Status</th>
        </tr>
        <?php 
        $no = 1;
        $total_semua = 0;
        while($row = $transaksi->fetch_assoc()): 
            $total_semua += $row['total_bayar'];
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama_ps'] ?></td>
            <td><?= $row['lama_sewa'] ?></td>
            <td>Rp<?= number_format($row['total_asli'], 0, ',', '.') ?></td>
            <td>Rp<?= number_format($row['cashback'], 0, ',', '.') ?></td>
            <td>Rp<?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
            <td><?= $row['status'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <p><b>Total transaksi saya: Rp<?= number_format($total_semua, 0, ',', '.') ?></b></p>

    <br>
    <a href="dashboard.php">⬅ Kembali ke Dashboard</a>
</div>
