<?php $books = $data['books']; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Books</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-wrapper">
        <aside class="admin-sidebar author-sidebar-restyle">
            <div class="sidebar-header"><h3><i class="fas fa-feather-alt"></i> Author Panel</h3></div>
            <ul class="sidebar-menu">
                <li><a href="index.php?page=author-dashboard"><i class="fas fa-chart-line"></i> <span>Dashboard</span></a></li>
                <li><a href="index.php?page=author-my-books" class="active"><i class="fas fa-book-open"></i> <span>My Books</span></a></li>
                <li><a href="index.php?page=author-edit-profile"><i class="fas fa-user-edit"></i> <span>Edit Profile</span></a></li>
                <li class="sidebar-separator"></li>
                <li><a href="index.php?page=home"><i class="fas fa-eye"></i> <span>View Site</span></a></li>
                <li><a href="index.php?page=logout"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
            </ul>
        </aside>
        <main class="admin-main-content">
            <header class="admin-main-header"><h1 class="admin-page-title">My Books</h1></header>
            <section class="admin-content-section">
                <table class="admin-table">
                    <thead><tr><th>Cover</th><th>Title</th><th>Total Reviews</th><th>Average Rating</th></tr></thead>
                    <tbody>
                        <?php foreach ($books as $book): ?>
                        <tr>
                            <td><img src="uploads/covers/<?php echo htmlspecialchars($book['cover_image']); ?>" alt="Cover" width="50"></td>
                            <td><?php echo htmlspecialchars($book['title']); ?></td>
                            <td><?php echo $book['review_count']; ?></td>
                            <td><?php echo round($book['avg_rating'] ?? 0, 2); ?> <i class="fas fa-star" style="color: #FFD700;"></i></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>