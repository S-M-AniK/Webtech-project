<?php
// App/models/Reply.php

class Reply {
    private $conn;

    public function __construct($db_connection) {
        $this->conn = $db_connection;
    }

    public function create($review_id, $author_id, $reply_text) {
        $stmt = $this->conn->prepare("INSERT INTO author_replies (review_id, author_id, reply_text) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $review_id, $author_id, $reply_text);
        return $stmt->execute();
    }

    // Efficiently gets all replies for a given list of review IDs
    public function findByReviewIds($review_ids) {
        $replies = [];
        if (empty($review_ids)) {
            return $replies;
        }
        $in_clause = implode(',', array_fill(0, count($review_ids), '?'));
        $types = str_repeat('i', count($review_ids));
        
        $sql = "SELECT * FROM author_replies WHERE review_id IN ($in_clause)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$review_ids);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                // Use review_id as the key for easy lookup
                $replies[$row['review_id']] = $row;
            }
        }
        return $replies;
    }
}