<?php
session_start();
include "config.php";

// Variabel default
$profile_image = 'default.jpg';
$streak_count = 0;
$total_comments = 0;
$total_books_read = 0;
$badges = []; // Array untuk menyimpan badges yang sudah diperoleh

if (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];
    $current_date = date("Y-m-d");

    // **1. Query untuk mendapatkan gambar profil**
    $image_query = "SELECT image FROM user_form WHERE name = '$user_name'";
    $image_result = mysqli_query($conn, $image_query);

    if ($image_result && mysqli_num_rows($image_result) > 0) {
        $row = mysqli_fetch_assoc($image_result);
        $image_path = $row['image'] ? 'uploaded_profile_images/' . $row['image'] : 'default.jpg';
        $profile_image = $image_path . '?t=' . time(); // Tambahkan parameter unik untuk memaksa refresh
    }

    // **2. Query untuk mendapatkan last_login, streak_count, dan badges**
    $streak_query = "SELECT last_login, streak_count, badges FROM user_form WHERE name = '$user_name'";
    $streak_result = mysqli_query($conn, $streak_query);

    if ($streak_result && mysqli_num_rows($streak_result) > 0) {
        $user_data = mysqli_fetch_assoc($streak_result);

        $last_login = $user_data['last_login'];
        $streak_count = $user_data['streak_count'];
        $badges = $user_data['badges'] ? explode(',', $user_data['badges']) : []; // Ambil badges sebagai array

        // Cek apakah pengguna login hari ini atau melewatkan hari
        $last_login_date = date('Y-m-d', strtotime($last_login));
        if ($last_login_date != $current_date) {
            if (date('Y-m-d', strtotime($last_login . ' +1 day')) == $current_date) {
                $streak_count++; // Tambahkan streak
            } else {
                $streak_count = 1; // Reset streak
            }

            // Update last_login dan streak_count
            $update_query = "UPDATE user_form SET last_login = '$current_date', streak_count = '$streak_count' WHERE name = '$user_name'";
            mysqli_query($conn, $update_query);
        }
    }

    // **3. Query untuk mendapatkan total review**
    $comment_query = "SELECT COUNT(*) AS total_comments FROM comments WHERE username = '$user_name'";
    $comment_result = mysqli_query($conn, $comment_query);
    if ($comment_result && mysqli_num_rows($comment_result) > 0) {
        $comment_data = mysqli_fetch_assoc($comment_result);
        $total_comments = intval($comment_data['total_comments']);
    }

    // **4. Query untuk mendapatkan total buku yang dibaca**
    $book_query = "SELECT COUNT(*) AS total_books FROM books_read WHERE username = '$user_name'";
    $book_result = mysqli_query($conn, $book_query);
    if ($book_result && mysqli_num_rows($book_result) > 0) {
        $book_data = mysqli_fetch_assoc($book_result);
        $total_books_read = intval($book_data['total_books']);
    }

    // **5. Logika pemberian badge**
    $updated_badges = [];

    // Badge 1: streak > 15
    if ($streak_count >= 10) {
        $updated_badges[] = 'badge01';
    }

    // Badge 2: lebih dari 5 buku dibaca
    if ($total_books_read > 5) {
        $updated_badges[] = 'badge2';
    }

    // Badge 3: 5 review
    if ($total_comments >= 15) {
        $updated_badges[] = 'badge3';
    }

    // **6. Simpan data badges kembali ke database**
    $badges_string = implode(',', $updated_badges); // Gabungkan badge menjadi string
    $update_badges_query = "UPDATE user_form SET badges = '$badges_string' WHERE name = '$user_name'";
    if (!mysqli_query($conn, $update_badges_query)) {
        die('Update badges query failed: ' . mysqli_error($conn));
    }

    // Perbarui variabel $badges
    $badges = $updated_badges;
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

    .profile-btn {
        display: inline-block;
        padding: 5px 10px;
        background-color: #1e2a5e;
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: medium;
        text-align: center;
        align-items: center;
        font-size: small;
    }

    .profile-btn:hover {
        background-color: #fff; 
        color: #1e2a5e;
        border: 3px solid #1e2a5e;
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
                    <a href="update_profile.php" class="profile-btn">edit profile</a>
                </div>
            </div>
            <div class="badge-container">
                <?php foreach ($badges as $badge) { ?>
                    <img src="assets/<?php echo htmlspecialchars($badge); ?>.png" alt="<?php echo htmlspecialchars($badge); ?>" width="100" height="100">
                <?php } ?>
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
            <h3><?php echo htmlspecialchars(count($badges)); ?></h3>
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
        <a href="logout.php" class="info-btn">Log out</a>
    </div>

    <?php include "layout/footer.html" ?>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>

</body>

</html>