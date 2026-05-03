<?php $author = $data['author']; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-wrapper">
        <aside class="admin-sidebar author-sidebar-restyle">
            <div class="sidebar-header"><h3><i class="fas fa-feather-alt"></i> Author Panel</h3></div>
            <ul class="sidebar-menu">
                <li><a href="index.php?page=author-dashboard"><i class="fas fa-chart-line"></i> <span>Dashboard</span></a></li>
                <li><a href="index.php?page=author-my-books"><i class="fas fa-book-open"></i> <span>My Books</span></a></li>
                <li><a href="index.php?page=author-edit-profile" class="active"><i class="fas fa-user-edit"></i> <span>Edit Profile</span></a></li>
                <li class="sidebar-separator"></li>
                <li><a href="index.php?page=home"><i class="fas fa-eye"></i> <span>View Site</span></a></li>
                <li><a href="index.php?page=logout"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
            </ul>
        </aside>
        <main class="admin-main-content">
            <header class="admin-main-header"><h1 class="admin-page-title">Edit Profile</h1></header>
            <section class="admin-content-section">
                <form action="index.php?page=author-update-profile" method="POST" enctype="multipart/form-data" class="admin-form">
                    <div class="form-group"><label for="name">Author Name</label><input type="text" name="name" id="name" value="<?php echo htmlspecialchars($author['name']); ?>" required></div>
                    <div class="form-group"><label for="bio">Biography</label><textarea name="bio" id="bio" rows="8"><?php echo htmlspecialchars($author['bio']); ?></textarea></div>
                    <div class="form-group">
                        <label for="profile_image">New Profile Image</label>
                        <input type="file" name="profile_image" id="profile_image" accept="image/*">
                        <p>Current: <img src="uploads/profiles/<?php echo htmlspecialchars($author['profile_image']); ?>" width="80" alt="Current Profile Image" style="border-radius: 50%;"></p>
                    </div>
                    <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>