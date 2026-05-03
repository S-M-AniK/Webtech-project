<?php
// Extract data for easy use
$book = $data['book'];
$reviews = $data['reviews'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($book['title']); ?> - BookReview</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
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

    <main class="container">
        <div class="book-details-layout">
            <div class="book-cover">
                <img src="uploads/covers/<?php echo htmlspecialchars($book['cover_image']); ?>" alt="Cover for <?php echo htmlspecialchars($book['title']); ?>">
            </div>
            <div class="book-info">
                <h1><?php echo htmlspecialchars($book['title']); ?></h1>
                <p class="book-author">by <a href="#"><?php echo htmlspecialchars($book['author_name']); ?></a></p>
                <div class="book-meta">
                    <span class="book-genre"><?php echo htmlspecialchars($book['genre_name']); ?></span>
                    <span class="book-date">Published on <?php echo date('M j, Y', strtotime($book['publication_date'])); ?></span>
                </div>
                <h3>Synopsis</h3>
                <p class="book-synopsis"><?php echo nl2br(htmlspecialchars($book['synopsis'])); ?></p>

                <?php if(isset($_SESSION['user_id'])): ?>
                    <?php if($data['is_in_list']): ?>
                        <a href="index.php?page=my-books" class="btn-secondary">View in My Books</a>
                    <?php else: ?>
                        <a href="index.php?page=add-to-list&id=<?php echo $book['id']; ?>" class="btn-primary">Add to My Books</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="reviews-section">
            <h2 class="section-title">Community Reviews</h2>

            <?php if(isset($_SESSION['user_id'])): ?>
            <div class="review-form-container">
                <h3>Write Your Own Review</h3>
                <form action="index.php?page=add-review" method="POST" class="review-form">
                    <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                    <div class="star-rating">
                        <input type="radio" name="rating" id="rate-5" value="5"><label for="rate-5" class="bx bxs-star"></label>
                        <input type="radio" name="rating" id="rate-4" value="4"><label for="rate-4" class="bx bxs-star"></label>
                        <input type="radio" name="rating" id="rate-3" value="3"><label for="rate-3" class="bx bxs-star"></label>
                        <input type="radio" name="rating" id="rate-2" value="2"><label for="rate-2" class="bx bxs-star"></label>
                        <input type="radio" name="rating" id="rate-1" value="1"><label for="rate-1" class="bx bxs-star"></label>
                    </div>
                    <textarea name="review_text" rows="5" placeholder="Share your thoughts..." required></textarea>
                    <button type="submit" class="btn-primary">Submit Review</button>
                </form>
            </div>
            <?php else: ?>
            <p class="login-prompt">Please <a href="#" class="login-link">Login</a> to write a review.</p>
            <?php endif; ?>

            <div class="reviews-list">
                <?php if(!empty($reviews)): ?>
                    <?php foreach($reviews as $review): ?>
                    <div class="review-card">
                        <div class="review-header">
                            <span class="review-author"><?php echo htmlspecialchars($review['username']); ?></span>
                            <span class="review-rating">
                                <?php for($i = 0; $i < $review['rating']; $i++) echo "<i class='bx bxs-star'></i>"; ?>
                            </span>
                        </div>
                        <p class="review-text">"<?php echo htmlspecialchars($review['review_text']); ?>"</p>
                        
                        <?php if(isset($data['replies'][$review['id']])): ?>
                        <div class="author-reply-display">
                            <strong><i class="fas fa-feather-alt"></i> Reply from the Author:</strong>
                            <p><?php echo htmlspecialchars($data['replies'][$review['id']]['reply_text']); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No reviews yet. Be the first to write one!</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

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
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> BookReview. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="js/main.js?v=2"></script>
</body>
</html>