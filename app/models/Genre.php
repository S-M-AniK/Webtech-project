<?php
// App/models/Genre.php

class Genre {
    private $conn;

    public function __construct($db_connection) {
        $this->conn = $db_connection;
    }

    public function getAll() {
        $genres = [];
        $sql = "SELECT * FROM genres ORDER BY name ASC";
        $result = $this->conn->query($sql);
        if ($result) {
            while($row = $result->fetch_assoc()) {
                $genres[] = $row;
            }
        }
        return $genres;
    }

    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM genres WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create($name) {
        $stmt = $this->conn->prepare("INSERT INTO genres (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }

    public function update($id, $name) {
        $stmt = $this->conn->prepare("UPDATE genres SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM genres WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function countAll() {
        $result = $this->conn->query("SELECT COUNT(*) as count FROM genres");
        $row = $result->fetch_assoc();
        return $row['count'];
    }
}