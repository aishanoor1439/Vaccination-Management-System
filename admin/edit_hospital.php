<?php
session_start();
if (!isset($_SESSION['admin_session'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}
include_once('connection.php');

// getting the hospital ID from the query string
$hospital_id = $_GET['id'];

// fetching the current hospital details from the database
$query = "SELECT * FROM tbl_hospital WHERE id=$hospital_id";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin - Edit Hospital Details</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,900" rel="stylesheet">
    <link href="./assets/css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <h1 class="h2 mb-3 mt-3">Edit Hospital Details</h1>
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required value="<?php echo $row['name'];?>">
                        </div>
                        <div class="mb-3">
                            <select class="form-select" aria-label="Default select example" name="city" required>
                                <option hidden>City</option>
                                <?php
                                // Query to get the cities (assuming a table for cities exists)
                                $city_query = "SELECT * FROM tbl_city";
                                $city_result = mysqli_query($connection, $city_query);
                                while ($city_row = mysqli_fetch_assoc($city_result)) {
                                    echo "<option value='{$city_row['id']}'" . ($city_row['id'] == $row['cid'] ? " selected" : "") . ">{$city_row['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required value="<?php echo $row['address'];?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact no</label>
                            <input type="text" class="form-control" id="contact_no" name="contact_no" required value="<?php echo $row['contact'];?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required value="<?php echo $row['email'];?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required value="<?php echo $row['password'];?>">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="status" <?php echo ($row['status'] == 'activated') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="exampleCheck1">Activated</label>
                        </div>
                        <button type="submit" class="btn btn-primary" name="btn_update"   style='background-color: #6f42c1; color:white;'>Update</button>
                    </form>

                    <?php

                    if (isset($_POST['btn_update'])) {
                        $name = mysqli_real_escape_string($connection, $_POST['name']);
                        $city = mysqli_real_escape_string($connection, $_POST['city']);
                        $address = mysqli_real_escape_string($connection, $_POST['address']);
                        $contact_no = mysqli_real_escape_string($connection, $_POST['contact_no']);
                        $email = mysqli_real_escape_string($connection, $_POST['email']);
                        $password = mysqli_real_escape_string($connection, $_POST['password']);
                        $status = isset($_POST['status']) ? "activated" : "deactivated"; // checkbox value handling

                        // Update query to modify existing record
                        $update_query = "UPDATE tbl_hospital SET name='$name', cid='$city', address='$address', contact='$contact_no', email='$email', password='$password', status='$status' WHERE id='$hospital_id'";

                        if (mysqli_query($connection, $update_query)) {
                            echo "
                            <script>
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Hospital details have been updated!',
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
                            </script>";
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
