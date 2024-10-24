<?php
include 'config.php';
session_start();

$user_name = $_SESSION['user_name'];

if (!isset($user_name)) {
    header('location:login.php');
    exit();
}

$message = []; // Initialize the message array

if (isset($_POST['update_profile'])) {

    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

    // Update name and email
    mysqli_query($conn, "UPDATE `user_form` SET name = '$update_name', email = '$update_email' WHERE name = '$user_name'") or die('query failed');

    $old_pass = $_POST['old_pass'];
    $update_pass = mysqli_real_escape_string($conn, $_POST['update_pass']);
    $new_pass = mysqli_real_escape_string($conn, $_POST['new_pass']);
    $confirm_pass = mysqli_real_escape_string($conn, $_POST['confirm_pass']);

    // Update password if provided
    if (!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)) {
        $old_pass_hashed = password_hash($old_pass, PASSWORD_DEFAULT);
        $result = mysqli_query($conn, "SELECT password FROM `user_form` WHERE name = '$user_name'") or die('query failed');
        $row = mysqli_fetch_assoc($result);

        if (!password_verify($old_pass, $row['password'])) {
            $message[] = 'Old password not matched!';
        } elseif ($new_pass != $confirm_pass) {
            $message[] = 'Confirm password not matched!';
        } else {
            $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE `user_form` SET password = '$hashed_password' WHERE name = '$user_name'") or die('query failed');
            $message[] = 'Password updated successfully!';
        }
    }

    // Update image
    $update_image = $_FILES['update_image']['name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_folder = 'uploaded_img/' . $update_image;

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $message[] = 'Image is too large';
        } else {
            $image_update_query = mysqli_query($conn, "UPDATE `user_form` SET image = '$update_image' WHERE name = '$user_name'") or die('query failed');
            if ($image_update_query) {
                move_uploaded_file($update_image_tmp_name, $update_image_folder);
                $message[] = 'Image updated successfully!';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="stylee.css">
</head>
<body>
<div class="container">
    <h2>Update Profile</h2>

    <?php
    if (!empty($message)) {
        foreach ($message as $msg) {
            echo '<div class="alert alert-info">' . $msg . '</div>';
        }
    }
    ?>

    <form method="POST" enctype="multipart/form-data">
        <div>
            <label for="update_name">Name:</label>
            <input type="text" id="update_name" name="update_name" required>
        </div>
        <div>
            <label for="update_email">Email:</label>
            <input type="email" id="update_email" name="update_email" required>
        </div>
        <div>
            <label for="old_pass">Old Password:</label>
            <input type="password" id="old_pass" name="old_pass">
        </div>
        <div>
            <label for="update_pass">New Password:</label>
            <input type="password" id="update_pass" name="update_pass">
        </div>
        <div>
            <label for="confirm_pass">Confirm New Password:</label>
            <input type="password" id="confirm_pass" name="confirm_pass">
        </div>
        <div>
            <label for="update_image">Update Image:</label>
            <input type="file" id="update_image" name="update_image" accept="image/*">
        </div>
        <button type="submit" name="update_profile">Update Profile</button>
    </form>
</div>
</body>
</html>
