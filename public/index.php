<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT_PATH', dirname(__DIR__));
session_start();

$page = $_GET['page'] ?? 'home';

switch ($page) {
    // --- ADMIN BOOK ROUTES ---
    case 'admin-dashboard':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->dashboard();
        break;
    case 'admin-manage-books':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->manageBooks();
        break;
    case 'admin-add-book-form':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->showAddBookForm();
        break;
    case 'admin-add-book':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->addBook();
        break;
    case 'admin-edit-book-form':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->showEditBookForm();
        break;
    case 'admin-update-book':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->updateBook();
        break;
    case 'admin-delete-book':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->deleteBook();
        break;

    // --- ADMIN AUTHOR ROUTES ---
    case 'admin-manage-authors':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->manageAuthors();
        break;
    case 'admin-add-author-form':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->showAddAuthorForm();
        break;
    case 'admin-add-author':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->addAuthor();
        break;
    case 'admin-edit-author-form':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->showEditAuthorForm();
        break;
    case 'admin-update-author':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->updateAuthor();
        break;
    case 'admin-delete-author':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->deleteAuthor();
        break;

    // --- USER ROUTES ---
    case 'register':
        require_once ROOT_PATH . '/App/controllers/UserController.php';
        $controller = new UserController();
        $controller->register();
        break;
    case 'login':
        require_once ROOT_PATH . '/App/controllers/UserController.php';
        $controller = new UserController();
        $controller->login();
        break;
    case 'logout':
        require_once ROOT_PATH . '/App/controllers/UserController.php';
        $controller = new UserController();
        $controller->logout();
        break;

    // --- PAGES ROUTES ---
    case 'book':
        require_once ROOT_PATH . '/App/controllers/PagesController.php';
        $controller = new PagesController();
        $controller->book();
        break;
    case 'add-review':
        require_once ROOT_PATH . '/App/controllers/PagesController.php';
        $controller = new PagesController();
        $controller->addReview();
        break;

    case 'home':
    default:
        require_once ROOT_PATH . '/App/controllers/PagesController.php';
        $controller = new PagesController();
        $controller->index();
        break;

    // --- My Books Routes ---
    case 'my-books':
        require_once ROOT_PATH . '/App/controllers/MyBooksController.php';
        $controller = new MyBooksController();
        $controller->index();
        break;
    case 'add-to-list':
        require_once ROOT_PATH . '/App/controllers/PagesController.php';
        $controller = new PagesController();
        $controller->addToList();
        break;
    case 'update-book-status':
        require_once ROOT_PATH . '/App/controllers/MyBooksController.php';
        $controller = new MyBooksController();
        $controller->updateStatus();
        break;

    // --- Admin Genre Routes ---
    case 'admin-manage-genres':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->manageGenres();
        break;
    case 'admin-add-genre-form':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->showAddGenreForm();
        break;
    case 'admin-add-genre':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->addGenre();
        break;
    case 'admin-edit-genre-form':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->showEditGenreForm();
        break;
    case 'admin-update-genre':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->updateGenre();
        break;
    case 'admin-delete-genre':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->deleteGenre();
        break;
    // --- Admin User Routes ---
    case 'admin-manage-users':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->manageUsers();
        break;
    case 'admin-edit-user-form':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->showEditUserForm();
        break;
    case 'admin-update-user':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->updateUser();
        break;
    case 'admin-delete-user':
        require_once ROOT_PATH . '/App/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->deleteUser();
        break;
    // --- Author Routes ---
  
        
    case 'author-dashboard':
        require_once ROOT_PATH . '/App/controllers/AuthorController.php';
        $controller = new AuthorController();
        $controller->dashboard();
        break;
    case 'author-my-books':
        require_once ROOT_PATH . '/App/controllers/AuthorController.php';
        $controller = new AuthorController();
        $controller->myBooks();
        break;
    case 'author-edit-profile':
        require_once ROOT_PATH . '/App/controllers/AuthorController.php';
        $controller = new AuthorController();
        $controller->showEditProfileForm();
        break;
    case 'author-update-profile':
        require_once ROOT_PATH . '/App/controllers/AuthorController.php';
        $controller = new AuthorController();
        $controller->updateProfile();
        break;
    case 'author-add-reply':
        require_once ROOT_PATH . '/App/controllers/AuthorController.php';
        $controller = new AuthorController();
        $controller->addReply();
        break;
   // --- Notification API Routes ---
    case 'get-notifications':
        require_once ROOT_PATH . '/App/controllers/NotificationController.php';
        $controller = new NotificationController();
        $controller->getNotifications();
        break;
    case 'mark-notifications-read':
        require_once ROOT_PATH . '/App/controllers/NotificationController.php';
        $controller = new NotificationController();
        $controller->markRead();
        break;
}