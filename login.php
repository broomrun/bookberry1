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

    <!-- Updated Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .login-container {
            padding-top: 10px;
            padding-bottom: 5px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #1E2A5E;
        }
        .login-form {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            background-color: #f8f9fa;
            color: #1E2A5E;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .login-form h2 {
            margin-bottom: 1.5rem;
            font-weight: bold;
            text-align: center;
        }
        .custom-button {
            background-color: #1E2A5E;
            color: #E1D7B7;
        }
        .custom-button:hover {
            background-color: #28356c;
            color: #f0ede1;
        }
        .password-container {
            position: relative;
        }
        #togglePassword {
            position: absolute;
            top: 70%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #1E2A5E;
            font-size: 0.75rem;
        }
    </style>
</head>
<body>

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
                <div class="mb-3 password-container">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                    <span id="togglePassword"><i class="fas fa-eye"></i></span> <!-- Updated icon class here -->
                </div>
                <button type="submit" class="btn custom-button w-100" name="submit">Login</button>
                <p>Don't have an account? <a href="daftar.php">Sign up now</a></p>
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
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        });
    </script>
</body>
</html>



