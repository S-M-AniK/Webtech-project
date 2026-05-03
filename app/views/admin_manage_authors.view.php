<?php $authors = $data['authors']; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Authors</title>
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
    <li><a href="index.php?page=admin-manage-genres"><i class="fas fa-tags"></i> Manage Genres</a></li>
    <li><a href="index.php?page=admin-manage-users"><i class="fas fa-user-cog"></i> Manage Users</a></li>
    <li><a href="index.php?page=home"><i class="fas fa-eye"></i> View Site</a></li>
    <li><a href="index.php?page=logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
</ul>
        </aside>
        <main class="admin-main-content">
            <header class="admin-main-header">
                <h1 class="admin-page-title">Manage Authors</h1>
                <div class="user-info"><i class="fas fa-user-circle"></i> Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?></div>
            </header>
            <section class="admin-content-section">
                <div class="admin-actions">
                    <h2 class="section-heading">Author List</h2>
                    <a href="index.php?page=admin-add-author-form" class="btn-primary"><i class="fas fa-plus"></i> Add New Author</a>
                </div>
                <table class="admin-table">
                    <thead><tr><th>Name</th><th>Actions</th></tr></thead>
                    <tbody>
                        <?php foreach ($authors as $author): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($author['name']); ?></td>
                            <td>
                                <a href="index.php?page=admin-edit-author-form&id=<?php echo $author['id']; ?>" class="btn-secondary"><i class="fas fa-edit"></i> Edit</a>
                                <form action="index.php?page=admin-delete-author" method="POST" style="display:inline-block; margin-left: 5px;">
                                    <input type="hidden" name="id" value="<?php echo $author['id']; ?>">
                                    <button type="submit" onclick="return confirm('Are you sure?');" class="btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>