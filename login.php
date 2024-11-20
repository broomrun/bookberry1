<?php
include 'config.php';
session_start();

$emailValue = ''; // Untuk menyimpan email input

if (isset($_POST['submit'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];
    $emailValue = $email; // Menyimpan email saat form dikirim
    
    // Cek email di database
    $select = "SELECT * FROM user_form WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_array($result);

        // Verifikasi apakah password cocok
        if (password_verify($pass, $row['password'])) {
            
            // Saring data user, tidak perlu cek user_type
            $_SESSION['user_name'] = $row['name'];
            header('location:home.php'); // Redirect ke halaman home setelah login berhasil
            exit; // Pastikan proses berhenti setelah redirect

        } else {
            $error = 'Incorrect password!';
        }

    } else {
        $error = 'Incorrect email or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    /* Custom Modal Styling */
    .modal-content {
      border-radius: 15px;
      border: none;
    }
    .modal-header {
      border-bottom: none;
      text-align: center;
    }
    .modal-header h5 {
      font-weight: bold;
      color: #1a1f71; /* Dark Blue Color */
    }
    .modal-body {
      padding: 2rem;
    }
    .form-control:focus {
      box-shadow: none;
      border-color: #1a1f71;
    }
    .btn-primary {
      background-color: #1a1f71;
      border: none;
      border-radius: 5px;
    }
    .btn-primary:hover {
      background-color: #141a5a;
    }
    .form-label {
      font-weight: 500;
    }
    .form-text a {
      color: #1a1f71;
      text-decoration: underline;
    }
    
  </style>
</head>
<body>

  <!-- Login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      <div class="modal-header">
            <h5 class="modal-title mx-auto" id="loginModalLabel">Login</h5>
        </div>
        <div class="modal-body">
          <form id="loginForm" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($emailValue); ?>" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                  <i class="bi bi-eye"></i> <!-- Initial Icon: Open Eye -->
                </button>
              </div>
            </div>
            <button type="submit" class="btn btn-primary w-100" name="submit">Login</button>
            <div class="form-text text-center mt-3">
              Don't have an account? <a href="daftar.php">Sign up now</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap Bundle with Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JavaScript for Password Visibility Toggle -->
  <script>
    // Show the modal as soon as the page loads
    window.onload = function() {
      var myModal = new bootstrap.Modal(document.getElementById('loginModal'));
      myModal.show();
    };

    // Select the toggle button and password input
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    // Add event listener for toggle button
    togglePassword.addEventListener('click', function () {
      // Check the current type of the password field
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);

      // Toggle the icon
      this.innerHTML = type === 'password'
        ? '<i class="bi bi-eye-slash"></i>' // Open eye when password is hidden
        : '<i class="bi bi-eye"></i>'; // Closed eye when password is visible
    });
  </script>

</body>
</html>
