<?php
session_start();
include "config.php";

$query = "SELECT * FROM comments WHERE parent_comment_id = '0' ORDER BY comment_id DESC";
$result = mysqli_query($conn, $query);
$output = '';

while ($row = mysqli_fetch_array($result)) {
    // Get the comment sender's name
    $comment_sender_name = $row["comment_sender_name"];

    // Query to get the profile image of the comment sender
    $image_query = "SELECT image FROM user_form WHERE name = '$comment_sender_name'";
    $image_result = mysqli_query($conn, $image_query);

    // Default image if the user does not have a profile image
    $profile_image = 'default.jpg';

    if ($image_result && mysqli_num_rows($image_result) > 0) {
        $image_row = mysqli_fetch_assoc($image_result);
        // Use the image from the database or default if not found
        $profile_image = $image_row['image'] ? 'uploaded_profile_images/' . $image_row['image'] : 'default.jpg';
    }

    $profile_image_path = $profile_image . '?t=' . time(); // Add unique parameter to prevent cache issues

    // Display the comment with the profile image
    $output .= '
    <div class="panel panel-default">
        <div class="panel-heading">
            <img src="' . $profile_image_path . '" alt="Profile Image" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">
            By <b>' . $comment_sender_name . '</b> on <i>' . $row["date"] . '</i>
        </div>
        <div class="panel-body">' . $row["comment"] . '</div>
        <div class="panel-footer" align="right">
            <button type="button" class="btn btn-primary reply" id="' . $row["comment_id"] . '">Reply</button>
            <button type="button" class="btn btn-success like" data-id="' . $row["comment_id"] . '">Like (' . $row["likes"] . ')</button>
            <button type="button" class="btn btn-danger dislike" data-id="' . $row["comment_id"] . '">Dislike (' . $row["dislikes"] . ')</button>
        </div>
    </div>';
    
    // Get replies for the current comment
    $output .= get_reply_comment($conn, $row["comment_id"]);
}

echo $output;

function get_reply_comment($conn, $parent_id = 0, $marginleft = 0)
{
    $query = "SELECT * FROM comments WHERE parent_comment_id = '$parent_id'";
    $result = mysqli_query($conn, $query);
    $output = '';

    if ($parent_id == 0) {
        $marginleft = 0;
    } else {
        $marginleft = $marginleft + 48;
    }

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            // Get the comment sender's name for replies
            $comment_sender_name = $row["comment_sender_name"];

            // Query to get the profile image of the comment sender for replies
            $image_query = "SELECT image FROM user_form WHERE name = '$comment_sender_name'";
            $image_result = mysqli_query($conn, $image_query);

            $profile_image = 'default.jpg'; // Default image for replies

            if ($image_result && mysqli_num_rows($image_result) > 0) {
                $image_row = mysqli_fetch_assoc($image_result);
                // Use the image from the database or default if not found
                $profile_image = $image_row['image'] ? 'uploaded_profile_images/' . $image_row['image'] : 'default.jpg';
            }

            $profile_image_path = $profile_image . '?t=' . time(); // Add unique parameter to prevent cache issues

            // Display the reply with the profile image
            $output .= '
            <div class="panel panel-default" style="margin-left:' . $marginleft . 'px">
                <div class="panel-heading">
                    <img src="' . $profile_image_path . '" alt="Profile Image" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">
                    By <b>' . $comment_sender_name . '</b> on <i>' . $row["date"] . '</i>
                </div>
                <div class="panel-body">' . $row["comment"] . '</div>
                <div class="panel-footer" align="right">
                    <button type="button" class="btn btn-primary reply" id="' . $row["comment_id"] . '">Reply</button>
                </div>
            </div>';
            
            // Recursive call to get replies for the current reply
            $output .= get_reply_comment($conn, $row["comment_id"], $marginleft);
        }
    }
    return $output;
}
?>
