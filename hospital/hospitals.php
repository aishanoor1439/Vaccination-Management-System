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

// Fetch hospitals data with the city name
$admin_id = $_SESSION['admin_session'];
$query = "SELECT h.id, h.name, h.contact, h.status, c.name AS city_name 
          FROM tbl_hospital h
          LEFT JOIN tbl_city c ON h.cid = c.id";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Admin - Hospitals</title>
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
                    <h1 class="h2 mb-3 p-3" style="">Hospitals</h1>
                    <a href="add_hospital.php">Add new Hospital</a>
                    <table class="table table-success table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">City</th> 
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Check if the query was successful and if there are results
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) { 
                                    echo "<tr>
                                            <td>{$row['id']}</td>
                                            <td>{$row['name']}</td>
                                            <td>{$row['city_name']}</td> <!-- Displaying City Name -->
                                            <td>{$row['status']}</td>
                                            <td>
                                                <a href='hospital_details.php?id={$row['id']}'>View Details | </a>
                                                <a href='edit_hospital.php?id={$row['id']}'>Edit Details | </a>";

                                    // Add Activate/Deactivate link based on the status
                                    if ($row['status'] == 'deactivated') {
                                        echo "<a href='activate_hospital.php?id={$row['id']}'>Activate</a>";
                                    } else {
                                        echo "<a href='deactivate_hospital.php?id={$row['id']}'>Deactivate</a>";
                                    }

                                    echo "</td>
                                          </tr>";
                                }
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
