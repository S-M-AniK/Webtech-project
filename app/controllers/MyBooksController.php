<?php
// App/controllers/MyBooksController.php
require_once ROOT_PATH . '/App/core/Database.php';
require_once ROOT_PATH . '/App/models/UserBook.php';

class MyBooksController {
    private $db;

    public function __construct() {
        // Protect all routes in this controller
        if (!isset($_SESSION['user_id'])) {
            header('location: index.php?page=home');
            exit('You must be logged in to view this page.');
        }
        $this->db = new Database();
    }

    // Show the "My Books" page
    public function index() {
        $userBookModel = new UserBook($this->db->getConnection());
        $data['books'] = $userBookModel->getBooksForUser($_SESSION['user_id']);
        require_once ROOT_PATH . '/App/views/my_books.view.php';
    }

    // Handle updating a book's status
    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $book_id = (int)$_POST['book_id'];
            $status = $_POST['status'];
            
            $userBookModel = new UserBook($this->db->getConnection());
            if ($userBookModel->updateStatus($_SESSION['user_id'], $book_id, $status)) {
                header('location: index.php?page=my-books');
            } else {
                die('Failed to update status.');
            }
        }
    }
}