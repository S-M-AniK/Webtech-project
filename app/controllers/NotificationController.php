<?php
// App/controllers/NotificationController.php
require_once ROOT_PATH . '/App/core/Database.php';
require_once ROOT_PATH . '/App/models/Notification.php';

class NotificationController {
    private $db;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            exit('Access Denied.');
        }
        $this->db = new Database();
    }

    // Fetch unread notifications as JSON data
    public function getNotifications() {
        $notificationModel = new Notification($this->db->getConnection());
        $notifications = $notificationModel->getUnreadForUser($_SESSION['user_id']);
        header('Content-Type: application/json');
        echo json_encode($notifications);
    }

    // Mark notifications as read
    public function markRead() {
        $notificationModel = new Notification($this->db->getConnection());
        $notificationModel->markAsRead($_SESSION['user_id']);
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success']);
    }
}