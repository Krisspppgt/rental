<?php
require_once "Database.php";

class User extends Database {

    public function register($username, $password) {
        $stmt = $this->conn->prepare("INSERT INTO users (username, password, level) VALUES (?, ?, 'non')");
        $stmt->bind_param("ss", $username, $password);
        return $stmt->execute();
    }

    public function login($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateLevel($user_id) {
        $stmt = $this->conn->prepare("SELECT SUM(total_bayar) as total FROM transaksi WHERE user_id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $total = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

        if ($total >= 5000000) {
            $level = 'gold';
        } elseif ($total >= 1000000) {
            $level = 'reguler';
        } else {
            $level = 'non';
        }

        $update = $this->conn->prepare("UPDATE users SET level=? WHERE id=?");
        $update->bind_param("si", $level, $user_id);
        $update->execute();

        return $level;
    }
}
?>