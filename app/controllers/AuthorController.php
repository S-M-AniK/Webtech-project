<?php
// App/controllers/AuthorController.php
require_once ROOT_PATH . '/App/core/Database.php';
require_once ROOT_PATH . '/App/models/Author.php';
require_once ROOT_PATH . '/App/models/Book.php';
require_once ROOT_PATH . '/App/models/Review.php';
require_once ROOT_PATH . '/App/models/Reply.php';
require_once ROOT_PATH . '/App/models/Notification.php';

class AuthorController {
    private $db;
    private $author_id;
    private $author_profile;

    public function __construct() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'author') {
            header('location: index.php?page=home');
            exit('Access Denied: You must be an author to view this page.');
        }
        $this->db = new Database();
        $authorModel = new Author($this->db->getConnection());
        $this->author_profile = $authorModel->findByUserId($_SESSION['user_id']);
        if ($this->author_profile) {
            $this->author_id = $this->author_profile['id'];
        } else {
            exit('Author profile not found for this user. Please ask an admin to link your account.');
        }
    }

    public function dashboard() {
        $bookModel = new Book($this->db->getConnection());
        $reviewModel = new Review($this->db->getConnection());
        $replyModel = new Reply($this->db->getConnection());

        $recent_reviews = $reviewModel->getLatestForAuthor($this->author_id);
        $review_ids = !empty($recent_reviews) ? array_column($recent_reviews, 'id') : [];
        
        $data = [
            'book_count' => $bookModel->countByAuthorId($this->author_id),
            'review_stats' => $reviewModel->getStatsForAuthor($this->author_id),
            'books_for_chart' => $bookModel->getBooksByAuthorId($this->author_id),
            'recent_reviews' => $recent_reviews,
            'replies' => $replyModel->findByReviewIds($review_ids)
        ];
        require_once ROOT_PATH . '/App/views/author_dashboard.view.php';
    }

    public function addReply() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $review_id = (int)$_POST['review_id'];
        $reply_text = trim(htmlspecialchars($_POST['reply_text']));
        
        $replyModel = new Reply($this->db->getConnection());
        if ($replyModel->create($review_id, $this->author_id, $reply_text)) {
            // --- Create Notification ---
            $reviewModel = new Review($this->db->getConnection());
            $original_reviewer_id = $reviewModel->getUserIdForReview($review_id);
            $book_id = $this->db->getConnection()->query("SELECT book_id FROM reviews WHERE id = $review_id")->fetch_assoc()['book_id'];

            if ($original_reviewer_id) {
                $notificationModel = new Notification($this->db->getConnection());
                $notificationModel->create($original_reviewer_id, $this->author_id, $review_id, $book_id);
            }
            // --- End Notification ---
            
            header('location: index.php?page=author-panel&section=dashboard');
        } else { die('Failed to submit reply.'); }
    }
}

    public function myBooks() {
        $bookModel = new Book($this->db->getConnection());
        $data['books'] = $bookModel->getBooksByAuthorId($this->author_id);
        require_once ROOT_PATH . '/App/views/author_my_books.view.php';
    }

    public function showEditProfileForm() {
        $data['author'] = $this->author_profile;
        require_once ROOT_PATH . '/App/views/author_edit_profile.view.php';
    }
    
    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $authorModel = new Author($this->db->getConnection());
            $image_name = $this->author_profile['profile_image'];

            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
                $target_dir = "uploads/profiles/";
                $image_name = time() . '_' . basename($_FILES["profile_image"]["name"]);
                move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_dir . $image_name);
            }
            if ($authorModel->update($this->author_id, $_POST['name'], $_POST['bio'], $image_name, $_SESSION['user_id'])) {
                header('location: index.php?page=author-panel&section=dashboard');
            } else { die('Failed to update profile.'); }
        }
    }
}