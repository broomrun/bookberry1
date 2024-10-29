<?php
include 'config.php';
session_start();

$user_name = $_SESSION['user_name'];

if (!isset($user_name)) {
    header('location:login.php');
    exit();
}

$message = [];

// Initialize $user_data
$user_data = null;

// Fetch user data from the database
$query = mysqli_query($conn, "SELECT * FROM `user_form` WHERE name = '$user_name'") or die('query failed');

if (mysqli_num_rows($query) > 0) {
    $user_data = mysqli_fetch_assoc($query);
} else {
    $message[] = 'User data not found.';
}

// Check if form is submitted
if (isset($_POST['update_profile'])) {
    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

    // Update name and email
    $update_query = mysqli_query($conn, "UPDATE `user_form` SET name = '$update_name', email = '$update_email' WHERE name = '$user_name'") or die('query failed');

    // Handle password update
    $old_pass = isset($_POST['old_pass']) ? trim($_POST['old_pass']) : '';
    $new_pass = isset($_POST['new_pass']) ? trim($_POST['new_pass']) : '';
    $confirm_pass = isset($_POST['confirm_pass']) ? trim($_POST['confirm_pass']) : '';

    if (!empty($new_pass) || !empty($confirm_pass)) {
        $result = mysqli_query($conn, "SELECT password FROM `user_form` WHERE name = '$user_name'") or die('query failed');
        $row = mysqli_fetch_assoc($result);
    
        if ($row) {
            // Verify old password
            if (!password_verify($old_pass, $row['password'])) {
                $message[] = 'Old password not matched!';
            } elseif ($new_pass !== $confirm_pass) {
                $message[] = 'Confirm password not matched!';
            } else {
                // Hash new password and update in database
                $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);
                mysqli_query($conn, "UPDATE `user_form` SET password = '$hashed_password' WHERE name = '$user_name'") or die('query failed');
                $message[] = 'Password updated successfully!';
            }
        } else {
            $message[] = 'User not found!';
        }
    } else {
        $message[] = 'New password and confirmation are required to change the password.';
    }

    // Handle image update
    if (isset($_FILES['update_image']) && $_FILES['update_image']['error'] == UPLOAD_ERR_OK) {
        $update_image = $_FILES['update_image']['name'];
        $update_image_size = $_FILES['update_image']['size'];
        $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
        $update_image_folder = 'uploaded_img/' . basename($update_image);

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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .alert {
            margin: 10px 0;
            padding: 10px;
            background-color: #e0f7fa;
            color: #00695c;
            border-radius: 5px;
        }
        .content-section {
            display: block;
        }
        .navigation {
            display: flex;
        }
        .navigation a {
            color: #1a2a5e;
            text-decoration: none;
            font-weight: 500;
            letter-spacing: 1px;
            padding: 2px 15px;
            border-radius: 20px;
            transition: 0.3s background;
            margin-right: 30px;
        }
        .navigation a:hover {
            background: #1a2a5e;
            color: #FFFFFF;
        }
        .navbar {
            background-color: #1e2a5e; 
            width: 100%; 
            height: 70px;
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
        }
        h1, h2, h3, h4, h5, h6, p {
            color: #1e2a5e;
            font-family: 'Poppins', sans-serif;
        }
        header .logo {
            color: #1a2a5e;
            font-size: 30px;
            text-decoration: none;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 1px;
            margin: 0 auto;
        }
    </style>
</head>
<body class="bg-gray-100 font-roboto">
    <header>
        <h2><a href="#" class="logo">logo</a></h2>
        <nav class="navigation">
            <a href="home.php">Home</a>
            <a href="about.php">About</a>
            <a href="update_profile.php">Profile</a>
        </nav>
    </header>
    <div class="container mt-20">



        <?php
        if (!empty($message)) {
            foreach ($message as $msg) {
                echo '<div class="alert alert-info">' . htmlspecialchars($msg) . '</div>';
            }
        }
        ?>

        <!-- Update Profile Form -->
        <div class="w-3/4 bg-white p-8 mt-6">
            <!-- Profile Info Section -->
            <div id="profile-info-section" class="content-section p-8">
                <h2 class="text-2xl font-bold mb-6">Account Information</h2>
                <div class="flex flex-col items-center mb-6">
                    <div class="w-24 h-24 bg-gray-300 rounded-full flex items-center justify-center mb-2">
                        <img src="uploaded_img/<?php echo htmlspecialchars($user_data['image'] ?? 'default_image.jpg'); ?>" alt="Profile Image" class="w-full h-full rounded-full object-cover">
                    </div>
                    <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($user_data['name'] ?? 'No Name'); ?></h3>
                    <p class="text-gray-600"><?php echo htmlspecialchars($user_data['email'] ?? 'No Email'); ?></p>
                    <button onclick="showPhotoModal()" class="mt-2 text-pink-600 flex items-center">
                        <i class="fas fa-camera mr-2"></i>
                        <input type="file" id="update_image" name="update_image">
                        <div>
                </div>
                    </button>
                </div>
            </div>
        </div>
            <h3 class="text-xl font-bold mb-4">Profile Information</h3>
            <form method="POST" enctype="multipart/form-data" class="space-y-4">
                <div class="flex flex-col md:flex-row md:space-x-4">
                    <div class="w-full md:w-1/2">
                        <label class="block text-gray-700" for="update_name">Name:</label>
                        <input type="text" id="update_name" name="update_name" class="w-full p-2 border border-gray-300 rounded" value="<?php echo htmlspecialchars($user_data['name'] ?? ''); ?>" required>
                    </div>
                    <div class="w-full md:w-1/2">
                        <label class="block text-gray-700" for="update_email">Email:</label>
                        <input type="email" id="update_email" name="update_email" class="w-full p-2 border border-gray-300 rounded" value="<?php echo htmlspecialchars($user_data['email'] ?? ''); ?>" required>
                    </div>
                </div>
                <div>
                    <label for="old_pass" class="block text-gray-700">Old Password:</label>
                    <input type="password" id="old_pass" name="old_pass" class="w-full p-2 border border-gray-300 rounded">
                </div>
                <div>
                    <label for="new_pass" class="block text-gray-700">New Password:</label>
                    <input type="password" id="new_pass" name="new_pass" class="w-full p-2 border border-gray-300 rounded">
                </div>
                <div>
                    <label for="confirm_pass" class="block text-gray-700">Confirm New Password:</label>
                    <input type="password" id="confirm_pass" name="confirm_pass" class="w-full p-2 border border-gray-300 rounded">
                </div>
                <button type="submit" name="update_profile" class="bg-blue-500 text-white px-4 py-2 rounded">Update Profile</button>
            </form>
        </div>
    </div>
</body>
</html>
