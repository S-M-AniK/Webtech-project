<?php
// Organize books by status
$books = $data['books'];
$want_to_read = array_filter($books, fn($b) => $b['status'] == 'want_to_read');
$in_progress = array_filter($books, fn($b) => $b['status'] == 'in_progress');
$completed = array_filter($books, fn($b) => $b['status'] == 'completed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Bookshelf - BookReview</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="main-header">
        <div class="header-container">
             <a href="index.php?page=home" class="logo">SHELF talk</a>
            <nav class="navigation">
                <a href="index.php?page=home">Home</a>
                <a href="index.php?page=my-books">My Books</a>
<?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'author'): ?>
    <a href="index.php?page=author-dashboard">Author Panel</a>
<?php endif; ?>
                <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                    <a href="index.php?page=admin-dashboard">Admin Panel</a>
                <?php endif; ?>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="notification-area">
                        <a href="#" class="notification-bell" id="notificationBell">
                            <i class='bx bxs-bell'></i>
                            <span class="notification-count" id="notificationCount">0</span>
                        </a>
                        <div class="notification-dropdown" id="notificationDropdown"></div>
                    </div>
                    <a href="#" class="nav-user"><span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span><i class='bx bxs-user-circle'></i></a>
                    <a href="index.php?page=logout" class="btn-logout" title="Logout"><i class='bx bx-log-out'></i></a>
                <?php else: ?>
                    <a href="#" class="btn-login" id="loginBtn">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="container">
        <h1 class="page-title">My Bookshelf</h1>

        <div class="progress-overview-grid">
            <div class="progress-card completed-card">
                <i class='bx bx-book-bookmark'></i>
                <div class="progress-content">
                    <p class="progress-value"><?php echo count($completed); ?></p>
                    <p class="progress-label">Completed</p>
                </div>
            </div>
            <div class="progress-card in-progress-card">
                <i class='bx bx-book-reader'></i>
                <div class="progress-content">
                    <p class="progress-value"><?php echo count($in_progress); ?></p>
                    <p class="progress-label">In Progress</p>
                </div>
            </div>
            <div class="progress-card wishlist-card">
                <i class='bx bx-book-heart'></i>
                <div class="progress-content">
                    <p class="progress-value"><?php echo count($want_to_read); ?></p>
                    <p class="progress-label">Wishlist</p>
                </div>
            </div>
        </div>

        <div class="bookshelf-container">
            <div class="tabs">
                <a href="#want-to-read" class="tab-link active">Wishlist (<?php echo count($want_to_read); ?>)</a>
                <a href="#in-progress" class="tab-link">In Progress (<?php echo count($in_progress); ?>)</a>
                <a href="#completed" class="tab-link">Completed (<?php echo count($completed); ?>)</a>
            </div>

            <div id="want-to-read" class="tab-content active">
                <div class="my-books-grid">
                    <?php foreach($want_to_read as $book): ?>
                        <div class="my-book-card">
                            <img src="uploads/covers/<?php echo htmlspecialchars($book['cover_image']); ?>" alt="Cover">
                            <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                            <form action="index.php?page=update-book-status" method="POST">
                                <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                                <select name="status" onchange="this.form.submit()">
                                    <option value="want_to_read" selected>Move to...</option>
                                    <option value="in_progress">Start Reading</option>
                                    <option value="completed">Mark as Completed</option>
                                </select>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if (empty($want_to_read)): ?>
                    <div class="empty-state"><i class='bx bx-book-heart'></i><p>Your wishlist is empty.</p><a href="index.php?page=home" class="btn-primary">Find Books</a></div>
                <?php endif; ?>
            </div>

            <div id="in-progress" class="tab-content">
                <div class="my-books-grid">
                    <?php foreach($in_progress as $book): ?>
                        <div class="my-book-card">
                            <img src="uploads/covers/<?php echo htmlspecialchars($book['cover_image']); ?>" alt="Cover">
                            <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                            <form action="index.php?page=update-book-status" method="POST">
                                <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                                <select name="status" onchange="this.form.submit()">
                                    <option value="in_progress" selected>Move to...</option>
                                    <option value="completed">Mark as Completed</option>
                                    <option value="want_to_read">Move to Wishlist</option>
                                </select>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
                 <?php if (empty($in_progress)): ?>
                    <div class="empty-state"><i class='bx bx-book-reader'></i><p>You are not currently reading any books.</p></div>
                <?php endif; ?>
            </div>

            <div id="completed" class="tab-content">
                 <div class="my-books-grid">
                    <?php foreach($completed as $book): ?>
                        <div class="my-book-card completed">
                            <img src="uploads/covers/<?php echo htmlspecialchars($book['cover_image']); ?>" alt="Cover">
                            <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                            <div class="completed-badge"><i class='bx bx-check-circle'></i> Finished</div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if (empty($completed)): ?>
                    <div class="empty-state"><i class='bx bx-book-bookmark'></i><p>You haven't completed any books yet.</p></div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    
    <footer class="main-footer">
        <div class="footer-content">
            <h3>BookReview</h3>
            <p>Share your thoughts. Discover new reads.</p>
        </div>
        <div class="footer-bottom"><p>&copy; <?php echo date('Y'); ?> BookReview. All Rights Reserved.</p></div>
    </footer>

    <script src="js/main.js?v=2"></script>
</body>
</html>