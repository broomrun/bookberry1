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
$query = mysqli_query($conn, "SELECT * FROM user_form WHERE name = '$user_name'") or die('Query failed');

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
    $update_query = mysqli_query($conn, "UPDATE user_form SET name = '$update_name', email = '$update_email' WHERE name = '$user_name'") or die('Update query failed');

    // Update the session variable if name is successfully changed
    if ($update_query) {
        $_SESSION['user_name'] = $update_name;
        $user_name = $update_name;  // Update local variable too
        $message[] = "Profile updated successfully!";
    }

    // Debug output for session
    if (!isset($_SESSION['user_name'])) {
        echo "User name not set in session.";
    } else {
        echo "Current session user: " . htmlspecialchars($_SESSION['user_name']);
    }

    // Re-fetch updated user data for verification
    $query = mysqli_query($conn, "SELECT * FROM user_form WHERE name = '$user_name'") or die('Query failed');
    if (mysqli_num_rows($query) == 0) {
        echo 'User not found after update.';
    } else {
        $user_data = mysqli_fetch_assoc($query);
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="style/styles.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif;  background-color: #1e2a5e}
        .alert { margin: 10px 0; padding: 10px; background-color: #e0f7fa; color: #00695c; border-radius: 50px; }
        .navbar { background-color: #1e2a5e; width: 100%; height: 70px; position: fixed; top: 0; left: 50%; transform: translateX(-50%); z-index: 1000; }
        header .logo { color: #FFFFFF; font-size: 30px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px; margin: 0 auto; }
        .navigation a { color: #FFFFFF; text-decoration: none; font-weight: 500; padding: 2px 15px; margin-right: 20px; }
        .navigation a:hover { background: #FFFFFF; color: #1e2a5e; border-radius: 50px; }
        .container { margin-top: 100px; }
        .profile-image { width: 100px; height: 100px; border-radius: 50%; }

        /* warna inputan */
            input[type="text"],
            input[type="password"],
            input[type="file"] {
            color: black; 
            border: 1px solid #ccc; 
            padding: 10px; 
            border-radius: 50px; 
            transition: border-color 0.3s; 
        }

        /* Ubah border color */
        input[type="text"]:focus,
        input[type="password"]:focus,
        input[type="file"]:focus {
            border-color: #1e2a5e; 
            outline: none; 
        }
        .toggle-password {
            position: absolute;
            top: 70%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #1E2A5E;
            font-size: 0.7rem;
        }
    </style>
    <script>
        function togglePasswordVisibility(id) {
            const passwordField = document.getElementById(id);
            const eyeIcon = document.getElementById(id + '-eye');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</head>
<body class="bg-white-100">
    <header class="navbar flex justify-between items-center px-10">
        <h2>
            <a href="user_page.php" class="logo">
                <img src="assets/logowhite.png" alt="Logo" class="logo-image" />
            </a>
        </h2>
        <nav class="navigation">
            <a href="home.php">Home</a>
            <a href="about.php">About</a>
            <a href="profile.php">Profile</a>
        </nav>
    </header>

    <div class="container mx-auto">
        <?php foreach ($message as $msg): ?>
            <div class="alert"><?php echo htmlspecialchars($msg); ?></div>
        <?php endforeach; ?>

        <div class="bg-white p-8 shadow-md rounded-[20px]">
            <h2 class="text-2xl font-bold mb-4">Account Information</h2>
            <div class="text-center mb-6">
                <div class="flex justify-center items-center">
                    <img src="uploaded_img/<?php echo htmlspecialchars($user_data['image'] ?? 'default_image.jpg'); ?>" alt="Profile Image" class="profile-image mb-2">
                </div>
                <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($user_data['name'] ?? 'No Name'); ?></h3>
                <p class="text-gray-600 custom-small-text"><?php echo htmlspecialchars($user_data['email'] ?? 'No Email'); ?></p>
            </div>

            <form method="POST" enctype="multipart/form-data" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700" for="update_name">Name:</label>
                        <input type="text" id="update_name" name="update_name" class="w-full" value="<?php echo htmlspecialchars($user_data['name'] ?? ''); ?>" required>
                    </div>
                    <div>
                        <label class="block text-gray-700" for="update_email">Email:</label>
                        <input type="text" id="update_email" name="update_email" class="w-full" value="<?php echo htmlspecialchars($user_data['email'] ?? ''); ?>" required>
                    </div>
                </div>
                
                <div class="relative">
                    <label class="block text-gray-700" for="old_pass">Old Password:</label>
                    <input type="password" id="old_pass" name="old_pass" class="w-full" placeholder="Enter your old password">
                    <i class="fas fa-eye toggle-password" id="old_pass-eye" onclick="togglePasswordVisibility('old_pass')"></i>
                </div>
                <div class="relative">
                    <label for="new_pass" class="block text-gray-700">New Password:</label>
                    <input type="password" id="new_pass" name="new_pass" class="w-full" placeholder="Enter new password">
                    <i class="fas fa-eye toggle-password" id="new_pass-eye" onclick="togglePasswordVisibility('new_pass')"></i>
                </div>
                <div class="relative">
                    <label for="confirm_pass" class="block text-gray-700">Confirm New Password:</label>
                    <input type="password" id="confirm_pass" name="confirm_pass" class="w-full" placeholder="Confirm new password">
                    <i class="fas fa-eye toggle-password" id="confirm_pass-eye" onclick="togglePasswordVisibility('confirm_pass')"></i>
                </div>
                
                <div>
                    <label for="update_image" class="block text-gray-700">Update Profile Picture:</label>
                    <input type="file" id="update_image" name="update_image" class="w-full">
                </div>
                
                <button type="submit" name="update_profile" class="w-full bg-[#1e2a5e] text-white px-4 py-2 rounded-[50px] hover:bg-[#FFFFFF] hover:text-[#1e2a5e] hover:border border-[#1e2a5e] transition duration-200">Update Profile</button>
            </form>
        </div>
    </div>
</body>
</html>

