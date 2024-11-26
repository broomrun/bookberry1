<?php
include 'config.php';
session_start();

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];
    $cpass = $_POST['confirmPassword'];

    $errors = [];

    // Cek apakah email sudah digunakan
    $select = "SELECT * FROM user_form WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $errors[] = 'User already exists!';
    } else {
        if ($pass != $cpass) {
            $errors[] = 'Passwords do not match!';
        } else {
            // Hash password
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

            // Insert user ke database
            $insert = "INSERT INTO user_form(name, email, password) 
                       VALUES('$name', '$email', '$hashed_password')";

            if (mysqli_query($conn, $insert)) {
                header('location:login.php'); // Redirect ke halaman login
            } else {
                $errors[] = 'Failed to register user!';
            }
        }
    }
}


$emailValue = ''; // Untuk menyimpan email input

if (isset($_POST['submit'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];
    $emailValue = $email; // Menyimpan email saat form dikirim
    
    // Cek email di database
    $select = "SELECT * FROM user_form WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_array($result);

        // Verifikasi apakah password cocok
        if (password_verify($pass, $row['password'])) {
            
            // Saring data user, tidak perlu cek user_type
            $_SESSION['user_name'] = $row['name'];
            header('location:home.php'); // Redirect ke halaman home setelah login berhasil
            exit; // Pastikan proses berhenti setelah redirect

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
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    
<style>      /* Modal header styling */
.modal-content {
    border-radius: 15px;
    border: none;
    background-color: #ffffff;
}

.modal-header {
    border-bottom: none;
    text-align: center;
    background-color: #f0f0f0; /* Add background if needed */
    color: #fff;
}

.modal-header h5 {
    font-weight: bold;
    color: #1a1f71; /* Dark Blue Color */

}

/* Modal body padding and focus styling */
.modal-body {
    padding: 2rem;
}

.form-control:focus {
    box-shadow: none;
    border-color: #1a1f71;
}

/* Primary button styling */
.btn-primary {
    background-color: #1a1f71;
    border: none;
    border-radius: 5px;
}

.btn-primary:hover {
    background-color: #141a5a;
}

.modal-footer {
    justify-content: center;
}

/* Ensure the modal background color is applied */
.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent dark backdrop */
}

/* Ensure the modal is visible */
.modal.show {
    display: block !important;
}

      .form-label {
        font-weight: 500;
      }
      .form-text a {
        color: #1a1f71;
        text-decoration: underline;
      }
      .modal-footer {
        justify-content: center;
      }
      .form-label {
        font-weight: 500;
      }
      .link-primary {
        text-decoration: none;
      }
      .link-primary:hover {
        text-decoration: underline;
      }
</style>
</head>
  <!-- Login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      <div class="modal-header">
            <h5 class="modal-title mx-auto" id="loginModalLabel">Login</h5>
        </div>
        <div class="modal-body">
          <form id="loginForm" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($emailValue); ?>" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                  <i class="bi bi-eye"></i> <!-- Initial Icon: Open Eye -->
                </button>
              </div>
            </div>
            <button type="submit" class="btn btn-primary w-100" name="submit">Login</button>
            <div class="form-text text-center mt-3">
            <p class="mt-3">Don't have an account? <a href="daftar.php" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#signupModal">Sign up here</a></p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

    <!-- Modal -->
    <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      <div class="modal-header">
            <h5 class="modal-title mx-auto" id="signupModalLabel">Sign Up</h5>
        </div>
        <div class="modal-body">
          <form method="POST" action="" onsubmit="return validateForm()">
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', this)">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>
            <div class="mb-3">
              <label for="confirmPassword" class="form-label">Confirm Password</label>
              <div class="input-group">
                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Confirm your password" required>
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmPassword', this)">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>
            <div class="d-grid">
              <button type="submit" name="submit" class="btn btn-primary">Sign Up</button>
            </div>
          </form>
          <div class="form-text text-center mt-3">
          <p class="mt-3">Already have an account? <a href="login.php" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Login now</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>

<body>
    <section>
        <?php include "layout/header.html"?>

        <div class="content">
            <div class="info">
            <h2>Hi, <br><span>BERRYs!</span></h2> 
            <p>Your one-stop platform for discovering and rating your favorite books<br><span>Dive into the world of literature and share your thoughts with others!</span></p>
            <a href="login.php" class="info-btn" data-bs-toggle="modal" data-bs-target="#loginModal">More Info</a>
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
                            <a href="login.php" data-bs-toggle="modal" data-bs-target="#loginModal">
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
        <a href="login.php" class="info-btn" style="font-size: 1.2em; padding: 10px 20px;" data-bs-toggle="modal" data-bs-target="#loginModal">Start my journey!</a>    
    </div>
</div>
    
<?php include "layout/footer.html"?>

<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Initialize AOS (Animate on Scroll)
  AOS.init({ offset: 0 });

  // Toggle password visibility
  const togglePassword = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');
  
  togglePassword.addEventListener('click', function () {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);

    // Toggle the icon
    this.innerHTML = type === 'password' 
      ? '<i class="bi bi-eye-slash"></i>' 
      : '<i class="bi bi-eye"></i>';
  });

  // Another toggle password function (you can remove this if redundant)
  function togglePassword(fieldId, button) {
    const field = document.getElementById(fieldId);
    const icon = button.querySelector("i");
    if (field.type === "password") {
      field.type = "text";
      icon.classList.add("bi-eye");
      icon.classList.remove("bi-eye-slash");
    } else {
      field.type = "password";
      icon.classList.add("bi-eye-slash");
      icon.classList.remove("bi-eye");
    }
  }

  // Form validation
  function validateForm() {
    const pass = document.getElementById("password").value;
    const cpass = document.getElementById("confirmPassword").value;
    if (pass !== cpass) {
      alert("Passwords do not match!");
      return false;
    }
    return true;
  }

</script>
</body>
</html>