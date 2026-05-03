<?php $user = $data['user']; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User Role</title>
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
                <li><a href="index.php?page=admin-manage-users" class="active"><i class="fas fa-user-cog"></i> Manage Users</a></li>
                <li><a href="index.php?page=home"><i class="fas fa-eye"></i> View Site</a></li>
                <li><a href="index.php?page=logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>
        <main class="admin-main-content">
            <header class="admin-main-header">
                <h1 class="admin-page-title">Edit User Role</h1>
                <div class="user-info"><i class="fas fa-user-circle"></i> Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?></div>
            </header>
            <section class="admin-content-section">
                <h2 class="section-heading">Editing User: <?php echo htmlspecialchars($user['username']); ?></h2>
                <form action="index.php?page=admin-update-user" method="POST" class="admin-form">
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" id="role" required>
                            <option value="user" <?php if($user['role'] == 'user') echo 'selected'; ?>>User</option>
                            <option value="author" <?php if($user['role'] == 'author') echo 'selected'; ?>>Author</option>
                            <option value="admin" <?php if($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Update Role</button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>