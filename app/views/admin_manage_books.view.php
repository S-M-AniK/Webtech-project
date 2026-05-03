<?php $books = $data['books']; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Books</title>
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
                <li><a href="index.php?page=admin-dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="index.php?page=admin-manage-books" class="active"><i class="fas fa-book"></i> Manage Books</a></li>
                <li><a href="index.php?page=admin-manage-authors"><i class="fas fa-users"></i> Manage Authors</a></li>
                <li><a href="index.php?page=admin-manage-genres"><i class="fas fa-tags"></i> Manage Genres</a></li>
                <li><a href="index.php?page=admin-manage-users"><i class="fas fa-user-cog"></i> Manage Users</a></li>
                <li><a href="index.php?page=home"><i class="fas fa-eye"></i> View Site</a></li>
                <li><a href="index.php?page=logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>

        <main class="admin-main-content">
            <header class="admin-main-header">
                <h1 class="admin-page-title">Manage Books</h1>
                <div class="user-info">
                    <i class="fas fa-user-circle"></i> 
                    Welcome, <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Admin'; ?>
                </div>
            </header>
            
            <section class="admin-content-section">
                <div class="admin-actions">
                    <h2 class="section-heading">Book List</h2>
                    <a href="index.php?page=admin-add-book-form" class="btn-primary"><i class="fas fa-plus"></i> Add New Book</a>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Cover</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Genre</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $book): ?>
                        <tr>
                            <td><img src="uploads/covers/<?php echo htmlspecialchars($book['cover_image']); ?>" alt="Cover" width="50"></td>
                            <td><?php echo htmlspecialchars($book['title']); ?></td>
                            <td><?php echo htmlspecialchars($book['author_name']); ?></td>
                            <td><?php echo htmlspecialchars($book['genre_name']); ?></td>
                            <td class="actions-cell">
                                <a href="index.php?page=admin-edit-book-form&id=<?php echo $book['id']; ?>" class="btn-secondary"><i class="fas fa-edit"></i> Edit</a>
                                <form action="index.php?page=admin-delete-book" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this book?');" class="btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>
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