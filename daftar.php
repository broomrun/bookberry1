<?php
session_start();
include "config.php";

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];
    $cpass = $_POST['confirmPassword'];
    $user_type = $_POST['user_type'];
    $image = $_FILES['profile_picture']['name']; // Changed 'image' to 'profile_picture'
    $image_size = $_FILES['profile_picture']['size']; // Changed 'image' to 'profile_picture'
    $image_tmp_name = $_FILES['profile_picture']['tmp_name']; // Changed 'image' to 'profile_picture'
    $image_folder = 'uploaded_img/' . $image;

    // Cek apakah user dengan email sudah ada
    $select = "SELECT * FROM user_form WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $error[] = 'User already exists!';
    } else {
        if ($pass != $cpass) {
            $error[] = 'Password does not match!';
        } elseif ($image_size > 2000000) { // Ukuran gambar lebih dari 2MB
            $error[] = 'Image size is too large! Maximum size is 2MB.';
        } else {
            // Hash password setelah validasi
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

            // Insert user data ke database
            $insert = "INSERT INTO user_form(name, email, password, user_type, image) 
                       VALUES('$name','$email','$hashed_password','$user_type','$image')";

            // Cek apakah query insert berhasil
            // Insert user data ke database
            $insert = "INSERT INTO user_form(name, email, password, user_type, image) 
            VALUES('$name','$email','$hashed_password','$user_type','$image')";

// Cek apakah query insert berhasil
            if (mysqli_query($conn, $insert)) {
            if ($_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            if (move_uploaded_file($image_tmp_name, $image_folder)) {
            header('location:login.php'); // Redirect to the login page after success
            } else {
            $error[] = 'Failed to upload image!';
            }
            } else {
            $error[] = 'File upload error: ' . $_FILES['profile_picture']['error'];
            }
            } else {
            $error[] = 'Failed to register user!';
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
    <link href="https://cdn.jsdelivr


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
            max-height: 50px; /* Adjust as needed for logo size */
            width: auto;
            vertical-align: left; /* Aligns the image with the navigation */
            align-items: left;
            margin-right: auto;
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
        <a href="#" class="logo"><img src="assets/logowhite.png" alt="logo image"></a>
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
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<span class="error-msg">' . $error . '</span>';
                }
            }
            ?>

            <form method="POST" action="" enctype="multipart/form-data">
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
                <div class="mb-3">
                    <label for="chooseFile" class="form-label">Choose File</label>
                    <input type="file" class="form-control" id="chooseFile" accept="image/jpg, image/jpeg, image/png" name="profile_picture" placeholder="Choose File" required>
                </div>
                <button type="submit" class="btn custom-button w-100" name="submit">Sign Up</button>
                <p>Already have an account? <a href="login.php">Login now</a></p>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

</body>
</html>
