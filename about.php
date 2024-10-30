<?php

include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BookBerry</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet"> <!-- Link Poppins -->
        <link href="stylea.css" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/>
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/>
</head>
<body>
    <header>
        <a href="#" class="logo"><img src="assets/logo.png" alt="logo image"></a>
        <nav class="navigation">
          <a href="home.php">Home</a>
          <a href="about.php">About</a>
          <a href="update_profile.php">Profile</a>
        </nav>
      </header>
    <main>

        <div class="container">
            <div class="opening left">
                <div class="text" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
                    <h1>Welcome to BookBerry!</h1>
                    <h2>We are dedicated to celebrating and promoting local literature.<br>
                        <span>We believe that every book has a story to tell, and every author deserves recognition.</span>
                    </h2>
                </div>
                <div class="image" data-aos="zoom-in" data-aos-duration="1500" data-aos-delay="100">
                    <img src="assets/13.jpg" alt="BookBerry Image">
                </div>
            </div>
        </div>
        
        <div class="container">
            <div class="opening right">
                <div class="text">
                    <h1>Our Mission</h1>
                    <h2>At Bookberry, our mission is to bridge the gap between readers and local writers,<br>
                        <span>providing a space to discover, discuss, and celebrate the literary works that emerge from our rich cultural landscape.</span>
                    </h2>
                </div>
                <div class="image">
                    <img src="assets/13.jpg" alt="BookBerry Image">
                </div>
            </div>
        </div>
        
        <div class="container">
            <div class="opening left">
                <div class="text">
                    <h1>Our Vision</h1>
                    <h2>We aim to foster a reading culture in our community, making books an integral part of everyday life.</h2>
                </div>
                <div class="image">
                    <img src="assets/13.jpg" alt="BookBerry Image">
                </div>
            </div>
        </div>        
        

        <!-- <section class="about-section">
            <h2>Welcome to Bookberry!</h2>
            <p>We are dedicated to celebrating and promoting local literature. We believe that every book has a story to tell, and every author deserves recognition.</p>

            <h3>Our Mission</h3>
            <p>At Bookberry, our mission is to bridge the gap between readers and local writers, providing a space to discover, discuss, and celebrate the literary works that emerge from our rich cultural landscape.</p>

            <h3>Our Vision</h3>
            <p>We aim to foster a reading culture in our community, making books an integral part of everyday life.</p>

            <h3>Meet Our Team</h3>
            <p>We are a group of book lovers committed to supporting local authors and sharing our insights through in-depth reviews. Each member brings a unique perspective and passion for literature.</p>

            <h3>Join Us</h3>
            <p>We invite you to contribute! Share your reviews or recommend your favorite local books, and become part of the Bookberry community.</p>

            <h3>Contact Us</h3>
            <p>For more information or collaboration inquiries, feel free to reach out to us at <a href="mailto:email@example.com">email@example.com</a>.</p>
        </section> -->
    </main>
    <footer>
        <p>&copy; 2024 Bookberry. All rights reserved.</p>
    </footer>
    <script src="js/script.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
   <script>
     AOS.init({offset:0});
     </script>
</body>
</html>
