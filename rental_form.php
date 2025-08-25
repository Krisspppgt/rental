<?php
session_start();
require_once "classes/Database.php";
require_once "classes/User.php";
require_once "classes/Rental.php";

$db = new Database();
$user = new User($db);
$rental = new Rental($db);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $hasil = $rental->addRental($_SESSION['user_id'], $_POST['id_ps'], $_POST['lama_sewa'], $_SESSION['level']);
    $_SESSION['level'] = $user->updateLevel($_SESSION['user_id']);
    $msg = "✅ Sewa berhasil! Anda menyewa {$hasil['nama_ps']} selama {$hasil['lama']} jam.<br>
            Total Asli: Rp" . number_format($hasil['total_asli'],0,',','.') . "<br>
            Cashback: Rp" . number_format($hasil['cashback'],0,',','.') . "<br>
            Total Bayar: Rp" . number_format($hasil['total_bayar'],0,',','.');
}
$list = $rental->getPSList();
?>
<link rel="stylesheet" href="style.css">
<div class="container">
    <h2>Form Rental PS</h2>
    <?php if (!empty($msg)) echo "<p style='color:green;'>$msg</p>"; ?>
    <form method="post">
        <label>Pilih PS</label>
        <select name="id_ps" required>
            <?php while($row = $list->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['nama_ps'] ?> (Rp<?= $row['harga_per_jam'] ?>/jam)</option>
            <?php endwhile; ?>
        </select>
        <label>Lama Sewa (jam)</label>
        <input type="number" name="lama_sewa" min="1" required>
        <button type="submit">Sewa</button>
    </form>
</div>
