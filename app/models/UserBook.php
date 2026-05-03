<?php
// App/models/UserBook.php

class UserBook {
    private $conn;

    public function __construct($db_connection) {
        $this->conn = $db_connection;
    }

    // Adds a book to a user's list
    public function add($user_id, $book_id) {
        $stmt = $this->conn->prepare("INSERT INTO user_books (user_id, book_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $book_id);
        return $stmt->execute();
    }

    // Gets all books on a specific user's list
    public function getBooksForUser($user_id) {
        $books = [];
        $sql = "SELECT b.*, ub.status 
                FROM user_books ub
                JOIN books b ON ub.book_id = b.id
                WHERE ub.user_id = ?
                ORDER BY ub.status, b.title";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            while($row = $result->fetch_assoc()) {
                $books[] = $row;
            }
        }
        return $books;
    }

    // Updates the status of a book on a user's list
    public function updateStatus($user_id, $book_id, $status) {
        $stmt = $this->conn->prepare("UPDATE user_books SET status = ? WHERE user_id = ? AND book_id = ?");
        $stmt->bind_param("sii", $status, $user_id, $book_id);
        return $stmt->execute();
    }

    // Checks if a book is already in a user's list
    public function isBookInList($user_id, $book_id) {
        $stmt = $this->conn->prepare("SELECT id FROM user_books WHERE user_id = ? AND book_id = ?");
        $stmt->bind_param("ii", $user_id, $book_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
}