<?php
// app/controllers/HomeController.php
require_once ROOT_PATH . '/App/core/Database.php';
require_once ROOT_PATH . '/App/models/Book.php';
require_once ROOT_PATH . '/App/models/Genre.php';
require_once ROOT_PATH . '/App/models/Author.php'; // Add this
require_once ROOT_PATH . '/App/models/Review.php'; // Add this

class HomeController {
    
    public function index() {
        $database = new Database();
        $db_conn = $database->getConnection();
        
        // Instantiate all the Models
        $bookModel = new Book($db_conn);
        $genreModel = new Genre($db_conn);
        $authorModel = new Author($db_conn); // Add this
        $reviewModel = new Review($db_conn); // Add this
        
        // Get all data for the homepage
        $data = [
            'books' => $bookModel->getAll(),
            'genres' => $genreModel->getAll(),
            'authors' => $authorModel->getFeatured(), // Add this
            'reviews' => $reviewModel->getLatest()   // Add this
        ];

        // Load the view and pass all the data
        require_once ROOT_PATH . '/App/views/home.view.php';
    }
}