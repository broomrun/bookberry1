<?php
session_start();
include "config.php";

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    echo "User not logged in";
    exit;
}

$user_name = $_SESSION['user_name'];
$book_title = $_POST['book_title'];
$is_bookmarked = $_POST['is_bookmarked'];

// Update the bookmark status in the database
$bookmark_query = "INSERT INTO bookmarks (user_name, book_title, is_bookmarked) 
                   VALUES ('$user_name', '$book_title', '$is_bookmarked')
                   ON DUPLICATE KEY UPDATE is_bookmarked = '$is_bookmarked'";

if (mysqli_query($conn, $bookmark_query)) {
    echo "Bookmark state updated successfully.";
} else {
    echo "Error updating bookmark: " . mysqli_error($conn);
}
?>
