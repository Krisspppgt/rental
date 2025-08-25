<?php
class Rental {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getPSList() {
        return $this->db->conn->query("SELECT * FROM ps_list");
    }

    public function addRental($user_id, $id_ps, $lama_sewa, $level) {
        $stmt = $this->db->conn->prepare("SELECT nama_ps, harga_per_jam FROM ps_list WHERE id=?");
        $stmt->bind_param("i", $id_ps);
        $stmt->execute();
        $ps = $stmt->get_result()->fetch_assoc();

        $total_asli = $ps['harga_per_jam'] * $lama_sewa;

        $cashback = 0;
        if ($level == 'reguler') {
            $cashback = 0.02 * $total_asli;
        } elseif ($level == 'gold') {
            $cashback = 0.05 * $total_asli;
        }

        $total_bayar = $total_asli - $cashback;

        $insert = $this->db->conn->prepare("
            INSERT INTO transaksi (user_id, id_ps, lama_sewa, total_bayar, cashback, status)
            VALUES (?, ?, ?, ?, ?, 'Selesai')
        ");
        $insert->bind_param("iiidd", $user_id, $id_ps, $lama_sewa, $total_bayar, $cashback);
        $insert->execute();

        return [
            "nama_ps" => $ps['nama_ps'],
            "lama" => $lama_sewa,
            "total_asli" => $total_asli,
            "cashback" => $cashback,
            "total_bayar" => $total_bayar
        ];
    }

    public function getTransaksiByUser($user_id) {
        $stmt = $this->db->conn->prepare("
            SELECT t.id, p.nama_ps, t.lama_sewa,
                   (t.total_bayar + t.cashback) AS total_asli,
                   t.cashback, t.total_bayar, t.status
            FROM transaksi t
            JOIN ps_list p ON t.id_ps = p.id
            WHERE t.user_id = ?
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
