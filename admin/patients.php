<?php
session_start();
// redirecting to login if not logged in
if (!isset($_SESSION['admin_session'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}
include_once('connection.php');

// fetching patients' data with cities
$admin_id = $_SESSION['admin_session'];
$query = "
    SELECT 
        c.id AS patient_id, 
        c.name AS patient_name, 
        c.contact AS patient_contact, 
        c.id, 
        ct.name AS city_name
    FROM tbl_child c
    LEFT JOIN tbl_city ct ON c.id = ct.id
";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Admin - Children</title>
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
                 <h1 class="h2 m-3" style="">Children</h1>
                 
                 <a href="add_patient.php" style="color: #6F42C1">Add new Child</a>
                 <table class="table">
                  <thead>
                     <tr>
                     <th scope="col">ID</th>
                     <th scope="col">Name</th>
                     <th scope="col">Phone Number</th>
                     <th scope="col">City</th> <!-- Added City Column -->
                     <th scope="col">Actions</th>
                     </tr>
                  </thead>
                 <tbody>
                 <?php

                     // check if the query was successful and if there are results
                     if ($result && mysqli_num_rows($result) > 0) {
                         foreach ($result as $row) { 
                             echo "<tr>
                                     <td>{$row['patient_id']}</td>
                                     <td>{$row['patient_name']}</td>
                                     <td>{$row['patient_contact']}</td>
                                     <td>{$row['city_name']}</td> <!-- Display City Name -->
                                     <td>
                                         <a href='patient_details.php?id={$row['patient_id']}'  style='color: #6F42C1'>View Details|</a>
                                         <a href='edit_patient.php?id={$row['patient_id']}'  style='color: #6F42C1'>Edit Details</a>
                              ";


                              echo "</td>
                                  </tr>";
                            }
                        }
                        else {
                            // If no results are found
                            echo "<tr><td colspan='2' style='color: #6f42c1;'>No profiles found.</td></tr>";
                        }
                   ?>
                 </tbody>
                 </table>
             </div>
        </div>
          



            <!-- Footer -->
            <?php include_once('include/footer.php'); ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Wrapper -->

    <!-- Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
