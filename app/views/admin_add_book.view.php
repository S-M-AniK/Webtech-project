<?php
$authors = $data['authors'];
$genres = $data['genres'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Book</title>
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
                <li><a href="#"><i class="fas fa-users"></i> Manage Authors</a></li>
                <li><a href="index.php?page=admin-manage-genres"><i class="fas fa-tags"></i> Manage Genres</a></li>
                <li><a href="#"><i class="fas fa-user-cog"></i> Manage Users</a></li>
                <li><a href="index.php?page=home"><i class="fas fa-eye"></i> View Site</a></li>
                <li><a href="index.php?page=logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>

        <main class="admin-main-content">
            <header class="admin-main-header">
                <h1 class="admin-page-title">Add New Book</h1>
                <div class="user-info">
                    <i class="fas fa-user-circle"></i> 
                    Welcome, <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Admin'; ?>
                </div>
            </header>
            
            <section class="admin-content-section">
                <h2 class="section-heading">New Book Details</h2>
                <form action="index.php?page=admin-add-book" method="POST" enctype="multipart/form-data" class="admin-form">
                    <div class="form-group"><label for="title">Title</label><input type="text" name="title" id="title" required></div>
                    <div class="form-group"><label for="synopsis">Synopsis</label><textarea name="synopsis" id="synopsis" rows="5" required></textarea></div>
                    <div class="form-group"><label for="author_id">Author</label>
                        <select name="author_id" id="author_id" required>
                            <?php foreach ($authors as $author): ?>
                            <option value="<?php echo $author['id']; ?>"><?php echo htmlspecialchars($author['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group"><label for="genre_id">Genre</label>
                        <select name="genre_id" id="genre_id" required>
                            <?php foreach ($genres as $genre): ?>
                            <option value="<?php echo $genre['id']; ?>"><?php echo htmlspecialchars($genre['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group"><label for="publication_date">Publication Date</label><input type="date" name="publication_date" id="publication_date" required></div>
                    <div class="form-group"><label for="cover_image">Cover Image</label><input type="file" name="cover_image" id="cover_image" accept="image/*"></div>
                    <button type="submit" class="btn-primary"><i class="fas fa-plus"></i> Add Book</button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>