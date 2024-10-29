<?php
session_start();
include "config.php"; // Ensure this file sets up $conn

$query = "
SELECT * FROM comments 
WHERE parent_comment_id = '0' 
ORDER BY comment_id DESC
";

$statement = $conn->prepare($query);
$statement->execute();
$result = $statement->get_result();
$output = '';

while ($row = $result->fetch_assoc()) {
    $output .= '
    <div class="panel panel-default">
        <div class="panel-heading">By <b>'.$row["comment_sender_name"].'</b> on <i>'.$row["date"].'</i></div>
        <div class="panel-body">'.$row["comment"].'</div>
        <div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" id="'.$row["comment_id"].'">Reply</button></div>
    </div>
    ';
    $output .= get_reply_comment($conn, $row["comment_id"]);
}

echo $output;

function get_reply_comment($conn, $parent_id = 0, $marginleft = 0)
{
    $query = "SELECT * FROM comments WHERE parent_comment_id = ?";
    $statement = $conn->prepare($query);
    $statement->bind_param("i", $parent_id);
    $statement->execute();
    $result = $statement->get_result();
    $output = '';

    if ($parent_id != 0) {
        $marginleft += 48;
    }

    while ($row = $result->fetch_assoc()) {
        $output .= '
        <div class="panel panel-default" style="margin-left:'.$marginleft.'px">
            <div class="panel-heading">By <b>'.$row["comment_sender_name"].'</b> on <i>'.$row["date"].'</i></div>
            <div class="panel-body">'.$row["comment"].'</div>
            <div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" id="'.$row["comment_id"].'">Reply</button></div>
        </div>
        ';
        $output .= get_reply_comment($conn, $row["comment_id"], $marginleft);
    }

    return $output;
}
?>
