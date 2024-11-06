<?php
include 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Page</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
  <link href="style/styles.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      display: flex;
      justify-content: center;
      background-color: #fff;
      margin: 0;
      padding: 20px;
      padding-top: 80px; /* Menambahkan padding-top agar konten tidak tertutup oleh header */
    }
    .container {
      width: 80%;
      max-width: 800px;
      margin-top: 50px; /* Memberikan ruang ekstra di bagian atas konten */
    }
    .header {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }
    .profile-pic {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background-color: #ccc;
      margin-right: 20px;
    }
    .username {
      font-size: 24px;
      font-weight: 600;
      color: #2c3e50;
    }
    .edit-profile {
      font-size: 12px;
      color: #3498db;
      cursor: pointer;
      margin-top: 5px;
    }
    .statistics {
      margin: 20px 0;
    }
    .stats-title {
      font-size: 18px;
      font-weight: 600;
      color: #2c3e50;
      margin-bottom: 10px;
    }
    .stats-grid {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
    }
    .stat-box {
      flex: 1 1 45%;
      background-color: #2c3e50;
      color: #fff;
      border-radius: 10px;
      padding: 15px;
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      font-size: 16px;
    }
    .stat-box.light {
      background-color: #d1c4e9;
      color: #2c3e50;
    }
    .bookshelf {
      margin-top: 20px;
      padding: 15px;
      border: 1px solid #ccc;
      border-radius: 10px;
    }
    .bookshelf-title {
      font-size: 18px;
      font-weight: 600;
      color: #2c3e50;
      margin-bottom: 10px;
    }
    .book-list {
      display: flex;
      gap: 15px;
      overflow-x: auto;
    }
    .book {
      width: 80px;
      height: 120px;
      border-radius: 10px;
      background-color: #e0e0e0;
    }
  </style>
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

  <div class="container">
    <div class="header">
      <div class="profile-pic"></div>
      <div>
        <div class="username">amamiyaws</div>
        <a href="update_profile.php">Edit profile</a>
      </div>
    </div>
    
    <div class="statistics">
      <div class="stats-title">statistics</div>
      <div class="stats-grid">
        <div class="stat-box">
          <div>🔥</div>
          <div>70</div>
          <div>day streaks</div>
        </div>
        <div class="stat-box light">
          <div>📚</div>
          <div>3</div>
          <div>shelves</div>
        </div>
        <div class="stat-box">
          <div>🏅</div>
          <div>70</div>
          <div>badges</div>
        </div>
        <div class="stat-box light">
          <div>📖</div>
          <div>40</div>
          <div>shelves</div>
        </div>
      </div>
    </div>
    
    <div class="bookshelf">
      <div class="bookshelf-title">amamiyaw’s top read</div>
      <div class="book-list">
        <div class="book"></div>
        <div class="book"></div>
        <div class="book"></div>
        <div class="book"></div>
        <div class="book"></div>
      </div>
    </div>
  </div>
  <script src="js/script.js"></script>
</body>
</html>
