<?php
// App/models/Author.php

class Author {
    private $conn;

    public function __construct($db_connection) {
        $this->conn = $db_connection;
    }

    public function getAll() {
        $authors = [];
        $sql = "SELECT id, name FROM authors ORDER BY name ASC";
        $result = $this->conn->query($sql);
        if ($result) {
            while($row = $result->fetch_assoc()) {
                $authors[] = $row;
            }
        }
        return $authors;
    }
    
    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM authors WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create($name, $bio, $profile_image) {
        $stmt = $this->conn->prepare("INSERT INTO authors (name, bio, profile_image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $bio, $profile_image);
        return $stmt->execute();
    }
    
    public function update($id, $name, $bio, $profile_image, $user_id) {
        // Allow user_id to be NULL if no user is selected
        $user_id = empty($user_id) ? NULL : $user_id;

        $stmt = $this->conn->prepare("UPDATE authors SET name = ?, bio = ?, profile_image = ?, user_id = ? WHERE id = ?");
        $stmt->bind_param("sssii", $name, $bio, $profile_image, $user_id, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM authors WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function countAll() {
        $result = $this->conn->query("SELECT COUNT(*) as count FROM authors");
        $row = $result->fetch_assoc();
        return $row['count'];
    }

    public function getFeatured() {
        $authors = [];
        $sql = "SELECT id, name, profile_image FROM authors LIMIT 3";
        $result = $this->conn->query($sql);
        if ($result) {
            while($row = $result->fetch_assoc()) {
                $authors[] = $row;
            }
        }
        return $authors;
    }

    public function findByUserId($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM authors WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}