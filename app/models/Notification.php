<?php
// App/models/Notification.php

class Notification {
    private $conn;

    public function __construct($db_connection) {
        $this->conn = $db_connection;
    }

    public function create($user_id, $author_id, $review_id, $book_id) {
        $stmt = $this->conn->prepare(
            "INSERT INTO notifications (user_id, author_id, review_id, book_id) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("iiii", $user_id, $author_id, $review_id, $book_id);
        return $stmt->execute();
    }

    public function getUnreadForUser($user_id) {
        $notifications = [];
        $sql = "SELECT n.*, a.name as author_name, b.title as book_title
                FROM notifications n
                JOIN authors a ON n.author_id = a.id
                JOIN books b ON n.book_id = b.id
                WHERE n.user_id = ?
                ORDER BY n.created_at DESC
                LIMIT 10";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            while($row = $result->fetch_assoc()) {
                $notifications[] = $row;
            }
        }
        return $notifications;
    }

    public function markAsRead($user_id) {
        $stmt = $this->conn->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ? AND is_read = 0");
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }
}