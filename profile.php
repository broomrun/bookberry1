<?php
include 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookBerry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="style/styles.css" rel="stylesheet">
    <style>
        /* Profile Header */
        .profile-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin: 30px 0;
        }
        .profile-pic {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #ccc;
            margin-bottom: 15px;
        }
        .username {
            font-size: 24px;
            font-weight: 700;
            color: #1e2a5e;
        }
        .user-info a {
            color: #3498db;
            font-size: 14px;
            text-decoration: none;
        }
        /* Statistics Section */
        .stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            width: 100%;
            max-width: 300px;
            margin-top: 20px;
        }
        .stat-item {
            background-color: #1e2a5e;
            color: #fff;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            font-size: 14px;
        }
        .stat-item-light {
            background-color: #ded3c2;
            color: #333;
        }
        /* Bookshelf Section */
        .bookshelf {
          background-color: #fff;
          padding: 20px;
          border-radius: 10px;
          margin: 20px auto; /* Center horizontally */
          width: 80%;
          max-width: 800px;
          box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
          text-align: center; /* Centers the content inside */
        }
        .bookshelf-title {
            font-size: 18px;
            font-weight: bold;
            color: #1e2a5e;
            margin-bottom: 15px;
            text-align: center;
        }
        .book-list {
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        .book {
            width: 90px;
            height: 130px;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .book img {
            width: 100%;
            height: auto;
        }
        .book:hover {
            transform: scale(1.05);
        }
        /* Responsive */
        @media (max-width: 768px) {
            .stats {
                grid-template-columns: 1fr 1fr;
            }
            .bookshelf {
                width: 90%;
            }
        }
        
footer {
    display: flex;
    justify-content: space-around; /* Memberi jarak antar kolom */
    align-items: flex-start;
    width: 100%;
    padding: 80px 10%; /* Mengurangi padding agar lebih lebar */
    background-color: #1e2a5e;
    flex-wrap: wrap;
    margin-top: 100px;
    z-index: 10;
}

.footer-content {
    flex: 1 1 220px; /* Menambah minimal lebar kolom */
    margin: 0 1rem;
    max-width: 300px; /* Menghindari kolom terlalu lebar */
}


.footer-content h4 {
    color: #fff;
    margin-bottom: 1.5rem;
    font-size: 20px;
}

.footer-content li {
    margin-bottom: 16px;
    list-style: none;
}

.footer-content li a {
    display: block;
    color: #d6d6d6;
    font-size: 15px;
    font-weight: 400;
    transition: all 0.4s ease;
}

.footer-content li a:hover {
    transform: translateY(-3px) translateX(-5px);
    color: #fff;
}

.footer-content p {
    color: #d6d6d6;
    font-size: 16px;
    line-height: 30px;
    margin: 20px 0;
}

.icons a {
    display: inline-block;
    font-size: 22px;
    color: #d6d6d6;
    transition: all 0.4s ease;
    margin-right: 15px;
}

.icons a:hover {
    color: #fff;
    transform: translateY(-5px);
}

.custom-small-text {
    font-size: 1rem; /* Sesuaikan ukuran sesuai kebutuhan */
}

.opening {
    display: flex;
    align-items: center;
    justify-content: space-between; /* Menjaga jarak antara teks dan gambar */
}

.text {
    flex: 1; 
    padding: 20px;
}

.image {
    flex: 1; /
    text-align: center; 
}

.image img {
    max-width: 100%; 
    height: auto;
    border-radius: 10px; 
}

.left {
    flex-direction: row; 
}

.right {
    flex-direction: row-reverse; 
}

.opening h1{
    color: #1e2a5e;
    font-size: 3rem;
    font-weight: bold;
}

.info-btn {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #1e2a5e; 
    color: white;
    text-decoration: none;
    border-radius: 50px;
    font-weight: bold;
    text-align: center;
    align-items: center;
}

.info-btn:hover {
    background-color: #FFF; 
    color: #1e2a5e;
    border: 3px solid #1e2a5e;
}

.story-description {
    font-size: 17px; 
    line-height: 1.5; 
    display: flex;
}

.services .boxes {
    display: flex; 
    flex-wrap: wrap; 
    justify-content: space-between; 
    gap: 20px; 
    margin: 0 auto; 
    max-width: 1200px; 
    padding: 20px; 
}

/* Individual service box */
.services .box {
    flex: 1 1 calc(33% - 20px); 
    margin: 20px 0; 
    text-align: center; 
    border-radius: 12px; 
    padding: 30px 10px; 
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    background: #fff; 
    transition: all 0.4s ease; 
    cursor: default; 
    color: #1a2a5e;
}

/* Hover effect for boxes */
.services .box:hover {
    background: #1e2a5e; 
    color: #fff; 
}

/* Icon style */
.services .box .icon {
    height: 50px; 
    width: 50px; 
    background: #1e2a5e; 
    border-radius: 50%; 
    text-align: center; 
    line-height: 50px; 
    font-size: 18px;
    color: #fff; 
    margin: 0 auto 10px auto; 
    transition: all 0.4s ease; 
}

@media only screen and (max-width: 768px) {
    header {
        flex-direction: column;
        align-items: center;
    }

    .container-field h1 {
        font-size: 4 rem;
    }

    .button {
        margin-right: 0;
    }

    .text-top {
        margin-left: 0;
        text-align: center;
    }
}

@media only screen and (max-width: 480px) {
    header {
        padding: 20px 5%;
    }

    .text-center {
        font-size: 2rem;
    }

    .button {
        font-size: 0.8rem;
    }

    p {
        font-size: 0.8rem;
    }

    .search {
        width: 90%;
    }

    .img-container {
        margin-left: 0;
    }
}

    </style>
</head>
<body>

<!-- Main Header with Logo and Navigation -->
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

<!-- Profile Header -->
<section class="profile-header">
    <img src="assets/ava.jpg" alt="Profile Picture" class="profile-pic">
    <div class="user-info">
        <h1 class="username">amamiyaws</h1>
        <a href="update_profile.php">Edit profile</a>
    </div>
    <div class="stats">
        <div class="stat-item">
            <strong>550</strong> friends gw
        </div>
        <div class="stat-item stat-item-light">
            <strong>40</strong> streaks akuuu
        </div>
        <div class="stat-item">
            <strong>3</strong> badges
        </div>
        <div class="stat-item stat-item-light">
            <strong>70</strong> books
        </div>
    </div>
</section>

<!-- Bookshelf Section -->
<main class="bookshelf">
    <div class="bookshelf-title">amamiyaw’s top read</div>
    <div class="book-list">
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
    </div>
</main>

  <script src="js/script.js"></script>
</body>
</html>
