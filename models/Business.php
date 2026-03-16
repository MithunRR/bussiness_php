<?php

require_once __DIR__ . '/../config/database.php';

class Business {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getAll() {
        $sql = "SELECT b.*, COALESCE(AVG(r.rating), 0) as avg_rating
                FROM businesses b
                LEFT JOIN ratings r ON b.id = r.business_id
                GROUP BY b.id
                ORDER BY b.id DESC";
        $result = $this->conn->query($sql);
        $businesses = [];
        while ($row = $result->fetch_assoc()) {
            $row['avg_rating'] = round($row['avg_rating'], 1);
            $businesses[] = $row;
        }
        return $businesses;
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM businesses WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($name, $address, $phone, $email) {
        $stmt = $this->conn->prepare("INSERT INTO businesses (name, address, phone, email, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $name, $address, $phone, $email);
        return $stmt->execute();
    }

    public function update($id, $name, $address, $phone, $email) {
        $stmt = $this->conn->prepare("UPDATE businesses SET name = ?, address = ?, phone = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $address, $phone, $email, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM ratings WHERE business_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $stmt = $this->conn->prepare("DELETE FROM businesses WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getAverageRating($businessId) {
        $stmt = $this->conn->prepare("SELECT COALESCE(AVG(rating), 0) as avg_rating FROM ratings WHERE business_id = ?");
        $stmt->bind_param("i", $businessId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return round($result['avg_rating'], 1);
    }
}
