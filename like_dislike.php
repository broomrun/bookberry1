<?php
include 'config.php';

$response = array();

if(isset($_POST['action']) && isset($_POST['comment_id'])) {
    $action = $_POST['action'];
    $comment_id = $_POST['comment_id'];

    if($action == 'like') {
        // Increment like count
        $query = "UPDATE comments SET likes = likes + 1 WHERE comment_id = '$comment_id'";
        mysqli_query($conn, $query);

        // Fetch updated like count
        $query = "SELECT likes FROM comments WHERE comment_id = '$comment_id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        $response['likes'] = $row['likes'];
    } elseif($action == 'dislike') {
        // Increment dislike count
        $query = "UPDATE comments SET dislikes = dislikes + 1 WHERE comment_id = '$comment_id'";
        mysqli_query($conn, $query);

        // Fetch updated dislike count
        $query = "SELECT dislikes FROM comments WHERE comment_id = '$comment_id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        $response['dislikes'] = $row['dislikes'];
    }

    echo json_encode($response); // Return the new counts
}
?>
