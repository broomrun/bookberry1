<?php
session_start();
include "config.php";

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];
    $cpass = $_POST['confirmPassword'];
    $user_type = $_POST['user_type'];

    // Cek apakah user dengan email sudah ada
    $select = "SELECT * FROM user_form WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $error[] = 'User already exists!';
    } else {
        if ($pass != $cpass) {
            $error[] = 'Password not matched!';
        } else {
            // Hash password setelah validasi
            $hashed_password = md5($pass);
            $insert = "INSERT INTO user_form(name, email, password, user_type) VALUES('$name','$email','$hashed_password','$user_type')";
            mysqli_query($conn, $insert);
            header('location:login.php');
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
    <!-- Custom CSS -->
    <style>
        .signup-container {
            padding-top: 50px;
            padding-bottom: 0px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .signup-form {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            background-color: #f8f9fa;
            color:#1E2A5E;
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

        .logo {
            color: #ffffff;
            text-decoration: none;
            font-size: 25px;
            margin-left: 15px;
            margin-top: 10px;
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
            overflow: hidden;
        }

        .signup-container {
            margin-top: 80px; 
        }

        .custom-button {
            background-color: #1E2A5E; /* Custom color */
            color: #E1D7B7;
        }

        .custom-button:hover {
            background-color: #28356c; /* Darker shade on hover */
            color: #f0ede1;
        }

        .form-container form .error-msg {
            margin: 10px 0;
            background: crimson;
            color: #fff;
            border-radius: 5px;
            font-size: 16px;
            padding: 10px;
            text-align: center;
        }

        .form-container form .error-msg {
            background-color: #dc3545; /* Warna merah bootstrap */
            padding: 15px;
            border-radius: 5px;
            color: white;
        }


    </style>
</head>
<body>



    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <h1 class="logo">BookBerry</h1>
            <ul class="nav-links">
                <li><a href="#content">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#services">Help</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Sign Up Form -->
    <div class="signup-container">
        <div class="signup-form">
            <h2>Sign Up</h2>

            <?php
            if(isset($error)){
                foreach($error as $error){
                    echo '<span class="error-msg">'.$error.'</span>';
                };
            };
            ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="name" class="form-label">Username</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                </div>
                <div class="mb-3">
                    <select name="user_type" class="form-control">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn custom-button w-100" name="submit">Sign Up</button>
                <p>already have an account? <a href="login.php">login now</a></p>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
