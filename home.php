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
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body>

<header>
<h2>
    <a href="user_page.php" class="logo">
        <img src="assets/logo.png" alt="Logo" class="logo-image" />
    </a>
</h2>
    <nav class="navigation">
        <a href="home.php">Home</a>
        <a href="about.php">About</a>
        <a href="profile.php">Profile</a>
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

<div class="container">
  <div class="row g-4 mt-4">
    <div class="col-md-4">
      <div class="tile green d-flex align-items-center p-4" style="border-radius: 20px;">
        <div class="content" style="flex: 1;">
          <h2 style="color: #FFFFFF"><strong>Fantasy</strong></h2>
          <p style="color: #FFFFFF; max-width: 200px; text-align: justify;">
            Magic-filled worlds of adventure and mythical creatures.
          </p>
        </div>
        <img src="assets/fantasyy.png" alt="Fantasy Image" style="width: 150px; height: 150px;">
      </div>
    </div>
    <div class="col-md-4">
      <div class="tile red d-flex align-items-center p-4" style="border-radius: 20px;">
        <div class="content" style="flex: 1;">
          <h2 style="color: #FFFFFF"><strong>Fiction</strong></h2>
          <p style="color: #FFFFFF; max-width: 150px; text-align: justify;">
            Creative stories exploring life and emotions.
          </p>
        </div>
        <img src="assets/fiction.png" alt="Fiction Image" style="width: 150px; height: 150px;">
      </div>
    </div>
    <div class="col-md-4">
      <div class="tile brown d-flex align-items-center p-4" style="border-radius: 20px;">
        <div class="content" style="flex: 1;">
          <h2 style="color: #FFFFFF"><strong>History</strong></h2>
          <p style="color: #FFFFFF; max-width: 150px; text-align: justify;">
            Real events and cultures that shaped our world.
          </p>
        </div>
        <img src="assets/history.png" alt="History Image" style="width: 150px; height: 150px;">
      </div>
    </div>
    <div class="col-md-6">
      <div class="tile yellow d-flex align-items-center p-4" style="border-radius: 20px;">
        <div class="content" style="flex: 1;">
          <h2 style="color: #FFFFFF"><strong>Science</strong></h2>
          <p style="color: #FFFFFF; max-width: 300px; text-align: justify;">
            Fascinating insights into the workings of our universe.
          </p>
        </div>
        <img src="assets/science.png" alt="Science Image" style="width: 150px; height: 150px;">
      </div>
    </div>
    <div class="col-md-6">
      <div class="tile orange d-flex align-items-center p-4" style="border-radius: 20px;">
        <div class="content" style="flex: 1;">
          <h2 style="color: #FFFFFF"><strong>Biography</strong></h2>
          <p style="color: #FFFFFF; max-width: 300px; text-align: justify;">
            Inspiring life stories of remarkable people.
          </p>
        </div>
        <img src="assets/bio.png" alt="Biography Image" style="width: 150px; height: 150px;">
      </div>
    </div>
  </div>
</div>
      
<footer class="footer">
    <div class="footer-content">
        <img src="assets/logo.png">
        <p>halo </p>

        <div class="icons">
            <a href="#"><i class='bx bxl-facebook-circle'></i></a>
            <a href="#"><i class='bx bxl-twitter'></i></a>
            <a href="#"><i class='bx bxl-instagram-alt'></i></a>
            <a href="#"><i class='bx bxl-youtube'></i></a>
        </div>
    </div>

    <div class="footer-content">
        <h4>Reading Lists</h4>
        <li><a href="#">Genres</a></li>
        <li><a href="#">Book Categories</a></li>
        <li><a href="#">Top Reviews</a></li>
        <li><a href="#">Top Authors</a></li>
    </div>

    <div class="footer-content">
        <h4>About Us</h4>
        <li><a href="#">How we work</a></li>
        <li><a href="#">Book of the Month</a></li>
        <li><a href="#">Privacy & Security</a></li>
        <li><a href="#">Recommend Reads</a></li>
    </div>

    <div class="footer-content">
        <h4>Reading Challenges</h4>
        <li><a href="#">Join Us</a></li>
        <li><a href="#">Subscription</a></li>
        <li><a href="#">Borrow Books</a></li>
    </div>
</footer>

<!-- Optional JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/script.js"></script>

</body>
</html>
