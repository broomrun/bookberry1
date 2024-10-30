<?php
include 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="gaya.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body>
    <section>
        <header>
        <h2>
    <a href="#" class="logo">
        <img src="assets/logowhite.png" alt="Logo" class="logo-image" />
    </a>
</h2>
                <nav class="navigation">
                 <a href="home.php">Home</a>
                <a href="about.php">About</a>
                <a href="update_profile.php">Profile</a>
                </nav>
        </header>
        <div class="content">
            <div class="info">
            <h2>Hi, <br><span>BERRYs!</span></h2> 
            <p>Your one-stop platform for discovering and rating your favorite books<br><span>Dive into the world of literature and share your thoughts with others!</span></p>
            <a href="login.php" class="info-btn">More Info</a>
        </div>
</div>
    </section>

        <h1> Discover many books! </h1>
        <div id="bookCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <!-- Slide pertama dengan 5 buku -->
                <div class="carousel-item active">
                    <div class="d-flex justify-content-center">
                        <div class="book-card">
                            <a href="login.php">
                            <img src="assets/10.jpeg" alt="Era Taylor Swift">
                            </a>
                            <div class="book-title">Era Taylor Swift</div>
                            <div class="author-name">Karolina Sulej</div>
                        </div>
                        <div class="book-card">
                            <img src="assets/5.jpeg" alt="Wonka">
                            <div class="book-title">Wonka</div>
                            <div class="author-name">Sibéal Pounder</div>
                        </div>
                        <div class="book-card">
                            <img src="assets/4.jpeg" alt="The Wind in the Willows">
                            <div class="book-title">The Wind in the Willows</div>
                            <div class="author-name">Kenneth Grahame</div>
                        </div>
                        <div class="book-card">
                            <img src="assets/7.jpeg" alt="Mary Poppins">
                            <div class="book-title">Mary Poppins</div>
                            <div class="author-name">P.L. Travers</div>
                        </div>
                        <div class="book-card">
                            <img src="assets/5.jpeg" alt="Harry Potter and the Philosopher's Stone">
                            <div class="book-title">Harry Potter</div>
                            <div class="author-name">J.K. Rowling</div>
                        </div>
                    </div>
                </div>
        
                <!-- Slide kedua dengan 5 buku -->
                <div class="carousel-item">
                    <div class="d-flex justify-content-center">
                        <div class="book-card">
                            <img src="assets/11.jpeg" alt="The Hobbit">
                            <div class="book-title">The Hobbit</div>
                            <div class="author-name">J.R.R. Tolkien</div>
                        </div>
                        <div class="book-card">
                            <img src="assets/6.jpeg" alt="Pride and Prejudice">
                            <div class="book-title">Pride and Prejudice</div>
                            <div class="author-name">Jane Austen</div>
                        </div>
                        <div class="book-card">
                            <img src="assets/7.jpeg" alt="The Great Gatsby">
                            <div class="book-title">The Great Gatsby</div>
                            <div class="author-name">F. Scott Fitzgerald</div>
                        </div>
                        <div class="book-card">
                            <img src="assets/8.jpeg" alt="Moby Dick">
                            <div class="book-title">Moby Dick</div>
                            <div class="author-name">Herman Melville</div>
                        </div>
                        <div class="book-card">
                            <img src="assets/9.jpeg" alt="War and Peace">
                            <div class="book-title">War and Peace</div>
                            <div class="author-name">Leo Tolstoy</div>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#bookCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bookCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>   
        
        <div class="container">
            <div class="opening right">
                <div class="text" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
                    <h1>Build your own library!</h1>
                    <h2>Create a personal library filled with your favorite books!<br>
                        <span>Make your reading journey truly yours.</span>
                    </h2>
                </div>
                <div class="image" data-aos="zoom-in" data-aos-duration="1500" data-aos-delay="100">
                    <img src="assets/libra.png" alt="BookBerry Image">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="opening left">
                <div class="text" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
                    <h1>Share reads, rate favorites!</h1>
                    <h2>Dive into new stories, express your thoughts,<br>
                        <span>and see how others feel about their favorite books. Your personal library awaits</span>
                    </h2>
                </div>
                <div class="image" data-aos="zoom-in" data-aos-duration="1500" data-aos-delay="100">
                    <img src="assets/rate.png" alt="BookBerry Image">
                </div>
            </div>
        </div>

        <div class="bawah">
    <div class="info" style="text-align: center; color: #1e2a5e; margin-top: -20px;">
    <h2 style="font-size: 2.5em; line-height: 1.2em; font-weight:bold;">Are you ready to, <br><span>Start your book journey?</span></h2>
        <a href="login.php" class="info-btn" style="font-size: 1.2em; padding: 10px 20px;">Start my journey!</a>
    </div>
</div>
    
<footer class="footer">
    <div class="footer-content">
        <img src="img/logo.png">
        <p>halo </p>

        <div class="icons">
            <a href="#"><i class='bx bxl-facebook-circle'></i></a>
            <a href="#"><i class='bx bxl-twitter'></i></a>
            <a href="#"><i class='bx bxl-instagram-alt'></i></a>
            <a href="#"><i class='bx bxl-youtube'></i></a>
        </div>
    </div>

    <div class="footer-content">
        <h4>Projects</h4>
        <li><a href="#">Houses</a></li>
        <li><a href="#">Rooms</a></li>
        <li><a href="#">Flats</a></li>
        <li><a href="#">Apartments</a></li>
    </div>

    <div class="footer-content">
        <h4>Company</h4>
        <li><a href="#">How we work</a></li>
        <li><a href="#">Capital</a></li>
        <li><a href="#">Security</a></li>
        <li><a href="#">Sellings</a></li>
    </div>

    <div class="footer-content">
        <h4>Movement</h4>
        <li><a href="#">Halo</a></li>
        <li><a href="#">Support Us</a></li>
        <li><a href="#">Pricing</a></li>
        <li><a href="#">Renting</a></li>
    </div>
</footer>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
   <script>
     AOS.init({offset:0});
     </script>
</html>
