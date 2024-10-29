<?php
include 'config.php';
session_start();

if (isset($_POST['submit'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password']; // jangan gunakan md5 di sini, karena kita akan verifikasi dengan password_verify nanti
    
    // Cek email di database
    $select = "SELECT * FROM user_form WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_array($result);

        // Verifikasi apakah password cocok
        if (password_verify($pass, $row['password'])) {
            
            if ($row['user_type'] == 'admin') {
                $_SESSION['admin_name'] = $row['name'];
                header('location:admin_page.php');
            } elseif ($row['user_type'] == 'user') {
                $_SESSION['user_name'] = $row['name'];
                header('location:home.php');
            }

        } else {
            $error[] = 'Incorrect password!';
        }

    } else {
        $error[] = 'Incorrect email or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .login-container {
            padding-top: 10px;
            padding-bottom: 5px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
 
        .login-form {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            background-color: #f8f9fa;
            color:#1E2A5E;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .login-form h2 {
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

        .login-container {
            margin-top: 80px; 
        }

        .custom-button {
            background-color: #1E2A5E; /* Custom color */
            color: #E1D7B7
        }

        .custom-button:hover {
            background-color: #28356c; /* Darker shade on hover */
            color: #f0ede1;
        }
    </style>
</head>

            <script src="app.js"></script>

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

    <!-- Login Form -->
    <div class="login-container">
        <div class="login-form">
            <h2>Login</h2>

            <?php
            if(isset($error)){
                foreach($error as $error){
                    echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
                };
            };
            ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn custom-button w-100" name="submit">Login</button>
                <p>Don't have an account? <a href="daftar.php">Sign up now</a></p>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1
