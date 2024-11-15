<?php
include 'config.php';
session_start();

$user_name = $_SESSION['user_name'];

if (!isset($user_name)) {
    header('location:login.php');
    exit();
}

$message = [];

// Fetch user data and profile image from the database
$query = mysqli_query($conn, "SELECT * FROM user_form WHERE name = '$user_name'") or die('Query failed');
if (mysqli_num_rows($query) > 0) {
    $user_data = mysqli_fetch_assoc($query);
    $profile_image = !empty($user_data['image']) ? 'uploaded_profile_images/' . $user_data['image'] : 'uploaded_profile_images/default_image.jpg';
} else {
    $message[] = 'User data not found.';
}

if (isset($_POST['update_profile'])) {
    // Update name and email if needed
    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
    mysqli_query($conn, "UPDATE user_form SET name = '$update_name', email = '$update_email' WHERE name = '$user_name'") or die('Update failed');
    
    // Check if a new profile image is uploaded
    if (isset($_FILES['update_image']) && $_FILES['update_image']['error'] == 0) {
        $image_name = $_FILES['update_image']['name'];
        $image_tmp_name = $_FILES['update_image']['tmp_name'];
        $image_folder = 'uploaded_profile_images/' . $image_name;

        // Move uploaded image to the specified folder and update in database
        if (move_uploaded_file($image_tmp_name, $image_folder)) {
            mysqli_query($conn, "UPDATE user_form SET image = '$image_name' WHERE name = '$user_name'") or die('Image update failed');
            $message[] = "Profile image updated successfully!";
            $profile_image = $image_folder;  // Update variable to show new image instantly
        } else {
            $message[] = "Failed to upload image.";
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
    font-family: 'Poppins', sans-serif;
    background-color: #1e2a5e;
    margin: 0;
    padding-top: 90px;
}

header {
    position: fixed; /* Mengubah posisi menjadi tetap */
    top: 0; /* Menetapkan posisi di bagian atas */
    width: 100%; /* Memastikan lebar penuh */
    padding: 15px 5%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #1e2a5e; /* Pastikan warna latar belakang untuk kontras */
    z-index: 1000; /* Menetapkan z-index untuk memastikan berada di atas konten lainnya */
}

header .logo {
    color: #fff;
    font-size: 30px;
    text-decoration: none;
    text-transform: uppercase;
    font-weight: 800;
    letter-spacing: 1px;
    margin: 0 auto;
}

.logo-image {
    max-width: 170px; /* Maksimal lebar gambar */
    height: auto; /* Menjaga proporsi gambar */
    display: block; /* Memastikan gambar tampil sebagai block-level element */
}
 

.navigation {
    display: flex;
}

.navigation a {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    letter-spacing: 1px;
    padding: 2px 15px;
    border-radius: 20px;
    transition: 0.3s background;
    margin-right: 30px;
}


.logo img {
    max-height: 50px; /* Adjust as needed for logo size */
    width: auto;
    vertical-align: left; /* Aligns the image with the navigation */
    align-items: left;
    margin-right: auto;
}

.navigation {
    display: flex;
    justify-content: space-between;
}

.navigation a:hover {
    background: #fff;
    color: #1e2a5e;
}


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
<body>
<header>
        <h2>
        <a href="#" class="logo">
        <img src="assets/logowhite.png" alt="Logo" class="logo-image" />
    </a>
</h2>
                <nav class="navigation">
                 <a href="home.php">Home</a>
                <a href="about.php">About</a>
                <a href="update_profile.php">Profile</a>
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
                <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="Profile Image" class="rounded-full w-32 h-32 object-cover">
            </div>
                <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($user_data['name'] ?? 'No Name'); ?></h3>
                <p class="text-gray-600"><?php echo htmlspecialchars($user_data['email'] ?? 'No Email'); ?></p>
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
                <button type="submit" name="update_profile"class="w-full bg-[#1e2a5e] text-white px-4 py-2 rounded-[50px] hover:bg-[#FFFFFF] hover:text-[#1e2a5e] hover:border border-[#1e2a5e] transition duration-200">Update Profile</button>
            </form>
        </div>
    </div>
</body>
</html>



