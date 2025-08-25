<?php
session_start();
require_once "classes/User.php";
require_once "classes/Rental.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// buat object
$user   = new User();
$rental = new Rental();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $hasil = $rental->addRental(
        $_SESSION['user_id'],
        $_POST['id_ps'],
        $_POST['lama_sewa'],
        $_SESSION['level']
    );

    // update level user berdasarkan total transaksi
    $_SESSION['level'] = $user->updateLevel($_SESSION['user_id']);

    // pesan sukses
    $msg = "
        ✅ Sewa berhasil!<br>
        Anda menyewa <b>{$hasil['nama_ps']}</b> selama <b>{$hasil['lama']} jam</b>.<br>
        Total Asli: Rp" . number_format($hasil['total_asli'], 0, ',', '.') . "<br>
        Cashback: Rp" . number_format($hasil['cashback'], 0, ',', '.') . "<br>
        <b>Total Bayar: Rp" . number_format($hasil['total_bayar'], 0, ',', '.') . "</b>
    ";
}

$list = $rental->getPSList();
?>
<link rel="stylesheet" href="style.css">

<div class="container">
    <h2>Form Rental PS</h2>
    <?php if (!empty($msg)): ?>
        <div class="alert-success">
            <?= $msg ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <label>Pilih PS</label>
        <select name="id_ps" required>
            <?php while($row = $list->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>">
                    <?= $row['nama_ps'] ?> (Rp<?= number_format($row['harga_per_jam'],0,',','.') ?>/jam)
                </option>
            <?php endwhile; ?>
        </select>

        <label>Lama Sewa (jam)</label>
        <input type="number" name="lama_sewa" min="1" required>

        <button type="submit">Sewa Sekarang</button>
    </form>

    <br>
    <a href="dashboard.php">⬅ Kembali ke Dashboard</a>
</div>
