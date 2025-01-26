<?php
require_once('Database.php');

class User {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    public function register($emri, $mbiemri, $email, $password) {
        try {
            $query = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->db->conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return "Ky email ekziston.";
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (emri, mbiemri, email, password) VALUES (:emri, :mbiemri, :email, :password)";
            $stmt = $this->db->conn->prepare($query);
            $stmt->bindParam(':emri', $emri);
            $stmt->bindParam(':mbiemri', $mbiemri);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                return "Regjistrimi u krye me sukses.";
            } else {
                return "Regjistrimi ka deshtuar.";
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
?>
