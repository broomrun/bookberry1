<?php
include 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Information</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="style/s_details.css" rel="stylesheet">
</head>
<body>
    <?php include "layout/header.html"?>

    <div class="book-info">
        <img src="assets/11.jpeg" alt="Di Tanah Lada" class="book-cover">
        <div class="book-details">
            <h2 class="title">Di Tanah Lada <span style="font-size: 12px; color: #777;">2022</span></h2>
            <p class="author">by Ziggy Zagga Ziggy tu Zagga</p>
            <p class="description">Dalam sebuah keluarga, seorang anak pasti sangat membutuhkan kasih sayang kedua orang tuanya. Hal ini dikarenakan berkat kasih sayang mereka, maka seorang anak bisa tumbuh dengan baik dan merasa bahagia ketika hidup bersama kedua orang tuanya. Maka dari itu, dapat dikatakan bahwa kasih sayang dari orang tua sangat berperan penting dalam kehidupan anak di masa yang akan datang. Bagi para orang tua, sudah seharusnya selalu berusaha untuk memberikan kasih sayang kepada anaknya walaupun sedang dalam keadaan sibuk.
            </p>
        </div>
    </div>

    <div class="container">
        <!-- Input form for new comments -->
            <div class="comment-body">
            <textarea id="new-comment" placeholder="Write your comment here..."></textarea>
            <button onclick="addComment()">Post Comment</button>
            </div>

        <!-- Comment Section -->
        <div class="comment__container opened" id="first-comment">
            <div class="comment__card">
                <div class="comment__profile">
                    <img src="assets/1.jpeg" alt="Profile Picture">
                </div>
                <div class="comment__content">
            <h3 class="comment__title">Juyeon</h3>
            <p>COyy seru banget bukunya. saya suka sekali memang karya si ziggy zaga ziggyy tu zaga zig zig tu zag zag welcome to our family zigiiiiiii zaga zigi tu zaga zig zig tu zag zag wow</p>
            <div class="comment__card-footer">
                <div>Likes 123</div>
                <div>Disliked 23</div>
                <div class="show-replies" onclick="toggleReplyForm('1')">Reply 2</div>
            </div>
        </div>
                </div>
            </div>

            <!-- Reply input form -->
            <div class="reply-form" id="reply-form-1" style="display: none;">
                <textarea id="new-comment" placeholder="Write your reply..."></textarea>
                <button onclick="addReply('1')">Post Reply</button>
            </div>
        </div>
    </div>

    <script src="js/comment.js"></script>  
    <script src="js/script.js"></script>  
</body>
</html>
