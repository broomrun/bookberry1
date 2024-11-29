<?php
session_start();
include "config.php";

$conn = mysqli_connect('localhost', 'root', '', 'bookberry');
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$profile_image = 'default.jpg';
$streak_count = 0;

if (isset($_SESSION['user_name'])) {
    $user_name = mysqli_real_escape_string($conn, $_SESSION['user_name']);
    $current_date = date("Y-m-d");

    // Query to get profile image
    $image_query = "SELECT image FROM user_form WHERE name = '$user_name'";
    $image_result = mysqli_query($conn, $image_query);

    if ($image_result && mysqli_num_rows($image_result) > 0) {
        $row = mysqli_fetch_assoc($image_result);
        $image_path = $row['image'] ? 'uploaded_profile_images/' . $row['image'] : 'default.jpg';
        $profile_image = $image_path . '?t=' . time(); // Force refresh
    }

    // Query to get last_login and streak_count
    $streak_query = "SELECT last_login, streak_count FROM user_form WHERE name = '$user_name'";
    $streak_result = mysqli_query($conn, $streak_query);

    if ($streak_result && mysqli_num_rows($streak_result) > 0) {
        $user_data = mysqli_fetch_assoc($streak_result);

        $last_login = $user_data['last_login'];
        $streak_count = $user_data['streak_count'];

        $last_login_date = date('Y-m-d', strtotime($last_login));
        if ($last_login_date == $current_date) {
            // Continue streak
        } else if (date('Y-m-d', strtotime($last_login . ' +1 day')) == $current_date) {
            $streak_count++;
        } else {
            $streak_count = 1;
        }

        // Update streak
        $update_query = "UPDATE user_form SET last_login = '$current_date', streak_count = '$streak_count' WHERE name = '$user_name'";
        mysqli_query($conn, $update_query);
    }
}

// Log book clicks
if (isset($_GET['book_id'])) {
    $book_id = mysqli_real_escape_string($conn, $_GET['book_id']);
    $user_name = mysqli_real_escape_string($conn, $_SESSION['user_name']);

    // Check if activity already logged
    $check_query = "SELECT * FROM book_activity WHERE user_name = '$user_name' AND book_id = '$book_id' AND activity_type = 'click'";
    $result = mysqli_query($conn, $check_query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Update activity count
        $update_query = "UPDATE book_activity SET activity_count = activity_count + 1 WHERE user_name = '$user_name' AND book_id = '$book_id' AND activity_type = 'click'";
        mysqli_query($conn, $update_query);
    } else {
        // Insert new record
        $insert_query = "INSERT INTO book_activity (user_name, book_id, activity_type, activity_count) VALUES ('$user_name', '$book_id', 'click', 1)";
        mysqli_query($conn, $insert_query);
    }
}

// Fetch top clicked books
$query_click = "
SELECT b.book_id, b.title, b.cover_image, SUM(ba.activity_count) AS total_activity
FROM books b
JOIN book_activity ba ON b.book_id = ba.book_id
WHERE ba.activity_type = 'click'
GROUP BY b.book_id
ORDER BY total_activity DESC
LIMIT 5;
";
$result_click = mysqli_query($conn, $query_click);
$top_reads = [];
if ($result_click && mysqli_num_rows($result_click) > 0) {
    while ($row = mysqli_fetch_assoc($result_click)) {
        $top_reads[] = $row;
    }
}

// Fetch top searched books
$query_search = "
SELECT b.book_id, b.title, b.cover_image, SUM(ba.activity_count) AS total_activity
FROM books b
JOIN book_activity ba ON b.book_id = ba.book_id
WHERE ba.activity_type = 'search'
GROUP BY b.book_id
ORDER BY total_activity DESC
LIMIT 5;
";
$result_search = mysqli_query($conn, $query_search);
$top_search = [];
if ($result_search && mysqli_num_rows($result_search) > 0) {
    while ($row = mysqli_fetch_assoc($result_search)) {
        $top_search[] = $row;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile UI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="style/styles.css" rel="stylesheet">
</head>
<style>
    body {
        justify-content: center;
    }
    .container {
        width: 900px;
        padding: 30px;
        border-radius: 10px;
    }
</style>
<body>
    <?php include "layout/header.html" ?>
    <div class="container">
        <!-- Header -->
        <div class="profile-header">
            <div class="profile-info">
                <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="Profile Picture" width="150" height="150">
                <div>
                    <div class="profile-name"><?php echo $_SESSION['user_name']; ?></div>
                    <button class="edit-profile-btn"><a href="update_profile.php">edit profile</a></button>
                </div>
            </div>
            <div class="badge-container">
                <img src="assets/badge.jpg" alt="Badge 1">
                <img src="assets/badge1.png" alt="Badge 2">
                <img src="assets/badge2.jpg" alt="Badge 3">
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats">
            <div class="stat-item">
                <h3><?php echo htmlspecialchars($streak_count); ?></h3>
                <p>streak</p>
            </div>
            <div class="stat-item">
                <h3>300</h3>
                <p>reviews</p>
            </div>
            <div class="stat-item">
                <h3>70</h3>
                <p>badges</p>
            </div>
            <div class="stat-item">
                <h3>40</h3>
                <p>shelves</p>
            </div>
        </div>

<!-- Top Reads (Clicked and Searched) -->
<div class="top-read">
    <div class="section-title"><?php echo htmlspecialchars($_SESSION['user_name']); ?>'s Top Read</div>
    <div class="bookshelf">
        <!-- Top Clicked Books -->
        <div class="section-subtitle">Top Clicked Books</div>
        <?php if (!empty($top_reads)): ?>
            <?php foreach ($top_reads as $top_read): ?>
                <div class="book">
                    <img src="<?php echo htmlspecialchars($top_read['cover_image']); ?>" alt="Cover Image" width="100" height="150">
                    <p class="book-title"><?php echo htmlspecialchars($top_read['title']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No clicked books available</p>
        <?php endif; ?>

        <!-- Top Searched Books -->
        <div class="section-subtitle">Top Searched Books</div>
        <?php if (!empty($top_search)): ?>
            <?php foreach ($top_search as $top_search_item): ?>
                <div class="book">
                    <img src="<?php echo htmlspecialchars($top_search_item['cover_image']); ?>" alt="Cover Image" width="100" height="150">
                    <p class="book-title"><?php echo htmlspecialchars($top_search_item['title']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No searched books available</p>
        <?php endif; ?>
    </div>
</div>


                <!-- Shelves -->
                <div class="shelves">
            <div class="section-title"><?php echo $_SESSION['user_name']; ?>'s Shelves</div>
            <div class="shelves-container">
                <div class="shelf">
                    <img src="assets/fav1.jpg" alt="Lost in the Never Woods">
                    <h4>me in another universe</h4>
                    <p>what i've been thinking at 3 a.m., and can't sleep so i would've turn into a wolf</p>
                    <div class="shelf-stats">77 likes • 60 books</div>
                </div>
                <div class="shelf">
                    <img src="assets/fav1.jpg" alt="Lost in the Never Woods">
                    <h4>me in another universe</h4>
                    <p>what i've been thinking at 3 a.m., and can't sleep so i would've turn into a wolf</p>
                    <div class="shelf-stats">77 likes • 60 books</div>
                </div>
            </div>
        </div>
        <a href="logout.php">Log out</a>
    </div>

        
    <footer class="footer">
    <div class="footer-content">
    <h2><a href="#" class="logo" style="font-weight: bold; color: white;">bOOkberry</a></h2>
        <p>halo </p>

        <div class="icons">
            <a href="#"><i class='bx bxl-facebook-circle'></i></a>
            <a href="#"><i class='bx bxl-twitter'></i></a>
            <a href="#"><i class='bx bxl-instagram-alt'></i></a>
            <a href="#"><i class='bx bxl-youtube'></i></a>
        </div>
    </div>

    <div class="footer-content">
        <h4>Reading Lists</h4>
        <li><a href="#">Genres</a></li>
        <li><a href="#">Book Categories</a></li>
        <li><a href="#">Top Reviews</a></li>
        <li><a href="#">Top Authors</a></li>
    </div>

    <div class="footer-content">
        <h4>About Us</h4>
        <li><a href="#">How we work</a></li>
        <li><a href="#">Book of the Month</a></li>
        <li><a href="#">Privacy & Security</a></li>
        <li><a href="#">Recommend Reads</a></li>
    </div>

    <div class="footer-content">
        <h4>Reading Challenges</h4>
        <li><a href="#">Join Us</a></li>
        <li><a href="#">Subscription</a></li>
        <li><a href="#">Borrow Books</a></li>
    </div>
</footer>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

</body>
</html>