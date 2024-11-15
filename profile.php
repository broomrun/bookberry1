<?php
session_start();
include "config.php";

$profile_image = 'default.jpg';
$streak_count = 0;

if (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];
    $current_date = date("Y-m-d");

    // Query to get profile image
    $image_query = "SELECT image FROM user_form WHERE name = '$user_name'";
    $image_result = mysqli_query($conn, $image_query);

    if ($image_result && mysqli_num_rows($image_result) > 0) {
        $row = mysqli_fetch_assoc($image_result);
        $image_path = $row['image'] ? 'uploaded_profile_images/' . $row['image'] : 'default.jpg';
        $profile_image = $image_path . '?t=' . time(); // Add unique parameter to force refresh
    } else {
        echo "User not found or query failed: " . mysqli_error($conn);
    }

    // Query to get last_login and streak_count
    $streak_query = "SELECT last_login, streak_count FROM user_form WHERE name = '$user_name'";
    $streak_result = mysqli_query($conn, $streak_query);

    if ($streak_result && mysqli_num_rows($streak_result) > 0) {
        $user_data = mysqli_fetch_assoc($streak_result);

        $last_login = $user_data['last_login'];
        $streak_count = $user_data['streak_count'];

        // Check if the user logged in consecutively
        if (date('Y-m-d', strtotime($last_login . ' +1 day')) == $current_date) {
            $streak_count++; // Increase streak if consecutive login
        } else {
            $streak_count = 1; // Reset streak if not consecutive
        }

        // Update last_login and streak_count in database
        $update_query = "UPDATE user_form SET last_login = '$current_date', streak_count = '$streak_count' WHERE name = '$user_name'";
        if (!mysqli_query($conn, $update_query)) {
            die('Update query failed: ' . mysqli_error($conn));
        }
    } else {
        echo "Streak query failed or user data not found: " . mysqli_error($conn);
    }
} else {
    echo "You are not logged in!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile UI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet"> <!-- Link Poppins -->
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
    <?php include "layout/header.html"?>
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

        <!-- Top Reads -->
        <div class="top-read">
            <div class="section-title"><?php echo $_SESSION['user_name']; ?>'s top read</div>
            <div class="bookshelf">
                <div class="book-item">
                    <img src="assets/fav1.jpg" alt="Book Cover">
                    <p>Di Tanah Lada</p>
                </div>
                <div class="book-item">
                    <img src="assets/fav23.jpg" alt="Book Cover">
                    <p>The Riddle of the Sea</p>
                </div>
                <div class="book-item">
                    <img src="assets/fav3.jpg" alt="Book Cover">
                    <p>The Princess in Black</p>
                </div>
                <div class="book-item">
                    <img src="assets/fav4.jpg" alt="Book Cover">
                    <p>Waves</p>
                </div>
            </div>
        </div>

        <!-- Shelves -->
        <div class="shelves">
            <div class="section-title"><?php echo $_SESSION['user_name']; ?>'s shelves</div>
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

</body>
</html>
