<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Author Panel</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="admin-wrapper">
        <aside class="admin-sidebar author-sidebar-restyle">
            <div class="sidebar-header"><h3><i class="fas fa-feather-alt"></i> Author Panel</h3></div>
            <ul class="sidebar-menu">
                <li><a href="index.php?page=author-panel&section=dashboard" class="<?php if($section == 'dashboard') echo 'active'; ?>"><i class="fas fa-chart-line"></i> <span>Dashboard</span></a></li>
                <li><a href="index.php?page=author-panel&section=my-books" class="<?php if($section == 'my-books') echo 'active'; ?>"><i class="fas fa-book-open"></i> <span>My Books</span></a></li>
                <li><a href="index.php?page=author-panel&section=edit-profile" class="<?php if($section == 'edit-profile') echo 'active'; ?>"><i class="fas fa-user-edit"></i> <span>Edit Profile</span></a></li>
                <li class="sidebar-separator"></li>
                <li><a href="index.php?page=home"><i class="fas fa-eye"></i> <span>View Site</span></a></li>
                <li><a href="index.php?page=logout"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
            </ul>
        </aside>
        <main class="admin-main-content">
            <?php
                // This is where the magic happens: we include the correct partial view
                if (!empty($partial_view)) {
                    require_once ROOT_PATH . '/App/views/author_partials/' . $partial_view;
                }
            ?>
        </main>
    </div>
</body>
</html>