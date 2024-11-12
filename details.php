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
                <span>★</span><span>★</span><span>★</span><span>☆</span><span>☆</span>
            </p>
        </div>
    </div>
    
    <div class="container">
        <!-- Input form for new comments -->
        <div class="add-comment">
            <h3>Add a Comment</h3>
            <textarea id="new-comment" placeholder="Write your comment here..."></textarea>
            <button onclick="addComment()">Post Comment</button>
        </div>

        <!-- Comment Section -->
        <div class="comment__container opened" id="first-comment">
            <div class="comment__card">
                <h3 class="comment__title">User's Comment</h3>
                <p>Example comment content goes here.</p>
                <div class="comment__card-footer">
                    <div>Likes 123</div>
                    <div>Disliked 23</div>
                    <div class="show-replies" onclick="toggleReplyForm('first-comment')">Reply 2</div>
                </div>
            </div>

            <!-- Reply input form -->
            <div class="reply-form" id="reply-form-first-comment">
                <textarea placeholder="Write your reply..."></textarea>
                <button onclick="addReply('first-comment')">Post Reply</button>
            </div>
        </div>
    </div>

    <script src="js/comment.js"></script>    
</body>
</html>
