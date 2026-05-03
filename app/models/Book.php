<?php
// App/models/Book.php

class Book {
    private $conn;

    public function __construct($db_connection) {
        $this->conn = $db_connection;
    }

    public function getAll() {
        $books = [];
        $sql = "SELECT b.*, a.name as author_name, g.name as genre_name
                FROM books b
                LEFT JOIN authors a ON b.author_id = a.id
                LEFT JOIN genres g ON b.genre_id = g.id
                ORDER BY b.created_at DESC";
        $result = $this->conn->query($sql);
        if ($result) {
            while($row = $result->fetch_assoc()) {
                $books[] = $row;
            }
        }
        return $books;
    }

    public function findById($id) {
        $sql = "SELECT b.*, a.name as author_name, g.name as genre_name
                FROM books b
                LEFT JOIN authors a ON b.author_id = a.id
                LEFT JOIN genres g ON b.genre_id = g.id
                WHERE b.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create($data, $cover_image) {
        $stmt = $this->conn->prepare(
            "INSERT INTO books (title, synopsis, cover_image, publication_date, author_id, genre_id) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("ssssii", 
            $data['title'], $data['synopsis'], $cover_image,
            $data['publication_date'], $data['author_id'], $data['genre_id']
        );
        return $stmt->execute();
    }

    public function update($id, $data, $cover_image) {
        $stmt = $this->conn->prepare(
            "UPDATE books SET title = ?, synopsis = ?, cover_image = ?, 
             publication_date = ?, author_id = ?, genre_id = ? 
             WHERE id = ?"
        );
        $stmt->bind_param("ssssiii",
            $data['title'], $data['synopsis'], $cover_image,
            $data['publication_date'], $data['author_id'], $data['genre_id'],
            $id
        );
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM books WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function countAll() {
        $result = $this->conn->query("SELECT COUNT(*) as count FROM books");
        $row = $result->fetch_assoc();
        return $row['count'];
    }

   public function getBooksByAuthorId($author_id) {
        $books = [];
        $sql = "SELECT b.id, b.title, b.cover_image, COUNT(r.id) as review_count, AVG(r.rating) as avg_rating
                FROM books b
                LEFT JOIN reviews r ON b.id = r.book_id
                WHERE b.author_id = ?
                GROUP BY b.id ORDER BY b.title ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $author_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) { while($row = $result->fetch_assoc()) { $books[] = $row; } }
        return $books;
    }

    public function countByAuthorId($author_id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM books WHERE author_id = ?");
        $stmt->bind_param("i", $author_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'];
    }
}