<?php
include("connection.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VMS</title>
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">

      <!-- Vector Image -->
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="login_vector.jpg" class="img-fluid" alt="Sample image">
      </div>

      <!-- Form -->
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form method="post">
          <div class="login-container">
            <h1 class="login-title mb-5" id="greeting" style="color: #6F42C1">Ready to Manage?</h1>
          </div>
          <div class="form-outline mb-4">
            <label class="form-label" for="form3Example3">Email address</label>
            <input type="email" id="form3Example3" class="form-control form-control-lg" name="email" required />
          </div>
          <div class="form-outline mb-3">
            <label class="form-label" for="form3Example4">Password</label>
            <input type="password" id="form3Example4" class="form-control form-control-lg" name="password" required />
          </div>
          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" value="login" name="btn_login" class="btn btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem; background-color: #6F42C1; color:white;">Login</button>
          </div>
        </form>

        <?php
        if (isset($_POST['btn_login'])) {
            // retrieve user input
            $email = mysqli_real_escape_string($connection, $_POST['email']);
            $password = mysqli_real_escape_string($connection, $_POST['password']);

            // query to check user credentials
            $query = "SELECT * FROM tbl_hospital WHERE email = '$email' AND password = '$password'";
            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['hospital_session'] = $row['id'];
                echo "<script>
                    window.location.href = 'index.php';
                </script>";
            } else {
                echo "<script>
                Swal.fire({
                    title: 'No Record Found',
                    icon: 'warning',
                })
                </script>";
            }
        }
        ?>

      </div>
    </div>
  </div>

  <!-- Copyright -->
  <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5" style="background-color: #6F42C1; color: white;">
    <div class="text-white mb-3 mb-md-0">
      Copyright © 2024. All rights reserved.
    </div>
  </div>

</section>
</body>
</html>
