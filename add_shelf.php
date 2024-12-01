<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_name'])) {
    header('Location: user_page.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_SESSION['user_name'];
    $book_title = mysqli_real_escape_string($conn, $_POST['book_title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $book_image = '';

    if (!empty($_FILES['book_image']['name'])) {
        $file_name = $_FILES['book_image']['name'];
        $file_tmp = $_FILES['book_image']['tmp_name'];
        $file_dest = "uploaded_books/" . $file_name;

        if (move_uploaded_file($file_tmp, $file_dest)) {
            $book_image = $file_name;
        }
    }

    $query = "INSERT INTO shelves (username, book_title, book_image, description) 
              VALUES ('$username', '$book_title', '$book_image', '$description')";
    if (mysqli_query($conn, $query)) {
        header('Location: profile.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
