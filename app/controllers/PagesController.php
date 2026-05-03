<?php
// app/controllers/PagesController.php
require_once ROOT_PATH . '/App/core/Database.php';
require_once ROOT_PATH . '/App/models/Book.php';
require_once ROOT_PATH . '/App/models/Genre.php';
require_once ROOT_PATH . '/App/models/Author.php';
require_once ROOT_PATH . '/App/models/Review.php';
require_once ROOT_PATH . '/App/models/UserBook.php';
require_once ROOT_PATH . '/App/models/Reply.php'; // This was the missing line

class PagesController {
    
    public function index() {
        $database = new Database();
        $db_conn = $database->getConnection();
        
        $bookModel = new Book($db_conn);
        $genreModel = new Genre($db_conn);
        $authorModel = new Author($db_conn);
        $reviewModel = new Review($db_conn);
        
        $data = [
            'books' => $bookModel->getAll(),
            'genres' => $genreModel->getAll(),
            'authors' => $authorModel->getFeatured(),
            'reviews' => $reviewModel->getLatest()
        ];
        require_once ROOT_PATH . '/App/views/home.view.php';
    }

    public function book() {
        if (!isset($_GET['id'])) { die('Book ID is required.'); }
        $book_id = (int)$_GET['id'];
        
        $database = new Database();
        $db_conn = $database->getConnection();
        
        $bookModel = new Book($db_conn);
        $reviewModel = new Review($db_conn);
        $userBookModel = new UserBook($db_conn);
        $replyModel = new Reply($db_conn);

        $reviews = $reviewModel->findByBookId($book_id);
        $review_ids = !empty($reviews) ? array_column($reviews, 'id') : [];

        $data = [
            'book' => $bookModel->findById($book_id),
            'reviews' => $reviews,
            'replies' => $replyModel->findByReviewIds($review_ids),
            'is_in_list' => isset($_SESSION['user_id']) ? $userBookModel->isBookInList($_SESSION['user_id'], $book_id) : false
        ];

        if (!$data['book']) { die('Book not found.'); }

        require_once ROOT_PATH . '/App/views/book.view.php';
    }

    public function addToList() {
        if (!isset($_SESSION['user_id'])) { die('You must be logged in.'); }
        if (!isset($_GET['id'])) { die('Book ID is required.'); }
        
        $book_id = (int)$_GET['id'];
        $user_id = $_SESSION['user_id'];

        $database = new Database();
        $userBookModel = new UserBook($database->getConnection());

        if ($userBookModel->add($user_id, $book_id)) {
            header('location: index.php?page=book&id=' . $book_id);
        } else {
            die('Failed to add book to list, or it is already in your list.');
        }
    }

    public function addReview() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('location: index.php?page=home');
            exit();
        }
        if (!isset($_SESSION['user_id'])) {
            die('You must be logged in to post a review.');
        }
        $book_id = (int)$_POST['book_id'];
        $rating = (int)$_POST['rating'];
        $review_text = trim(htmlspecialchars($_POST['review_text']));
        $user_id = $_SESSION['user_id'];
        if (empty($rating) || empty($review_text)) {
            die('Rating and review text are required.');
        }
        $database = new Database();
        $reviewModel = new Review($database->getConnection());
        if ($reviewModel->create($book_id, $user_id, $rating, $review_text)) {
            header('location: index.php?page=book&id=' . $book_id);
            exit();
        } else {
            die('Failed to submit review.');
        }
    }
}