<?php
include 'config.php';
session_start();

// Cek jika user sudah login
if (!isset($_SESSION['user_name'])) {
    header('location:user_page.php');
    exit();
}

if (isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];
    $user_name = $_SESSION['user_name'];

    // Cek apakah buku ada di rak pengguna
    $check_query = "SELECT * FROM shelves WHERE id = :book_id AND username = :user_name";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $check_stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
    $check_stmt->execute();

    if ($check_stmt->rowCount() > 0) {
        // Hapus buku dari rak
        $delete_query = "DELETE FROM shelves WHERE id = :book_id AND username = :user_name";
        $delete_stmt = $conn->prepare($delete_query);
        $delete_stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
        $delete_stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
        $delete_result = $delete_stmt->execute();

        if ($delete_result) {
            // Redirect ke halaman profil setelah penghapusan
            header('location:profile.php'); // Atau halaman yang sesuai
            exit();
        } else {
            echo "Error deleting book from shelves.";
        }
    } else {
        echo "Book not found or you're not authorized to delete this book.";
    }
}
?>
