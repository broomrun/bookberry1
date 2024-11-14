<?php
session_start();
include "config.php";

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];
    $cpass = $_POST['confirmPassword'];
    $user_type = $_POST['user_type'];

    $errors = [];

    // Cek apakah user dengan email sudah ada
    $select = "SELECT * FROM user_form WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $errors[] = 'User already exists!';
    } else {
        if ($pass != $cpass) {
            $errors[] = 'Password does not match!';
        } else {
            // Hash password setelah validasi
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

            // Insert user data ke database
            $insert = "INSERT INTO user_form(name, email, password, user_type) 
                       VALUES('$name','$email','$hashed_password','$user_type')";

            if (mysqli_query($conn, $insert)) {
                header('location:login.php'); // Redirect to the login page after success
            } else {
                $errors[] = 'Failed to register user!';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .signup-container {
            padding-top: 10px;
            padding-bottom: 15px;
            min-height: 50vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .signup-form {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            background-color: #f8f9fa;
            color: #1E2A5E;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .signup-form h2 {
            margin-bottom: 1.5rem;
            font-weight: bold;
            text-align: center;
        }

        .navbar {
            background-color: #1e2a5e; 
            padding: 0; 
            width: 100%; 
            height: 70px;
            margin: 0 auto;
            position: fixed; 
            top: 0; 
            left: 50%; 
            transform: translateX(-50%); 
            z-index: 1000; 
        }

        .logo img {
            max-height: 50px;
            width: auto;
        }

        .navigation {
            display: flex;
            justify-content: space-between;
        }

        .nav-links {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .nav-links li {
            margin-right: 25px;
        }

        .nav-links a {
            color: #ffffff;
            text-decoration: none;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        body {
            background-color: #1E2A5E;
        }

        .signup-container {
            margin-top: 80px; 
        }

        .custom-button {
            background-color: #1E2A5E;
            color: #E1D7B7;
        }

        .custom-button:hover {
            background-color: #28356c;
            color: #f0ede1;
        }

        .form-container form .error-msg {
            background-color: #dc3545;
            padding: 15px;
            border-radius: 5px;
            color: white;
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            top: 70%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #1E2A5E;
            font-size: 0.7rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <a href="#" class="logo"><img src="assets/logowhite.png" alt="logo image"></a>
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </div>
    </nav>

    <!-- Sign Up Form -->
    <div class="signup-container">
        <div class="signup-form">
            <h2>Sign Up</h2>

            <?php
            if (isset($errors)) {
                foreach ($errors as $error) {
                    echo '<span class="error-msg">' . $error . '</span>';
                }
            }
            ?>

            <form method="POST" action="" onsubmit="return validateForm()">
                <div class="mb-3">
                    <label for="name" class="form-label">Username</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3 password-container">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                    <span class="toggle-password" id="togglePassword"><i class="fas fa-eye"></i></span>
                </div>
                <div class="mb-3 password-container">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                    <span class="toggle-password" id="toggleConfirmPassword"><i class="fas fa-eye"></i></span>
                </div>
                <div class="mb-3">
                    <select name="user_type" class="form-control">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn custom-button w-100" name="submit">Sign Up</button>
                <p>Already have an account? <a href="login.php">Login now</a></p>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("togglePassword").addEventListener("click", function() {
            var passwordField = document.getElementById("password");
            var icon = this.querySelector("i");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.toggle("fa-eye-slash");
                icon.classList.toggle("fa-eye");
            } else {
                passwordField.type = "password";
                icon.classList.toggle("fa-eye-slash");
                icon.classList.toggle("fa-eye");
            }
        });

        document.getElementById("toggleConfirmPassword").addEventListener("click", function() {
            var confirmPasswordField = document.getElementById("confirmPassword");
            var icon = this.querySelector("i");
            if (confirmPasswordField.type === "password") {
                confirmPasswordField.type = "text";
                icon.classList.toggle("fa-eye-slash");
                icon.classList.toggle("fa-eye");
            } else {
                confirmPasswordField.type = "password";
                icon.classList.toggle("fa-eye-slash");
                icon.classList.toggle("fa-eye");
            }
        });

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
