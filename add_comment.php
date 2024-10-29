<?php
session_start();
include "config.php"; // Ensure this file sets up $conn

$error = '';

// Validate comment name
if (empty($_POST["comment_name"])) {
    $error .= '<p class="text-danger">Name is required</p>';
} else {
    $comment_name = htmlspecialchars($_POST["comment_name"]);
}

// Validate comment content
if (empty($_POST["comment_content"])) {
    $error .= '<p class="text-danger">Comment is required</p>';
} else {
    $comment_content = htmlspecialchars($_POST["comment_content"]);
}

// If no errors, insert the comment
if ($error == '') {
    $query = "
    INSERT INTO comments 
    (parent_comment_id, comment, comment_sender_name) 
    VALUES (?, ?, ?)
    ";
    
    // Prepare and execute the statement
    $statement = $conn->prepare($query);
    $statement->bind_param("iss", $_POST["comment_id"], $comment_content, $comment_name);
    
    if ($statement->execute()) {
        // Return success message
        $error = '<label class="text-success">Comment Added</label>';
    } else {
        $error = '<p class="text-danger">Comment could not be added</p>';
    }
}

// Return the error status as JSON
$data = [
    'error' => $error
];

echo json_encode($data);
?>
