<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Genre</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-wrapper">
        <aside class="admin-sidebar">
             <div class="sidebar-header"><h3><i class="fas fa-book-reader"></i> BookReview Admin</h3></div>
            <ul class="sidebar-menu">
                <li><a href="index.php?page=admin-dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="index.php?page=admin-manage-books"><i class="fas fa-book"></i> Manage Books</a></li>
                <li><a href="index.php?page=admin-manage-authors"><i class="fas fa-users"></i> Manage Authors</a></li>
                <li><a href="index.php?page=admin-manage-genres" class="active"><i class="fas fa-tags"></i> Manage Genres</a></li>
                <li><a href="#"><i class="fas fa-user-cog"></i> Manage Users</a></li>
                <li><a href="index.php?page=home"><i class="fas fa-eye"></i> View Site</a></li>
                <li><a href="index.php?page=logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>
        <main class="admin-main-content">
            <header class="admin-main-header">
                <h1 class="admin-page-title">Add New Genre</h1>
                <div class="user-info"><i class="fas fa-user-circle"></i> Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?></div>
            </header>
            <section class="admin-content-section">
                <h2 class="section-heading">New Genre Details</h2>
                <form action="index.php?page=admin-add-genre" method="POST" class="admin-form">
                    <div class="form-group"><label for="name">Genre Name</label><input type="text" name="name" id="name" required></div>
                    <button type="submit" class="btn-primary"><i class="fas fa-plus"></i> Add Genre</button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>