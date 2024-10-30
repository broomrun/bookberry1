<?php
session_start();
include 'config.php';

$error = '';
$comment_name = '';
$comment_content = '';

if(isset($_SESSION['user_name'])) {
    if(empty($_POST["comment_content"]))
    {
        $error .= '<p class="text-danger">Comment is required</p>';
    }
    else
    {
        $comment_content = $_POST["comment_content"];
        $comment_name = $_SESSION['user_name']; // Mengambil nama dari session
        $comment_id = $_POST["comment_id"];
        
        $query = "INSERT INTO comments(parent_comment_id, comment, comment_sender_name) 
                 VALUES ('$comment_id', '$comment_content', '$comment_name')";
        mysqli_query($conn, $query);
        $error = '<p class="text-success">Comment Added</p>';
    }
    
    $data = array(
        'error'  => $error
    );
    
    echo json_encode($data);
}