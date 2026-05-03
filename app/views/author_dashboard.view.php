<?php
$stats = $data['review_stats'];
$book_count = $data['book_count'];
$books_for_chart = $data['books_for_chart'];
$recent_reviews = $data['recent_reviews'];
$replies = $data['replies'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Author Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="admin-wrapper">
        <aside class="admin-sidebar author-sidebar-restyle">
            <div class="sidebar-header"><h3><i class="fas fa-feather-alt"></i> Author Panel</h3></div>
            <ul class="sidebar-menu">
                <li><a href="index.php?page=author-dashboard" class="active"><i class="fas fa-chart-line"></i> <span>Dashboard</span></a></li>
                <li><a href="index.php?page=author-my-books"><i class="fas fa-book-open"></i> <span>My Books</span></a></li>
                <li><a href="index.php?page=author-edit-profile"><i class="fas fa-user-edit"></i> <span>Edit Profile</span></a></li>
                <li class="sidebar-separator"></li>
                <li><a href="index.php?page=home"><i class="fas fa-eye"></i> <span>View Site</span></a></li>
                <li><a href="index.php?page=logout"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
            </ul>
        </aside>
        <main class="admin-main-content">
            <header class="admin-main-header">
                <h1 class="admin-page-title">Dashboard</h1>
                <div class="user-info">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></div>
            </header>
            <section class="admin-stats-grid">
                <div class="stat-card"><div class="stat-content"><p class="stat-label">My Books on Site</p><p class="stat-value"><?php echo $book_count; ?></p></div></div>
                <div class="stat-card"><div class="stat-content"><p class="stat-label">Total Reviews</p><p class="stat-value"><?php echo $stats['total_reviews'] ?? 0; ?></p></div></div>
                <div class="stat-card"><div class="stat-content"><p class="stat-label">Average Rating</p><p class="stat-value"><?php echo round($stats['avg_rating'] ?? 0, 2); ?> <i class="fas fa-star"></i></p></div></div>
            </section>
            <section class="admin-content-section">
                <h2 class="section-heading">Reviews Per Book</h2>
                <div class="chart-container"><canvas id="reviewsChart"></canvas></div>
            </section>

            <section class="admin-content-section">
                <h2 class="section-heading">Recent Reviews on Your Books</h2>
                <div class="author-reviews-list">
                    <?php if (empty($recent_reviews)): ?>
                        <p>No new reviews on your books yet.</p>
                    <?php else: ?>
                        <?php foreach($recent_reviews as $review): ?>
                            <div class="author-review-card">
                                <p class="review-text">"<?php echo htmlspecialchars($review['review_text']); ?>"</p>
                                <div class="review-meta">
                                    <span class="review-book">on <strong><?php echo htmlspecialchars($review['book_title']); ?></strong></span>
                                    <span class="review-author">by <?php echo htmlspecialchars($review['username']); ?></span>
                                </div>
                                <div class="author-reply-section">
                                    <?php if (isset($replies[$review['id']])): ?>
                                        <div class="author-reply-display">
                                            <strong>Your Reply:</strong>
                                            <p><?php echo htmlspecialchars($replies[$review['id']]['reply_text']); ?></p>
                                        </div>
                                    <?php else: ?>
                                        <form action="index.php?page=author-add-reply" method="POST" class="author-reply-form">
                                            <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                                            <textarea name="reply_text" placeholder="Write a public reply..." rows="2" required></textarea>
                                            <button type="submit" class="btn-primary"><i class="fas fa-reply"></i> Reply</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>

        </main>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('reviewsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?php foreach($books_for_chart as $book) { echo "'" . addslashes($book['title']) . "',"; } ?>],
            datasets: [{
                label: 'Number of Reviews',
                data: [<?php foreach($books_for_chart as $book) { echo $book['review_count'] . ","; } ?>],
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: { scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
    });
});
</script>
</body>
</html>