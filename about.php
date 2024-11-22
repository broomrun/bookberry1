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
        <link href="style/styles.css" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/>
</head>
<body>
        <?php include "layout/header.html"?>

        <div class="container">
            <div class="opening left">
                <div class="text" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
                    <h1>Welcome to BookBerry!</h1>
                    <a href="login.php" class="info-btn" style="font-size: 1.2em; padding: 10px 20px;">Get to Know us!</a>
                </div>
                <div class="image" data-aos="zoom-in" data-aos-duration="1500" data-aos-delay="100">
                    <img src="assets/abouts.png" alt="BookBerry Image">
                </div>
            </div>
        </div>
        
        <div class="container">
            <div class="opening right">
            <div class="text">
    <h1>Our Story Behind</h1>
    <h2 class="story-description">
        Bookberry was born from a simple idea: what if discovering a great book could be just as enjoyable as reading one? Founded by passionate readers, we realized that the journey through a book is even richer when shared. With countless books out there, it’s easy to feel overwhelmed—Bookberry is here to bring order and excitement to your reading journey.
    </h2>
</div>
<div class="image" data-aos="zoom-in" data-aos-duration="1500" data-aos-delay="100">
                    <img src="assets/story.png" alt="BookBerry Image">
                </div>
            </div>
        </div>
        
        <div class="container">
            <div class="opening left">
            <div class="text">
    <h1>Our Vision</h1>
    <h2 class="story-description">
    To inspire a community where readers of all kinds connect, share insights, and celebrate the joy of reading through meaningful discussions and recommendations.
    </h2>
</div>
<div class="image" data-aos="zoom-in" data-aos-duration="1500" data-aos-delay="100">
                    <img src="assets/vision.png" alt="BookBerry Image">
                </div>
            </div>
        </div>      
        
        <section class="services" id="services">
    <div class="content">
    <h1 style="font-weight: bold; text-align: center;">Our Mission</h1>
        <div class="boxes">
            <div class="box"data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
                <div class="topic" style="font-weight: bold;">Foster a space where readers can discover, review, and rate books from all genres.</div>
            </div>
            <div class="box"data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
                <div class="topic" style="font-weight: bold;">Encourage thoughtful exchanges between readers and authors through comments and recommendations.</div>
            </div>
            <div class="box"data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
                <div class="topic" style="font-weight: bold;">Empower readers to build personal digital libraries, tracking their progress and favorite reads along the way.</div>
            </div>
        </div>
    </div>
</section>

<div id="our-team" class="team-section">
    <h2 class="text-center mb-5">Our Team</h2>
    <div class="team-container">
        <div class="team-member">
            <img src="assets/salwaa.png" alt="Member Name" class="team-image">
            <h3 class="member-name">Salwa</h3>
            <p class="member-role">Member</p>
        </div>
        <div class="team-member">
            <img src="assets/chairunn.png" alt="Member Name" class="team-image">
            <h3 class="member-name">Chairun</h3>
            <p class="member-role">Member</p>
        </div>
        <div class="team-member">
            <img src="assets/alissyaa.png" alt="Member Name" class="team-image">
            <h3 class="member-name">Alissya</h3>
            <p class="member-role">Member</p>
        </div>
        <div class="team-member">
            <img src="assets/rimaa.png" alt="Member Name" class="team-image">
            <h3 class="member-name">Rima</h3>
            <p class="member-role">Member</p>
        </div>
    </div>
</div>


<?php include "layout/footer.html"?>

    <script src="js/script.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
   <script>
     AOS.init({offset:0});
     </script>
</body>
</html>
