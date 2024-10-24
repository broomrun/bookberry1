<?php

include 'config.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bookavy - The Little Prince</title>
  <link rel="stylesheet" href="stylex.css">
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <nav class="sidebar">
      <div class="profile">
        <img src="profile.png" alt="Profile">
        <p>Rhett Butler</p>
      </div>
      <ul>
        <li><a href="#">Account</a></li>
        <li><a href="#">Notifications</a></li>
        <li><a href="#">My Orders</a></li>
        <li><a href="#">Favorites</a></li>
        <li><a href="#">Settings</a></li>
      </ul>
      <div class="social-icons">
        <a href="#"><img src="instagram.png" alt="Instagram"></a>
        <a href="#"><img src="twitter.png" alt="Twitter"></a>
        <a href="#"><img src="youtube.png" alt="YouTube"></a>
      </div>
    </nav>

    <!-- Main Content -->
    <main>
      <header>
        <input type="text" placeholder="What do you want to read?">
        <nav>
          <a href="#">Shop</a>
          <a href="#">Blog</a>
          <a href="#">About Us</a>
          <a href="#">Basket</a>
        </nav>
      </header>

      <div class="book-info">
        <h1>The Little Prince</h1>
        <p>Antoine de Saint-Exupéry</p>
        <div class="tags">
          <span>philosophy</span>
          <span>fairytale</span>
          <span>from 0 to 100 y.o.</span>
        </div>
        <p class="description">
          The most famous work of Antoine de Saint-Exupéry with author's drawings. A wise fairy tale...
        </p>
        <div class="prices">
          <button>Paperback $10.99</button>
          <button>E-book $4.99</button>
        </div>
      </div>

      <!-- Book Cover -->
      <div class="book-cover">
        <img src="1.jpg" alt="The Little Prince">
      </div>

      <!-- You May Like -->
      <section class="you-may-like">
        <h2>You may like</h2>
        <div class="book-slider">
          <div class="book-item"><img src="book1.png" alt="Book 1"></div>
          <div class="book-item"><img src="book2.png" alt="Book 2"></div>
          <div class="book-item"><img src="book3.png" alt="Book 3"></div>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
