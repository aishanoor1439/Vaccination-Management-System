<?php
session_start();

// Session validation
if (!isset($_SESSION['admin_session'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

// Database connection
include_once('connection.php');

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL query to fetch vaccine data
$query = "SELECT name AS 'vname', status FROM tbl_vaccine";
$result = mysqli_query($connection, $query);

if (!$result) {
    echo "Error in query execution: " . mysqli_error($connection);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hospital - Vaccines</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,900" rel="stylesheet">
    <link href="./assets/css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .no-data {
            color: #6f42c1;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include_once('include/sidebar.php'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div class="container mt-4">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="h2 mb-3 p-3">Vaccines</h1>

                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        // Use htmlspecialchars to prevent XSS attacks
                                        $vname = htmlspecialchars($row['vname']);
                                        $status = htmlspecialchars($row['status']);
                                        $statusBadge = $status === 'active'
                                            ? '<span class="badge badge-success">Active</span>'
                                            : '<span class="badge badge-danger">Inactive</span>';

                                        echo "<tr>
                                                <td>$vname</td>
                                                <td>$statusBadge</td>
                                              </tr>";
                                    }
                                } else {
                                    // If no results are found
                                    echo "<tr><td colspan='2' class='no-data'>No vaccinations found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
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
