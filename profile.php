<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookBerry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/s_profile.css">
</head>
<body>

<header>
    <h2>
    <a href="user_page.php" class="logo">
        <img src="assets/logo.png" alt="Logo" class="logo-image" />
    </a>
</h2>
    <nav class="navigation">
        <a href="home.php">Home</a>
        <a href="about.php">About</a>
        <a href="profile.php">Profile</a>
    </nav>
</header>

    <!-- Header Section with Background Image -->
    <section>
        <div class="header-bg">
            <!-- Background image container -->
        </div>
        <div class="profile-header">
            <img src="assets/ava.jpg" alt="Profile Picture" class="profile-pic">
            <div class="user-info">
                <h1 class="username">amamiyaws</h1>
                <a href="update_profile.php"> Edit Profile</a> 
                <div class="stats">
                    <span><strong>550</strong> friends</span>
                    <span><strong>40</strong> books</span>
                    <span><strong>3</strong> badges</span>
                    <span><strong>70</strong> streaks</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main>
        <!-- Bookshelf Section -->
        <section class="bookshelf">
            <div class="book">
                <img src="assets/fav1.jpg" alt="Book Cover">
            </div>
            <div class="book">
                <img src="assets/fav23.jpg" alt="Book Cover">
            </div>
            <div class="book">
                <img src="assets/fav3.jpg" alt="Book Cover">
            </div>
            <div class="book">
                <img src="assets/fav4.jpg" alt="Book Cover">
            </div>
        </section>

        <a href="logout.php">Log out</a>
    </main>
</body>
</html>
