<?php
// Extract the data variables for easy use in the view
$books = $data['books'];
$genres = $data['genres'];
$authors = $data['authors'];
$reviews = $data['reviews'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookReview</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="modal" id="authModal">
        <div class="modal-box">
            <span class="close-modal" id="closeModal">&times;</span>
            <div class="form-container">
                <form id="loginForm" method="POST" action="index.php?page=login" class="auth-form active">
                    <div class="form-header"><i class='bx bx-log-in-circle'></i><h2>Welcome Back</h2><p>Login to continue your reading journey.</p></div>
                    <div class="input-auth"><i class='bx bx-envelope'></i><input type="email" name="email" placeholder="Email" required></div>
                    <div class="input-auth"><i class='bx bx-lock-alt'></i><input type="password" name="password" placeholder="Password" required></div>
                    <button type="submit" class="auth-btn">Login</button>
                    <p class="switch-form">Don’t have an account? <a href="#" id="showSignup">Sign Up</a></p>
                </form>
                <form id="signupForm" method="POST" action="index.php?page=register" class="auth-form">
                    <div class="form-header"><i class='bx bxs-user-plus'></i><h2>Create Account</h2><p>Join our community of book lovers.</p></div>
                    <div class="input-auth"><i class='bx bx-user'></i><input type="text" name="username" placeholder="Username" required></div>
                    <div class="input-auth"><i class='bx bx-envelope'></i><input type="email" name="email" placeholder="Email" required></div>
                    <div class="input-auth"><i class='bx bx-lock-alt'></i><input type="password" name="password" placeholder="Password" required></div>
                    <button type="submit" class="auth-btn">Sign Up</button>
                    <p class="switch-form">Already have an account? <a href="#" id="showLogin">Login</a></p>
                </form>
            </div>
        </div>
    </div>

    <header class="main-header">
        <div class="header-container">
            <a href="index.php?page=home" class="logo">SHELF talk</a>
            <nav class="navigation">
                <a href="index.php?page=home">Home</a>
                <a href="index.php?page=my-books">My Books</a>
<?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'author'): ?>
    <a href="index.php?page=author-dashboard">Author Panel</a>
<?php endif; ?>
                <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                    <a href="index.php?page=admin-dashboard">Admin Panel</a>
                <?php endif; ?>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="notification-area">
                        <a href="#" class="notification-bell" id="notificationBell">
                            <i class='bx bxs-bell'></i>
                            <span class="notification-count" id="notificationCount">0</span>
                        </a>
                        <div class="notification-dropdown" id="notificationDropdown"></div>
                    </div>
                    <a href="#" class="nav-user"><span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span><i class='bx bxs-user-circle'></i></a>
                    <a href="index.php?page=logout" class="btn-logout" title="Logout"><i class='bx bx-log-out'></i></a>
                <?php else: ?>
                    <a href="#" class="btn-login" id="loginBtn">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <div class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content"><h1>Discover Your Next Favorite Book</h1><p>Join a community of readers and share your thoughts.</p></div>
    </div>

    <main class="container">
        <h2 class="section-title">Recently Added Books</h2>
        <div class="book-grid">
            <?php if (!empty($books)): ?>
                <?php foreach ($books as $book): ?>
                    <div class="book-card">
                        <img src="uploads/covers/<?php echo htmlspecialchars($book['cover_image']); ?>" alt="Cover for <?php echo htmlspecialchars($book['title']); ?>">
                        <div class="book-card-content">
                            <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                            <p>by <?php echo htmlspecialchars($book['author_name']); ?></p>
                            <a href="index.php?page=book&id=<?php echo $book['id']; ?>" class="btn-primary">View Details</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No books have been added yet.</p>
            <?php endif; ?>
        </div>
    </main>

    <section class="genre-section">
        <div class="container">
            <h2 class="section-title">Explore by Genre</h2>
            <div class="genre-grid">
                <?php if (!empty($genres)): ?>
                    <?php foreach ($genres as $genre): ?>
                        <a href="#" class="genre-card"><i class='bx bxs-book-heart'></i><h3><?php echo htmlspecialchars($genre['name']); ?></h3></a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No genres available yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="container">
        <h2 class="section-title">Featured Authors</h2>
        <div class="author-grid">
            <?php if (!empty($authors)): ?>
                <?php foreach ($authors as $author): ?>
                    <div class="author-card">
                        <img src="uploads/profiles/<?php echo htmlspecialchars($author['profile_image']); ?>" alt="Photo of <?php echo htmlspecialchars($author['name']); ?>">
                        <h3><?php echo htmlspecialchars($author['name']); ?></h3>
                        <a href="#" class="btn-primary">View Profile</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <section class="review-section">
        <div class="container">
            <h2 class="section-title">Latest Community Reviews</h2>
            <div class="review-grid">
                <?php if (!empty($reviews)): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-card">
                            <div class="review-header">
                                <span class="review-book"><?php echo htmlspecialchars($review['book_title']); ?></span>
                                <span class="review-rating"><?php for($i = 0; $i < $review['rating']; $i++) echo "<i class='bx bxs-star'></i>"; ?></span>
                            </div>
                            <p class="review-text">"<?php echo htmlspecialchars($review['review_text']); ?>"</p>
                            <span class="review-author">- <?php echo htmlspecialchars($review['username']); ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <h2>Join Our Community</h2>
            <p>Sign up to review books, create your own reading lists, and connect with fellow book lovers.</p>
            <a href="#" class="btn-primary btn-cta" id="loginBtn">Get Started</a>
        </div>
    </section>

    <footer class="main-footer">
        <div class="footer-content">
            <h3>BookReview</h3>
            <p>Share your thoughts. Discover new reads.</p>
            <div class="social-links">
                <a href="#"><i class='bx bxl-facebook-square'></i></a>
                <a href="#"><i class='bx bxl-twitter'></i></a>
                <a href="#"><i class='bx bxl-instagram-alt'></i></a>
            </div>
        </div>
        <div class="footer-bottom"><p>&copy; <?php echo date('Y'); ?> BookReview. All Rights Reserved.</p></div>
    </footer>

    <script src="js/main.js?v=2"></script>
</body>
</html>