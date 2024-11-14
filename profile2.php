<?php
session_start();
include "config.php";

$profile_image = 'default.jpg';
$top_reads = []; // Inisialisasi array untuk top reads

if (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];

    // Fetch the profile picture path from the database
    $query = "SELECT image FROM user_form WHERE name = '$user_name'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $profile_image = $row['image'] ? 'uploaded_img/' . $row['image'] : 'default.jpg'; // Use a default if no image
    }

    // Fetch top reads from the database
    $queryTopReads = "SELECT book_title, book_image FROM top_reads WHERE user_name = '$user_name' LIMIT 4";
    $resultTopReads = mysqli_query($conn, $queryTopReads);

    if ($resultTopReads && mysqli_num_rows($resultTopReads) > 0) {
        while ($row = mysqli_fetch_assoc($resultTopReads)) {
            $top_reads[] = $row; // Menyimpan hasil query ke array top_reads
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile UI</title>
    <style>
        /* CSS Styles */
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
        .badge-container {
            display: flex;
            gap: 15px;
            padding: 20px;
        }
        .badge-container img {
            width: 70px;
            height: 70px;
        }
        .stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
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
        }
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
                <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="Profile Picture">
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
        </div>

        <!-- Top Reads -->
        <div class="top-read">
            <div class="section-title"><?php echo $_SESSION['user_name']; ?>'s top reads</div>
            <div class="bookshelf">
                <?php
                if (!empty($top_reads)) {
                    foreach ($top_reads as $book) {
                        echo '<div class="book-item">';
                        echo '<img src="' . htmlspecialchars($book['book_image']) . '" alt="Book Cover">';
                        echo '<p>' . htmlspecialchars($book['book_title']) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No top reads available.</p>';
                }
                ?>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; 2023 Bookstery. All Rights Reserved.
        </div>
    </div>
</body>
</html>
