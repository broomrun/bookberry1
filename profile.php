<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = md5($_POST['password']);
    
    // Cek email saja di database
    $select = "SELECT * FROM user_form WHERE email = '$email'";
    
    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_array($result);
        
        // Cek apakah password cocok
        if($row['password'] == $pass){
            
            if($row['user_type'] == 'admin'){
                $_SESSION['admin_name'] = $row['name'];
                header('location:admin_page.php');
            } elseif($row['user_type'] == 'user'){
                $_SESSION['user_name'] = $row['name'];
                header('location:user_page.php');
            }

        } else {
            $error[] = 'Incorrect password!';
        }

    } else {
        $error[] = 'Incorrect email or password!';
    }

};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookBerry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet"> <!-- Link Poppins -->
    <link href="styley.css" rel="stylesheet">
</head>
<body>

<header>
    <a href="#" class="logo"><img src="assets/logo.png" alt="logo image"></a>
    <nav class="navigation">
        <a href="home.php">Home</a>
        <a href="about.php">About</a>
        <a href="profile.php">Profile</a>
    </nav>
</header>

<div class="main">
    <aside class = "left">
        left
    </aside>
    <main>
        MAIN
    </main>
    <aside class = "right">
        left
    </aside>
</div>

<footer>
    <p>© 2024 BookBerry. All Rights Reserved.</p>
</footer>

<!-- Optional JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/script.js"></script>

</body>
</html>
