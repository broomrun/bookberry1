<?php
session_start();
include "config.php";

$profile_image = 'default.jpg';

if (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];

    // Fetch the profile picture path from the database
    $query = "SELECT image FROM user_form WHERE name = '$user_name'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $image_path = $row['image'] ? 'uploaded_profile_images/' . $row['image'] : 'default.jpg';
        $profile_image = $image_path . '?t=' . time(); // Add a unique parameter to force refresh
    } else {
        echo "User not found.";
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
    <style>
        /* General Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            padding: 20px;
        }
        .container {
            width: 900px;
            padding: 30px;
            border-radius: 10px;
        }

        /* Header Section */
        .profile-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .profile-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .profile-info img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 2px solid #ddd;
        }
        .profile-name {
            font-size: 24px;
            font-weight: bold;
        }
        .edit-profile-btn {
            font-size: 12px;
            color: #555;
            border: none;
            background-color: transparent;
            cursor: pointer;
            text-decoration: underline;
        }
        
        /* Badge Container */
        .badge-container {
            display: flex;
            align-items: center;
            background-color: #f7f5f2;
            padding: 20px; /* Increased padding */
            border-radius: 15px; /* Slightly rounded corners */
            gap: 15px; /* Added spacing between badges */
        }
        .badge-container img {
            width: 70px; /* Increased image size */
            height: 70px; /* Increased image size */
        }


        /* Statistics Section */
        .stats {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Two items per row */
            gap: 20px;
            margin-top: 20px;
        }
        .stat-item {
            background-color: #E1D7B7;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .stat-item h3 {
            font-size: 24px;
            margin-bottom: 5px;
            color: #333;
        }
        .stat-item p {
            font-size: 14px;
            color: #666;
        }

        /* Top Reads Section */
        .top-read {
            margin-top: 20px;
        }
        .section-title {
            font-size: 20px;
            font-weight: bold;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        .bookshelf {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 10px;
        }
        .book-item {
            text-align: center;
            background-color: #f8f9fb;
            padding: 10px;
            border-radius: 10px;
            width: 120px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .book-item img {
            width: 100%;
            border-radius: 5px;
        }
        .book-item p {
            margin-top: 5px;
            font-size: 12px;
            color: #333;
            text-align: center;
        }

        /* Shelves Section */
        .shelves {
            margin-top: 30px;
        }
        .shelves-container {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }
        .shelf {
            flex: 1;
            background-color: #1f3359;
            color: white;
            padding: 15px;
            border-radius: 10px;
            text-align: left;
            position: relative;
        }
        .shelf img {
            width: 70px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .shelf h4 {
            margin: 0;
            font-size: 16px;
            color: #ddd;
        }
        .shelf p {
            margin: 5px 0;
            font-size: 12px;
            color: #bbb;
        }
        .shelf-stats {
            font-size: 12px;
            color: #aaa;
            margin-top: 10px;
        }

        /* Footer */
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 40px;
        }
    </style>
</head>
<body>
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
                <h3>70</h3>
                <p>day streaks</p>
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

        <!-- Footer -->
        <div class="footer">
            &copy; 2023 Bookstery. All Rights Reserved.
        </div>
    </div>
</body>
</html>
