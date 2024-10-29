<?php
session_start();
include 'config.php';

$query = "SELECT * FROM comments WHERE parent_comment_id = '0' ORDER BY comment_id DESC";
$result = mysqli_query($conn, $query);
$output = '';

while($row = mysqli_fetch_array($result))
{
    $output .= '
    <div class="panel panel-default">
        <div class="panel-heading">By <b>'.$row["comment_sender_name"].'</b> on <i>'.$row["date"].'</i></div>
        <div class="panel-body">'.$row["comment"].'</div>
        <div class="panel-footer" align="right">
            <button type="button" class="btn btn-primary reply" id="'.$row["comment_id"].'">Reply</button>
        </div>
    </div>
    ';
    $output .= get_reply_comment($conn, $row["comment_id"]);
}

echo $output;

function get_reply_comment($conn, $parent_id = 0, $marginleft = 0)
{
    $query = "SELECT * FROM comments WHERE parent_comment_id = '".$parent_id."'";
    $result = mysqli_query($conn, $query);
    $output = '';
    
    if($parent_id == 0)
    {
        $marginleft = 0;
    }
    else
    {
        $marginleft = $marginleft + 48;
    }
    
    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_array($result))
        {
            $output .= '
            <div class="panel panel-default" style="margin-left:'.$marginleft.'px">
                <div class="panel-heading">By <b>'.$row["comment_sender_name"].'</b> on <i>'.$row["date"].'</i></div>
                <div class="panel-body">'.$row["comment"].'</div>
                <div class="panel-footer" align="right">
                    <button type="button" class="btn btn-primary reply" id="'.$row["comment_id"].'">Reply</button>
                </div>
            </div>
            ';
            $output .= get_reply_comment($conn, $row["comment_id"], $marginleft);
        }
    }
    return $output;
}
?>