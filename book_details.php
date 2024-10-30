<?php

include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet"> <!-- Link Poppins -->
    <link href="styled.css" rel="stylesheet">
</head>
<body>
    <header>
        <h2><a href="#" class="logo">logo</a></h2>
        <nav class="navigation">
          <a href="home.html">Home</a>
          <a href="about.html">About</a>
          <a href="#">Profile</a>
        </nav>
      </header>

      <div class="book-info">
        <img src="assets/11.jpeg" alt="Di Tanah Lada" class="book-cover">
        <div class="book-details">
            <h2 class="title">Di Tanah Lada <span style="font-size: 12px; color: #777;">2022</span></h2>
            <p class="author">by Ziggy Zagga Ziggy tu Zagga</p>
            <p class="description">
                Namanya Salva. Panggilannya Ava. Namun papanya memanggil dia Saliva atau ludah karena menganggapnya tidak berguna. Ava sekeluarga pindah ke Rusun Nero setelah Kakek Kia meninggal. Kakek Kia, ayahnya Papa, pernah memberi Ava kamus sebagai hadiah ulang tahun yang ketiga. Sejak itu Ava menjadi anak yang pintar berbahasa Indonesia. Sayangnya, kebanyakan orang dewasa lebih menganggap penting anak yang pintar berbahasa Inggris. Setelah pindah ke Rusun Nero, Ava bertemu dengan anak laki-laki bernama P. Iya, namanya hanya terdiri dari satu huruf P. Dari pertemuan itulah, petualangan Ava dan P bermula hingga sampai pada akhir yang mengejutkan.
            </p>
            <div class="stars">
                <span>★</span><span>★</span><span>★</span><span>☆</span><span>☆</span>
            </div>
        </div>
        <a href="#" class="read-link">Baca Buku</a> <!-- Link Baca Buku -->
    </div>
    
    <div class="comment-section">
        <div id="comment-list">
            <!-- Komentar lama tetap ada di sini -->
            <div class="comment">
                <img src="assets/1.jpeg" alt="User Icon">
                <div>
                    <div class="rating">★★★☆☆</div>
                    <p class="comment-text">Ceritanya seru banget, tapi kadang bikin ngantuk. Tapi ini cerita bagus banget...</p>
                </div>
            </div>
        </div>
        
        <!-- Input untuk komentar baru -->
        <input type="text" class="input-box" id="comment-input" placeholder="Ketik komentar...">
        <button id="submit-comment" class="submit-comment">Kirim</button>
    </div>
    <script src="js/book.js"></script>    
</body>
</html>
