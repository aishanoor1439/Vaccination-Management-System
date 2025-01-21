<?php
include("connection.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VMS - Login</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">

            <!-- Image section -->
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="./assets/images/login_vector.jpg" class="img-fluid" alt="Login Illustration">
            </div>

            <!-- Form section -->
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <form method="post">
                    <h3 class="login-title mb-5" style="color: #6F42C1;">Empowering Parents, Ensuring Care</h3>
                    <div class="form-outline mb-3">
                        <label class="form-label" for="email">Email address</label>
                        <input type="email" id="email" class="form-control form-control-lg" name="email" required />
                    </div>
                    <div class="form-outline mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" class="form-control form-control-lg" name="password" required />
                    </div>
                    <div class="text-center text-lg-start mt-3 pt-2">
                        <button type="submit" name="btn_login" class="btn btn-lg" style="background-color: #6F42C1; color: white;">Login</button>
                    </div>
                    <div class="text-center text-lg-start pt-2">
                        <a href="register.php">Don't have an account? Register</a>
                    </div>
                </form>

                <?php
                if (isset($_POST['btn_login'])) {
                    $email = mysqli_real_escape_string($connection, $_POST['email']);
                    $password = mysqli_real_escape_string($connection, $_POST['password']);
                    $query = "SELECT * FROM tbl_child WHERE email = '$email' AND password = '$password'";
                    $result = mysqli_query($connection, $query);
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $_SESSION['child_session'] = $row['id'];
                        $_SESSION['childName_session'] = $row['name'];
                        echo "<script>window.location.href = 'index.php';</script>";
                    } else {
                        echo "<script>
                        Swal.fire({
                            title: 'No Record Found',
                            icon: 'warning',
                        });
                        </script>";
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5" style="background-color: #6F42C1; color: white;">
        <div>Copyright © 2024. All rights reserved.</div>
    </div>
</section>
</body>
</html>
