<?php
include 'config.php';
session_start();

$emailValue = ''; // To store email input

// Check if form is submitted
if (isset($_POST['submit'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];
    $emailValue = $email; // Store email when form is submitted

    // Check if email exists in database
    $select = "SELECT * FROM user_form WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_array($result);

        // Verify if the password matches
        if (password_verify($pass, $row['password'])) {

            // Set session variable for user name
            $_SESSION['user_name'] = $row['name'];

            // Redirect to home.php after successful login
            header('Location: home.php');
            exit; // Make sure the script stops after redirect

        } else {
            $error = 'Incorrect password!';
        }
    } else {
        $error = 'Incorrect email or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="style/s_userpage.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>

<body>
    <section>
        <?php include "layout/header.html" ?>

        <div class="content">
            <div class="info">
                <h2>Hi, <br><span>BERRYs!</span></h2>
                <p>Your one-stop platform for discovering and rating your favorite books<br><span>Dive into the world of literature and share your thoughts with others!</span></p>
                <button id="openModal" class="info-btn">More Info</button>
            </div>
        </div>
    </section>

    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <div class="modal-header">
                <h5 class="modal-title mx-auto" id="loginModalLabel">Login</h5>
            </div>
            <form method="POST">
                <label for="loginEmail">Email:</label>
                <input type="email" id="loginEmail" name="email" placeholder="Enter your email" required><br>

                <label for="loginPassword">Password:</label>
                <input type="password" id="loginPassword" name="password" placeholder="Enter your password" required><br>

                <input type="submit" name="submit" value="Login">
                <div class="form-text text-center mt-3">
                    Don't have an account? <a href="javascript:void(0);" id="openSignupModal" class="link-primary" style="color: #1e2a5e;">Sign up now</a>
                </div>
            </form>
        </div>
    </div>

    <div id="signupModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <div class="modal-header">
                <h5 class="modal-title mx-auto">Sign up</h5>
            </div>
            <form method="POST">
                <label for="signupEmail">Email:</label>
                <input type="email" id="signupEmail" name="email" placeholder="Enter your email" required><br>

                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required><br>

                <label for="signupPassword">Password:</label>
                <input type="password" id="signupPassword" name="password" placeholder="Enter your password" required><br>

                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm your password" required><br>

                <input type="submit" name="submit" value="Sign Up">
            </form>
            <div class="form-text text-center mt-3">
                <p class="mb-0">Already have an account? <a href="javascript:void(0);" id="openModal" class="link-primary" style="color: #1e2a5e;">Login now</a></p>
            </div>
        </div>
    </div>


    <h1> Discover many books! </h1>
    <div id="bookCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <!-- Slide pertama dengan 5 buku -->
            <div class="carousel-item active">
                <div class="d-flex justify-content-center">
                    <div class="book-card">
                        <a href="#">
                            <img src="assets/10.jpeg" alt="Era Taylor Swift">
                        </a>
                        <div class="book-title">The God and the Gumiho</div>
                        <div class="author-name">Sophie Kim</div>
                    </div>
                    <div class="book-card">
                        <img src="assets/alice.jpg" alt="Alice">
                        <div class="book-title">Alice in Wonderland </div>
                        <div class="author-name">Lewis Carroll</div>
                    </div>
                    <div class="book-card">
                        <img src="assets/4.jpeg" alt="The Wind in the Willows">
                        <div class="book-title">The crimes of Steamfield</div>
                        <div class="author-name">Alberto Rey</div>
                    </div>
                    <div class="book-card">
                        <img src="assets/mary poppins.jpg" alt="Mary Poppins">
                        <div class="book-title">Mary Poppins</div>
                        <div class="author-name">P.L. Travers</div>
                    </div>
                    <div class="book-card">
                        <img src="assets/5.jpg" alt="Harry Potter and the Philosopher's Stone">
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
                        <div class="book-title">Lost in the Never Woods </div>
                        <div class="author-name">Aiden Thomas</div>
                    </div>
                    <div class="book-card">
                        <img src="assets/8.jpeg" alt="Moby Dick">
                        <div class="book-title">Moby Dick</div>
                        <div class="author-name">Herman Melville</div>
                    </div>
                    <div class="book-card">
                        <img src="assets/9.jpeg" alt="War and Peace">
                        <div class="book-title">Waves</div>
                        <div class="author-name">Ingrid Chabbert</div>
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
            <a href="#" class="info-btn">Start my journey!</a>
        </div>
    </div>

    <?php include "layout/footer.html" ?>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init({
        offset: 0
    });

    // Login Modal
    var loginModal = document.getElementById("loginModal");
    var openLoginBtn = document.getElementById("openModal");
    var loginCloseBtn = loginModal.getElementsByClassName("close-btn")[0];

    // Sign Up Modal
    var signupModal = document.getElementById("signupModal");
    var openSignupBtn = document.getElementById("openSignupModal");
    var signupCloseBtn = signupModal.getElementsByClassName("close-btn")[0];

    // Open Login Modal
    openLoginBtn.onclick = function() {
        loginModal.style.display = "block";
        signupModal.style.display = "none"; // Ensure Sign Up Modal is closed
    }

    // Open Sign Up Modal
    openSignupBtn.onclick = function() {
        signupModal.style.display = "block";
        loginModal.style.display = "none"; // Ensure Login Modal is closed
    }

    // Close Login Modal
    loginCloseBtn.onclick = function() {
        loginModal.style.display = "none";
    }

    // Close Sign Up Modal
    signupCloseBtn.onclick = function() {
        signupModal.style.display = "none";
    }

    // Handle "Login now" link in Sign Up Modal
    var switchToLoginBtn = document.querySelector("#signupModal #openModal");
    switchToLoginBtn.onclick = function() {
        signupModal.style.display = "none";
        loginModal.style.display = "block"; // Open Login Modal
    }

    // Close Modals When Clicking Outside
    window.onclick = function(event) {
        if (event.target == loginModal) {
            loginModal.style.display = "none";
        }
        if (event.target == signupModal) {
            signupModal.style.display = "none";
        }
    }
</script>

</html>