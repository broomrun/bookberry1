<?php
include 'config.php';
session_start();

$emailValue = ''; // Untuk menyimpan nilai email input
$login_error = '';
$signup_error = '';

// Login Form
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];
    $emailValue = $email; // Menyimpan email yang diinput

    $select = "SELECT * FROM user_form WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        if (password_verify($pass, $row['password'])) {
            $_SESSION['user_name'] = $row['name'];
            echo "success";  // Berhasil login
            exit;
        } else {
            $login_error = 'Incorrect password!';
        }
    } else {
        $login_error = 'Incorrect email or password!';
    }

    echo $login_error;  // Mengirimkan pesan error login
    exit;
}

// Sign Up Form
if (isset($_POST['action']) && $_POST['action'] == 'signup') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Validasi password
    if ($password !== $confirm_password) {
        $signup_error = 'Passwords do not match.';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Cek jika email atau username sudah digunakan
        $check_query = "SELECT * FROM user_form WHERE email = '$email' OR name = '$username'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $signup_error = 'Email or username already exists.';
        } else {
            $insert_query = "INSERT INTO user_form (email, name, password) VALUES ('$email', '$username', '$hashed_password')";
            if (mysqli_query($conn, $insert_query)) {
                echo "success";  // Berhasil signup
                exit;
            } else {
                $signup_error = 'Failed to create account. Please try again.';
            }
        }
    }

    echo $signup_error;  // Mengirimkan pesan error signup
    exit;
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
<!-- Modal Login -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <div class="modal-header">
            <h5 class="modal-title mx-auto" id="loginModalLabel">Login</h5>
        </div>
        <form id="loginForm" method="POST">
            <label for="loginEmail">Email:</label>
            <input type="email" id="loginEmail" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($emailValue); ?>" required><br>

            <label for="loginPassword">Password:</label>
            <div class="password-wrapper">
                <input type="password" id="loginPassword" name="password" placeholder="Enter your password" required><br>
                <i class="bx bx-hide" id="toggleLoginPassword"></i>
            </div>

            <input type="hidden" name="action" value="login">
            <input type="submit" name="login_submit" value="Login">
            <div class="error" id="loginError"></div>
            <div class="form-text text-center mt-3">
                Don't have an account? <a href="javascript:void(0);" id="openSignupModal" class="link-primary" style="color: #1e2a5e;">Sign up now</a>
            </div>
        </form>
    </div>
</div>

<!-- Modal Sign-Up -->
<div id="signupModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <div class="modal-header">
            <h5 class="modal-title mx-auto">Sign up</h5>
        </div>
        <form id="signupForm" method="POST">
            <label for="signupEmail">Email:</label>
            <input type="email" id="signupEmail" name="email" placeholder="Enter your email" required><br>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required><br>

            <label for="signupPassword">Password:</label>
            <div class="password-wrapper">
                <input type="password" id="signupPassword" name="password" placeholder="Enter your password" required><br>
                <i class="bx bx-hide" id="toggleSignupPassword"></i>
            </div>

            <label for="confirmPassword">Confirm Password:</label>
            <div class="password-wrapper">
                <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm your password" required><br>
                <i class="bx bx-hide" id="toggleConfirmPassword"></i>
            </div>

            <input type="hidden" name="action" value="signup">
            <input type="submit" name="signup_submit" value="Sign Up">
            <div class="error" id="signupError"></div>
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
                        <a href="#"  onclick="openLoginModal()">
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
            <a href="#" id="startJourneyBtn" class="info-btn">Start my journey!</a>
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

    // Functions to Open Modals
    function openLoginModal() {
        loginModal.style.display = "block";
        signupModal.style.display = "none";
    }

    function openSignupModal() {
        signupModal.style.display = "block";
        loginModal.style.display = "none";
    }

    // Functions to Close Modals
    function closeModal(modal) {
        modal.style.display = "none";
    }

    var journeyModal = document.getElementById("loginModal"); 
    var startJourneyBtn = document.getElementById("startJourneyBtn");

    startJourneyBtn.onclick = function() {
        journeyModal.style.display = "block";  
    };

    // Attach Event Listeners
    openLoginBtn.onclick = openLoginModal;
    openSignupBtn.onclick = openSignupModal;

    loginCloseBtn.onclick = function() {
        closeModal(loginModal);
    };

    signupCloseBtn.onclick = function() {
        closeModal(signupModal);
    };

    // Handle "Login now" link in Sign Up Modal
    var switchToLoginBtn = document.querySelector("#signupModal #openModal");
    switchToLoginBtn.onclick = openLoginModal;

    // Close Modals When Clicking Outside
    window.onclick = function(event) {
        if (event.target == loginModal) {
            closeModal(loginModal);
        }
        if (event.target == signupModal) {
            closeModal(signupModal);
        }
    };
    document.addEventListener('DOMContentLoaded', function() {
    // Otomatis buka login modal setelah sign up sukses
    if (document.querySelector('.error').textContent === '') {
        openLoginModal();
    }
});
// AJAX for Login
document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '', true);
    xhr.onload = function() {
        if (xhr.status == 200) {
            var response = xhr.responseText.trim();
            if (response === "success") {
                window.location.href = "home.php"; // Redirect on success
            } else {
                document.getElementById('loginError').textContent = response;
            }
        }
    };
    xhr.send(formData);
});

// AJAX for Sign-Up
document.getElementById('signupForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '', true);
    xhr.onload = function() {
        if (xhr.status == 200) {
            var response = xhr.responseText.trim();
            if (response === "success") {
                document.getElementById('loginModal').style.display = "block"; // Open login modal
                document.getElementById('signupModal').style.display = "none";
            } else {
                document.getElementById('signupError').textContent = response;
            }
        }
    };
    xhr.send(formData);
});
// Toggle visibility of login password
document.getElementById('toggleLoginPassword').addEventListener('click', function() {
    var passwordField = document.getElementById('loginPassword');
    var icon = document.getElementById('toggleLoginPassword');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.classList.remove('bx-hide');
        icon.classList.add('bx-show');
    } else {
        passwordField.type = 'password';
        icon.classList.remove('bx-show');
        icon.classList.add('bx-hide');
    }
});

// Toggle visibility of signup password
document.getElementById('toggleSignupPassword').addEventListener('click', function() {
    var passwordField = document.getElementById('signupPassword');
    var icon = document.getElementById('toggleSignupPassword');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.classList.remove('bx-hide');
        icon.classList.add('bx-show');
    } else {
        passwordField.type = 'password';
        icon.classList.remove('bx-show');
        icon.classList.add('bx-hide');
    }
});

// Toggle visibility of confirm password
document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
    var passwordField = document.getElementById('confirmPassword');
    var icon = document.getElementById('toggleConfirmPassword');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.classList.remove('bx-hide');
        icon.classList.add('bx-show');
    } else {
        passwordField.type = 'password';
        icon.classList.remove('bx-show');
        icon.classList.add('bx-hide');
    }
});

</script>


</html>