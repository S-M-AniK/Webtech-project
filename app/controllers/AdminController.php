<?php
// App/controllers/AdminController.php
require_once ROOT_PATH . '/App/core/Database.php';
require_once ROOT_PATH . '/App/models/Book.php';
require_once ROOT_PATH . '/App/models/Author.php';
require_once ROOT_PATH . '/App/models/Genre.php';
require_once ROOT_PATH . '/App/models/Review.php';
require_once ROOT_PATH . '/App/models/User.php';

class AdminController {
    private $db;

    public function __construct() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('location: index.php?page=home');
            exit('Access Denied: You must be an administrator.');
        }
        $this->db = new Database();
    }

    public function dashboard() {
        $bookModel = new Book($this->db->getConnection());
        $authorModel = new Author($this->db->getConnection());
        $genreModel = new Genre($this->db->getConnection());
        $reviewModel = new Review($this->db->getConnection());
        $userModel = new User($this->db->getConnection());
        $data = [
            'book_count' => $bookModel->countAll(),
            'author_count' => $authorModel->countAll(),
            'genre_count' => $genreModel->countAll(),
            'review_count' => $reviewModel->countAll(),
            'user_count' => count($userModel->getAll())
        ];
        require_once ROOT_PATH . '/App/views/admin_dashboard.view.php';
    }
    
    // --- Book Management ---
    public function manageBooks() {
        $bookModel = new Book($this->db->getConnection());
        $data['books'] = $bookModel->getAll();
        require_once ROOT_PATH . '/App/views/admin_manage_books.view.php';
    }

    public function showAddBookForm() {
        $authorModel = new Author($this->db->getConnection());
        $genreModel = new Genre($this->db->getConnection());
        $data['authors'] = $authorModel->getAll();
        $data['genres'] = $genreModel->getAll();
        require_once ROOT_PATH . '/App/views/admin_add_book.view.php';
    }

    public function addBook() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cover_image_name = 'default_cover.png';
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
                $target_dir = "uploads/covers/";
                $image_name = time() . '_' . basename($_FILES["cover_image"]["name"]);
                if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_dir . $image_name)) {
                    $cover_image_name = $image_name;
                }
            }
            $bookModel = new Book($this->db->getConnection());
            if ($bookModel->create($_POST, $cover_image_name)) {
                header('location: index.php?page=admin-manage-books');
            } else { die('Something went wrong while adding the book.'); }
        }
    }

    public function showEditBookForm() {
        if (!isset($_GET['id'])) { die('Book ID is required.'); }
        $id = (int)$_GET['id'];
        $bookModel = new Book($this->db->getConnection());
        $authorModel = new Author($this->db->getConnection());
        $genreModel = new Genre($this->db->getConnection());
        $data['book'] = $bookModel->findById($id);
        $data['authors'] = $authorModel->getAll();
        $data['genres'] = $genreModel->getAll();
        if (!$data['book']) { die('Book not found.'); }
        require_once ROOT_PATH . '/App/views/admin_edit_book.view.php';
    }

    public function updateBook() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = (int)$_POST['id'];
            $bookModel = new Book($this->db->getConnection());
            $currentBook = $bookModel->findById($id);
            $cover_image_name = $currentBook['cover_image']; 
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
                $target_dir = "uploads/covers/";
                $image_name = time() . '_' . basename($_FILES["cover_image"]["name"]);
                if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_dir . $image_name)) {
                    $cover_image_name = $image_name;
                }
            }
            if ($bookModel->update($id, $_POST, $cover_image_name)) {
                header('location: index.php?page=admin-manage-books');
            } else { die('Something went wrong while updating the book.'); }
        }
    }

    public function deleteBook() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
            $bookModel = new Book($this->db->getConnection());
            if ($bookModel->delete($_POST['id'])) {
                header('location: index.php?page=admin-manage-books');
            } else { die('Failed to delete book.'); }
        }
    }

    // --- Author Management ---
    public function manageAuthors() {
        $authorModel = new Author($this->db->getConnection());
        $data['authors'] = $authorModel->getAll();
        require_once ROOT_PATH . '/App/views/admin_manage_authors.view.php';
    }

    public function showAddAuthorForm() {
        require_once ROOT_PATH . '/App/views/admin_add_author.view.php';
    }

    public function addAuthor() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image_name = 'default_author.png';
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
                $target_dir = "uploads/profiles/";
                $image_name = time() . '_' . basename($_FILES["profile_image"]["name"]);
                move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_dir . $image_name);
            }
            $authorModel = new Author($this->db->getConnection());
            if ($authorModel->create($_POST['name'], $_POST['bio'], $image_name)) {
                header('location: index.php?page=admin-manage-authors');
            } else { die('Failed to add author.'); }
        }
    }

    public function showEditAuthorForm() {
        $id = (int)$_GET['id'];
        $authorModel = new Author($this->db->getConnection());
        $userModel = new User($this->db->getConnection());
        $data['author'] = $authorModel->findById($id);
        $data['users'] = $userModel->getAll();
        require_once ROOT_PATH . '/App/views/admin_edit_author.view.php';
    }

    public function updateAuthor() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = (int)$_POST['id'];
            $user_id = (int)$_POST['user_id'];
            $authorModel = new Author($this->db->getConnection());
            $currentAuthor = $authorModel->findById($id);
            $image_name = $currentAuthor['profile_image'];
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
                $target_dir = "uploads/profiles/";
                $image_name = time() . '_' . basename($_FILES["profile_image"]["name"]);
                move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_dir . $image_name);
            }
            if ($authorModel->update($id, $_POST['name'], $_POST['bio'], $image_name, $user_id)) {
                header('location: index.php?page=admin-manage-authors');
            } else { die('Failed to update author.'); }
        }
    }
    
    public function deleteAuthor() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = (int)$_POST['id'];
            $authorModel = new Author($this->db->getConnection());
            if ($authorModel->delete($id)) {
                header('location: index.php?page=admin-manage-authors');
            } else { die('Failed to delete author.'); }
        }
    }

    // --- Genre Management ---
    public function manageGenres() {
        $genreModel = new Genre($this->db->getConnection());
        $data['genres'] = $genreModel->getAll();
        require_once ROOT_PATH . '/App/views/admin_manage_genres.view.php';
    }

    public function showAddGenreForm() {
        require_once ROOT_PATH . '/App/views/admin_add_genre.view.php';
    }

    public function addGenre() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim(htmlspecialchars($_POST['name']));
            if (!empty($name)) {
                $genreModel = new Genre($this->db->getConnection());
                if ($genreModel->create($name)) {
                    header('location: index.php?page=admin-manage-genres');
                } else { die('Failed to add genre.'); }
            }
        }
    }

    public function showEditGenreForm() {
        $id = (int)$_GET['id'];
        $genreModel = new Genre($this->db->getConnection());
        $data['genre'] = $genreModel->findById($id);
        require_once ROOT_PATH . '/App/views/admin_edit_genre.view.php';
    }

    public function updateGenre() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = (int)$_POST['id'];
            $name = trim(htmlspecialchars($_POST['name']));
            if (!empty($name)) {
                $genreModel = new Genre($this->db->getConnection());
                if ($genreModel->update($id, $name)) {
                    header('location: index.php?page=admin-manage-genres');
                } else { die('Failed to update genre.'); }
            }
        }
    }
    
    public function deleteGenre() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = (int)$_POST['id'];
            $genreModel = new Genre($this->db->getConnection());
            if ($genreModel->delete($id)) {
                header('location: index.php?page=admin-manage-genres');
            } else { die('Failed to delete genre.'); }
        }
    }

    // --- User Management ---
    public function manageUsers() {
        $userModel = new User($this->db->getConnection());
        $data['users'] = $userModel->getAll();
        require_once ROOT_PATH . '/App/views/admin_manage_users.view.php';
    }

    public function showEditUserForm() {
        $id = (int)$_GET['id'];
        $userModel = new User($this->db->getConnection());
        $data['user'] = $userModel->findById($id);
        require_once ROOT_PATH . '/App/views/admin_edit_user.view.php';
    }

    public function updateUser() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = (int)$_POST['id'];
            $role = $_POST['role'];
            $userModel = new User($this->db->getConnection());
            if ($userModel->updateRole($id, $role)) {
                header('location: index.php?page=admin-manage-users');
            } else { die('Failed to update user role.'); }
        }
    }
    
    public function deleteUser() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = (int)$_POST['id'];
            if ($id == $_SESSION['user_id']) {
                die('Error: You cannot delete your own admin account.');
            }
            $userModel = new User($this->db->getConnection());
            if ($userModel->delete($id)) {
                header('location: index.php?page=admin-manage-users');
            } else { die('Failed to delete user.'); }
        }
    }
}