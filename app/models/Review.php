<?php
// App/models/Review.php

class Review {
    private $conn;

    public function __construct($db_connection) {
        $this->conn = $db_connection;
    }

    public function getLatest() {
        $reviews = [];
        $sql = "SELECT r.review_text, r.rating, u.username, b.title as book_title
                FROM reviews r
                JOIN users u ON r.user_id = u.id
                JOIN books b ON r.book_id = b.id
                ORDER BY r.created_at DESC
                LIMIT 3";
        $result = $this->conn->query($sql);
        if ($result) {
            while($row = $result->fetch_assoc()) {
                $reviews[] = $row;
            }
        }
        return $reviews;
    }

    public function findByBookId($book_id) {
        $reviews = [];
        $sql = "SELECT r.*, u.username 
                FROM reviews r 
                JOIN users u ON r.user_id = u.id
                WHERE r.book_id = ? 
                ORDER BY r.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            while($row = $result->fetch_assoc()) {
                $reviews[] = $row;
            }
        }
        return $reviews;
    }

    public function create($book_id, $user_id, $rating, $review_text) {
        $stmt = $this->conn->prepare(
            "INSERT INTO reviews (book_id, user_id, rating, review_text) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("iiis", $book_id, $user_id, $rating, $review_text);
        return $stmt->execute();
    }

    public function countAll() {
        $result = $this->conn->query("SELECT COUNT(*) as count FROM reviews");
        $row = $result->fetch_assoc();
        return $row['count'];
    }
   public function getStatsForAuthor($author_id) {
        $sql = "SELECT COUNT(r.id) as total_reviews, AVG(r.rating) as avg_rating
                FROM reviews r JOIN books b ON r.book_id = b.id
                WHERE b.author_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $author_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getLatestForAuthor($author_id) {
        $reviews = [];
        // This is the corrected SQL query
        $sql = "SELECT r.id, r.review_text, r.rating, u.username, b.title as book_title
                FROM reviews r
                JOIN books b ON r.book_id = b.id
                JOIN users u ON r.user_id = u.id
                WHERE b.author_id = ?
                ORDER BY r.created_at DESC
                LIMIT 5";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $author_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            while($row = $result->fetch_assoc()) {
                $reviews[] = $row;
            }
        }
        return $reviews;
    }
    public function getUserIdForReview($review_id) {
        $stmt = $this->conn->prepare("SELECT user_id FROM reviews WHERE id = ?");
        $stmt->bind_param("i", $review_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['user_id'] ?? null;
    }
}