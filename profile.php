<?php
session_start();
include "config.php";

$profile_image = 'default.jpg';
$streak_count = 0;
$total_comments = 0;
$total_replies = 0;

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

        // Check if the user logged in today or missed a day
        $last_login_date = date('Y-m-d', strtotime($last_login));
        if ($last_login_date == $current_date) {
            // If the user logged in today, just continue
            $streak_count = $streak_count; // No change
        } else {
            // If they didn't log in today, reset streak or increase streak
            if (date('Y-m-d', strtotime($last_login . ' +1 day')) == $current_date) {
                // If last login was yesterday, continue streak
                $streak_count++;
            } else {
                // If skipped a day, reset streak
                $streak_count = 1; // Start new streak
            }
        }

        // Update last_login and streak_count in database
        $update_query = "UPDATE user_form SET last_login = '$current_date', streak_count = '$streak_count' WHERE name = '$user_name'";
        if (!mysqli_query($conn, $update_query)) {
            die('Update query failed: ' . mysqli_error($conn));
        }
    } else {
        echo "Streak query failed or user data not found: " . mysqli_error($conn);
    }

    // Query to get total comments (main comments) and replies
    $comment_query = "SELECT COUNT(*) AS total_comments FROM comments WHERE username = '$user_name' AND parent_id IS NULL";
    $reply_query = "SELECT COUNT(*) AS total_replies FROM comments WHERE username = '$user_name' AND parent_id IS NOT NULL";

    // Get total comments
    $comment_result = mysqli_query($conn, $comment_query);
    if ($comment_result && mysqli_num_rows($comment_result) > 0) {
        $comment_data = mysqli_fetch_assoc($comment_result);
        $total_comments = $comment_data['total_comments'];
    }

    // Get total replies
    $reply_result = mysqli_query($conn, $reply_query);
    if ($reply_result && mysqli_num_rows($reply_result) > 0) {
        $reply_data = mysqli_fetch_assoc($reply_result);
        $total_replies = $reply_data['total_replies'];
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

        <div class="stats">
    <div class="stat-item">
        <h3><?php echo htmlspecialchars($streak_count); ?></h3>
        <p>streak</p>
    </div>
    <div class="stat-item">
        <h3><?php echo htmlspecialchars($total_comments); ?></h3> <!-- Display total comments -->
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
    <div class="stat-item">
        <h3><?php echo htmlspecialchars($total_replies); ?></h3> <!-- Display total replies -->
        <p>replies</p>
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
        
    <?php include "layout/footer.html"?>
    
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/script.js"></script>

</body>
</html>