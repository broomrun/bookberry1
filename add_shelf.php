<?php
session_start();
include "config.php"; // This should contain PostgreSQL connection details

// Periksa apakah pengguna telah login
if (!isset($_SESSION['user_name'])) {
    header('Location: user_page.php');
    exit;
}

$user_name = $_SESSION['user_name'];
$book_title = $conn->quote($_POST['book_title']);
$description = $conn->quote($_POST['description']);
$book_image = $_FILES['book_image']['name'];

// Handle image upload
if ($book_image) {
    $target_dir = "uploaded_books/";
    $target_file = $target_dir . basename($book_image);
    move_uploaded_file($_FILES['book_image']['tmp_name'], $target_file);
}

// Insert the book to the shelf
$shelf_query = "INSERT INTO shelves (username, book_title, description, book_image) 
                VALUES ('$user_name', $book_title, $description, '$book_image')";

if ($conn->exec($shelf_query)) {
    // Redirect back to the shelves page
    header('Location: profile.php'); // Redirect to shelves page after adding
    exit;
} else {
    echo "Error: " . $conn->errorInfo()[2];
}
?>
