<?php
// Extract the data variables passed from the AdminController
$book_count = $data['book_count'];
$author_count = $data['author_count'];
$genre_count = $data['genre_count'];
$review_count = $data['review_count'];
$user_count = $data['user_count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-wrapper">
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-book-reader"></i> BookReview Admin</h3>
            </div>
            <ul class="sidebar-menu">
                <li><a href="index.php?page=admin-dashboard" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="index.php?page=admin-manage-books"><i class="fas fa-book"></i> Manage Books</a></li>
                <li><a href="index.php?page=admin-manage-authors"><i class="fas fa-users"></i> Manage Authors</a></li>
                <li><a href="index.php?page=admin-manage-genres"><i class="fas fa-tags"></i> Manage Genres</a></li>
                <li><a href="index.php?page=admin-manage-users"><i class="fas fa-user-cog"></i> Manage Users</a></li>
                <li><a href="index.php?page=home"><i class="fas fa-eye"></i> View Site</a></li>
                <li><a href="index.php?page=logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>

        <main class="admin-main-content">
            <header class="admin-main-header">
                <h1 class="admin-page-title">Dashboard</h1>
                <div class="user-info">
                    <i class="fas fa-user-circle"></i> 
                    Welcome, <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Admin'; ?>
                </div>
            </header>
            
            <section class="admin-stats-grid">
                <div class="stat-card">
                    <i class="fas fa-book stat-icon"></i>
                    <div class="stat-content">
                        <p class="stat-label">Total Books</p>
                        <p class="stat-value"><?php echo $book_count; ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-users stat-icon"></i>
                    <div class="stat-content">
                        <p class="stat-label">Total Authors</p>
                        <p class="stat-value"><?php echo $author_count; ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-tags stat-icon"></i>
                    <div class="stat-content">
                        <p class="stat-label">Total Genres</p>
                        <p class="stat-value"><?php echo $genre_count; ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-star stat-icon"></i>
                    <div class="stat-content">
                        <p class="stat-label">Total Reviews</p>
                        <p class="stat-value"><?php echo $review_count; ?></p>
                    </div>
                </div>
            </section>

            <section class="admin-quick-actions">
                <h2>Quick Actions</h2>
                <div class="quick-action-grid">
                    <a href="index.php?page=admin-add-book-form" class="quick-action-card">
                        <i class="fas fa-plus-circle"></i>
                        <h3>Add New Book</h3>
                        <p>Quickly add a new title to the library.</p>
                    </a>
                    <a href="index.php?page=admin-manage-authors" class="quick-action-card">
                        <i class="fas fa-user-plus"></i>
                        <h3>Add New Author</h3>
                        <p>Register a new author profile.</p>
                    </a>
                    <a href="index.php?page=admin-manage-users" class="quick-action-card">
                        <i class="fas fa-user-cog"></i>
                        <h3>Manage Users</h3>
                        <p>View users and update their roles.</p>
                    </a>
                </div>
            </section>
        </main>
    </div>
</body>
</html>