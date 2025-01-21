<?php
// Start the session
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['admin_session'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

// Include database connection
include_once('connection.php');

// Fetch cities for dropdown
$query = "SELECT * FROM tbl_city";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin - Add New Hospital</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,900" rel="stylesheet">
    <link href="./assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include_once('include/sidebar.php'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div class="container">
                <div class="row-lg-12">
                    <h1 class="h2 mb-3 mt-3">Add Hospital</h1>
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <select class="form-select" aria-label="Default select example" name="city" required>
                                <option hidden>City</option>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact no</label>
                            <input type="text" class="form-control" id="contact_no" name="contact_no" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="status">
                            <label class="form-check-label" for="exampleCheck1">Activated</label>
                        </div>
                        <button type="submit" class="btn btn-primary" name="btn_add">Add</button>
                    </form>

                    <?php

                    if (isset($_POST['btn_add'])) {
                        $name = mysqli_real_escape_string($connection, $_POST['name']);
                        $city = mysqli_real_escape_string($connection, $_POST['city']);
                        $address = mysqli_real_escape_string($connection, $_POST['address']);
                        $contact_no = mysqli_real_escape_string($connection, $_POST['contact_no']);
                        $email = mysqli_real_escape_string($connection, $_POST['email']);
                        $password = mysqli_real_escape_string($connection, $_POST['password']);
                        $status = isset($_POST['status']) ? "activated" : "deactivated"; // Checkbox value handling

                        $query = "INSERT INTO tbl_hospital(name, cid, address, contact, email, password, status) 
                                  VALUES('$name', '$city', '$address', '$contact_no', '$email', '$password', '$status')";

                        if (mysqli_query($connection, $query)) {
                            echo "
                            <script>
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'New hospital has been added!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });                                   
                            </script>";
                            echo "<script>window.location.href = 'hospitals.php';</script>";
                        } else {
                            echo "
                            <script>
                            Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            });
                            ";
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- Footer -->
            <?php include_once('include/footer.php'); ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Wrapper -->

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
