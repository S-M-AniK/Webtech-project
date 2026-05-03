<?php 
$author = $data['author'];
$users = $data['users'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Author</title>
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
                <li><a href="index.php?page=admin-manage-authors" class="active"><i class="fas fa-users"></i> Manage Authors</a></li>
                <li><a href="index.php?page=admin-manage-genres"><i class="fas fa-tags"></i> Manage Genres</a></li>
                <li><a href="index.php?page=admin-manage-users"><i class="fas fa-user-cog"></i> Manage Users</a></li>
                <li><a href="index.php?page=home"><i class="fas fa-eye"></i> View Site</a></li>
                <li><a href="index.php?page=logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>
        <main class="admin-main-content">
            <header class="admin-main-header">
                <h1 class="admin-page-title">Edit Author</h1>
                <div class="user-info"><i class="fas fa-user-circle"></i> Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?></div>
            </header>
            <section class="admin-content-section">
                <h2 class="section-heading">Editing: <?php echo htmlspecialchars($author['name']); ?></h2>
                <form action="index.php?page=admin-update-author" method="POST" enctype="multipart/form-data" class="admin-form">
                    <input type="hidden" name="id" value="<?php echo $author['id']; ?>">
                    <div class="form-group"><label for="name">Author Name</label><input type="text" name="name" id="name" value="<?php echo htmlspecialchars($author['name']); ?>" required></div>
                    <div class="form-group"><label for="bio">Biography</label><textarea name="bio" id="bio" rows="5"><?php echo htmlspecialchars($author['bio']); ?></textarea></div>
                    
                    <div class="form-group">
                        <label for="user_id">Linked User Account</label>
                        <select name="user_id" id="user_id">
                            <option value="">-- No Linked User --</option>
                            <?php foreach ($users as $user): ?>
                            <option value="<?php echo $user['id']; ?>" <?php if ($user['id'] == $author['user_id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($user['username']); ?> (<?php echo htmlspecialchars($user['email']); ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="profile_image">New Profile Image</label>
                        <input type="file" name="profile_image" id="profile_image" accept="image/*">
                        <p>Current: <img src="uploads/profiles/<?php echo htmlspecialchars($author['profile_image']); ?>" width="50" alt="Current Profile Image"></p>
                    </div>
                    <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Update Author</button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>