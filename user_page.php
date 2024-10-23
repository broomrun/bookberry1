<?php
include 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Page</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"> <!-- Pindahkan tag link ke sini -->
   <style>
       * {
           margin: 0;
           padding: 0;
           box-sizing: border-box;
           font-family: "Poppins", sans-serif;
           background-color: #1e2a5e;
       }

       section {
           position: relative;
           width: 100%;
           min-height: 100vh;
           display: flex;
           flex-direction: column;
           justify-content: center;
           background-size: cover;
           background-position: center;
       }

       header {
           position: relative;
           width: 100%;
           padding: 30px 5%;
           display: flex;
           justify-content: space-between; /* Tombol burger di kanan, logo di kiri */
           align-items: center;
       }

       header .logo {
           color: #ffffff;
           font-size: 30px;
           text-decoration: none;
           text-transform: uppercase;
           font-weight: 800;
           letter-spacing: 1px;
           margin: 0 auto; /* Menjaga logo di tengah */
       }

       .navigation {
           display: flex; /* Menjaga navigasi tampil di desktop */
       }

       .navigation a {
           color: #ffffff;
           text-decoration: none;
           font-weight: 500;
           letter-spacing: 1px;
           padding: 2px 15px;
           border-radius: 20px;
           transition: 0.3s background;
           margin-right: 30px;
       }

       .navigation a:last-child {
           margin-right: 0;
       }

       .navigation a:hover {
           background: #fff;
       }

       .content {
           max-width: 650px;
           margin: auto 60px;
           text-align: left;
       }

       .content .info h2 {
           color: #ffffff;
           font-size: 55px;
           text-transform: uppercase;
           font-weight: 800;
           letter-spacing: 2px;
           line-height: 60px;
           margin-bottom: 30px;
       }

       .content .info h2 span {
           color: #fff;
           font-size: 50px;
           font-weight: 600;
       }

       .content p {
           font-size: 16px;
           font-weight: 500;
           margin-bottom: 40px;
           color: #fff;
       }

       .content .info-btn {
           color: #1e2a5e;
           background: #ffffff;
           text-decoration: none;
           text-transform: uppercase;
           font-weight: 700;
           letter-spacing: 2px;
           padding: 10px 20px;
           border-radius: 50px;
           transition: 0.3s background;
       }

       .content .info-btn:hover {
           background: #384daa;
       }

       .media-icons {
           display: flex;
           justify-content: center;
           align-items: flex-end;
           margin: auto;
       }

       .media-icons a {
           color: #ffffff;
           font-size: 25px;
           transition: 0.3s transform;
           margin-right: 30px;
       }

       .media-icons a:last-child {
           margin-right: 0;
       }

       .media-icons a:hover {
           transform: scale(1.5);
       }

       label {
           display: none; /* Menyembunyikan label di desktop */
       }

       #check {
           z-index: 3;
           display: none; /* Menyembunyikan checkbox di desktop */
       }

       /* Media Queries */
       @media (max-width: 960px) {
           header {
               justify-content: center; /* Logo di tengah dan tombol burger di kanan */
           }

           header .logo {
               margin: 0; /* Menghilangkan margin untuk menjaga posisi di tengah */
           }

           .navigation {
               display: none; /* Menyembunyikan navigasi di mobile */
           }

           label {
               display: block; /* Menampilkan label tombol burger */
               font-size: 25px;
               cursor: pointer;
               transition: 0.3s color;
               margin-left: auto; /* Memastikan label tetap di kanan */
           }

           label:hover {
               color: #fff;
           }

           #check:checked ~ header .navigation {
               z-index: 2;
               position: fixed;
               background: #010721b0;
               top: 0;
               bottom: 0;
               left: 0;
               right: 0;
               display: flex;
               flex-direction: column;
               justify-content: center;
               align-items: center;
           }

           #check:checked ~ header .navigation a {
               font-weight: 700;
               margin-right: 0;
               margin-bottom: 50px;
               letter-spacing: 2px;
           }
       }

       @media (max-width: 500px) {
           .content .info h2 {
               font-size: 30px; /* Mengatur ukuran teks lebih kecil */
               line-height: 50px;
               font-weight: 600;
           }

           .content p {
               font-size: 14px; /* Mengatur ukuran teks lebih kecil */
           }
       }
   </style>

</head>
<body>
   
<section>
    <header>
      <h2><a href="#" class="logo">logo</a></h2>
      <nav class="navigation">
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Profile</a>
      </nav>
    </header>
    <div class="content">
      <div class="info">
        <h2>Hi, <br><span>BERRYs!</span></h2> 
        <p>Your one-stop platform for discovering and rating your favorite books<br><span>Dive into the world of literature and share your thoughts with others!</span></p>
        <a href="login.php" class="info-btn">More Info</a>
      </div>
    </div>
    
    <div class="media-icons">
      <a href="#"><i class="fab fa-facebook-f"></i></a>
      <a href="#"><i class="fab fa-twitter"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
      <a href="logout.php" class="btn">logout</a>


    </div>
</section>

</body>
</html>
