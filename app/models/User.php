<?php
// App/models/User.php

class User {
    private $conn;

    public function __construct($db_connection) {
        $this->conn = $db_connection;
    }

    // --- User-facing Methods ---
    public function findByEmail($email) {
        $stmt = $this->conn->prepare("SELECT id, username, email, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows === 1 ? $result->fetch_assoc() : null;
    }

    public function create($username, $email, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $role = 'user';
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);
        if ($stmt->execute()) { return true; } 
        else {
            if ($this->conn->errno == 1062) { return "Error: This email is already registered."; } 
            else { return "Error: " . $stmt->error; }
        }
    }
    
    // --- Admin-facing Methods ---
    public function getAll() {
        $users = [];
        $query = "SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC";
        $result = $this->conn->query($query);
        if ($result) { while($row = $result->fetch_assoc()) { $users[] = $row; } }
        return $users;
    }

    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT id, username, email, role FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows === 1 ? $result->fetch_assoc() : null;
    }

    public function updateRole($id, $role) {
        $stmt = $this->conn->prepare("UPDATE users SET role = ? WHERE id = ?");
        $stmt->bind_param("si", $role, $id);
        return $stmt->execute();
    }
    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}