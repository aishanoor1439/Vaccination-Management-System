<?php
include("connection.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VMS - Register</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<section class="vh-100">
  <div class="container h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">

      <!-- Image Section -->
      <div class="col-md-6">
        <img src="./assets/images/login_vector.jpg" class="img-fluid" alt="Register">
      </div>

      <!-- Form Section -->
      <div class="col-md-6">
        <h3 style="color: #6F42C1;">Register Your Child</h3>
        <form method="post">
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
          </div>
          <button type="submit" name="btn_register" class="btn btn-primary" style="background-color: #6F42C1;">Register</button>
          <p class="mt-3"><a href="login.php">Already have an account? Login here.</a></p>
        </form>

        <?php

        if (isset($_POST['btn_register'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (!empty($name) && !empty($email) && !empty($password)) {
                $query = "INSERT INTO tbl_child (name, email, password) VALUES ('$name', '$email', '$password')";
                $result = mysqli_query($connection, $query);

                if ($result) {
                    echo "<script>
                        Swal.fire({
                          title: 'Registration Successful',
                          icon: 'success'
                        }).then(() => {
                          window.location.href = 'login.php';
                        });
                    </script>";
                } else {
                    echo "<script>
                        Swal.fire({
                          title: 'Registration Failed',
                          text: 'Please try again.',
                          icon: 'error'
                        });
                    </script>";
                }
            }
        }
        ?>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="text-center mt-5" style="background-color: #6F42C1; color: white; padding: 10px;">
    <p>Copyright © 2024. All rights reserved.</p>
  </footer>
</section>
</body>
</html>
