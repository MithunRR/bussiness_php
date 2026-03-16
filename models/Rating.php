<?php

require_once __DIR__ . '/../config/database.php';

class Rating {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function save($businessId, $name, $email, $phone, $rating) {
        $stmt = $this->conn->prepare("SELECT id FROM ratings WHERE business_id = ? AND (email = ? OR phone = ?)");
        $stmt->bind_param("iss", $businessId, $email, $phone);
        $stmt->execute();
        $existing = $stmt->get_result()->fetch_assoc();

        if ($existing) {
            $stmt = $this->conn->prepare("UPDATE ratings SET name = ?, email = ?, phone = ?, rating = ? WHERE id = ?");
            $stmt->bind_param("sssdi", $name, $email, $phone, $rating, $existing['id']);
        } else {
            $stmt = $this->conn->prepare("INSERT INTO ratings (business_id, name, email, phone, rating, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("isssd", $businessId, $name, $email, $phone, $rating);
        }

        return $stmt->execute();
    }
}
