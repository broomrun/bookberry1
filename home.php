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
    <link href="styles.css" rel="stylesheet">
</head>
<body>

<header>
    <h2><a href="#" class="logo">logo</a></h2>
    <nav class="navigation">
        <a href="home.php">Home</a>
        <a href="about.php">About</a>
<<<<<<< HEAD
        <a href="profile.php">Profile</a>
=======
        <a href="update_profile.php">Profile</a>
>>>>>>> 8c0dba992c95443fcd5a880a591a4c93834f6f57
    </nav>
</header>

<div id="content" class="container">
    <h1 class="text-center">Hi, <?php echo $_SESSION['user_name']; ?>!</h1>
    <h2 class="text-desc">Picked where you left off.</h2>
    <div class="search-container d-flex justify-content-center mb-5">
        <input type="text" class="search me-2" id="searchInput" placeholder="Search...">
        <div class="dropdown">
        <select id="genreFilter" class="form-select">
        <option value="allgenre">All Genre</option>
        <option value="fiction">Fiction</option>
        <option value="science">Science</option>
        <option value="history">History</option>
        <option value="fantasy">Fantasy</option>
        <option value="biography">Biography</option>
</select>
        <button class="search-button btn btn-primary" id="search-button">Search</button>
    </div>
</div>

    <hr>

    <div class="row" id="book-list"></div> <!-- Only one book-list -->
    
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Book Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="book-detail">Book details will appear here...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="parent">
    <h3 class="text-top">Discover Our Book!</h3>
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
