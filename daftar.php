<?php
session_start();
include "config.php";

if (isset($_POST['submit'])) {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $pass = $_POST['password'];
  $cpass = $_POST['confirmPassword'];

  $errors = [];

  // Cek apakah email sudah digunakan
  $select = "SELECT * FROM user_form WHERE email = '$email'";
  $result = mysqli_query($conn, $select);

  if (mysqli_num_rows($result) > 0) {
    $errors[] = 'User already exists!';
  } else {
    if ($pass != $cpass) {
      $errors[] = 'Passwords do not match!';
    } else {
      // Hash password
      $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

      // Insert user ke database
      $insert = "INSERT INTO user_form(name, email, password) 
                       VALUES('$name', '$email', '$hashed_password')";

      if (mysqli_query($conn, $insert)) {
        header('location:login.php'); // Redirect ke halaman login
      } else {
        $errors[] = 'Failed to register user!';
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
  <title>BookBerry</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .modal-content {
      border-radius: 15px;
    }

    .modal-header {
      border-bottom: none;
    }

    .modal-header h5 {
      font-weight: bold;
      color: #1a1f71;
      /* Dark Blue Color */
    }

    .form-control {
      border-radius: 8px;
    }

    .btn-primary {
      background-color: #001a57;
      border: none;
      border-radius: 8px;
    }

    .btn-primary:hover {
      background-color: #002b87;
    }

    .modal-footer {
      justify-content: center;
    }

    .form-label {
      font-weight: 500;
    }

    .link-primary {
      text-decoration: none;
    }

    .link-primary:hover {
      text-decoration: underline;
    }

    .form-text a {
      color: #1a1f71;
      text-decoration: underline;
    }
  </style>
</head>

<body>


  <!-- Modal -->
  <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title mx-auto" id="signupModalLabel">Sign Up</h5>
        </div>
        <div class="modal-body">
          <form method="POST" action="" onsubmit="return validateForm()">
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', this)">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>
            <div class="mb-3">
              <label for="confirmPassword" class="form-label">Confirm Password</label>
              <div class="input-group">
                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Confirm your password" required>
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmPassword', this)">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>
            <div class="d-grid">
              <button type="submit" name="submit" class="btn btn-primary">Sign Up</button>
            </div>
          </form>
          <div class="form-text text-center mt-3">
            <p class="mb-0">Already have an account? <a href="login.php" class="link-primary">Login now</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function togglePassword(fieldId, button) {
      const field = document.getElementById(fieldId);
      const icon = button.querySelector("i");
      if (field.type === "password") {
        field.type = "text";
        icon.classList.add("bi-eye");
        icon.classList.remove("bi-eye-slash");
      } else {
        field.type = "password";
        icon.classList.add("bi-eye-slash");
        icon.classList.remove("bi-eye");
      }
    }

    function validateForm() {
      const pass = document.getElementById("password").value;
      const cpass = document.getElementById("confirmPassword").value;
      if (pass !== cpass) {
        alert("Passwords do not match!");
        return false;
      }
      return true;
    }

    window.onload = function() {
      var signupModal = new bootstrap.Modal(document.getElementById('signupModal'), {
        backdrop: 'static',
        keyboard: false
      });
      signupModal.show(); // Menampilkan modal secara otomatis
    };
  </script>
</body>

</html>