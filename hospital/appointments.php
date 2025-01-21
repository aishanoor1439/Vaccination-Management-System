<?php
session_start();

if (!isset($_SESSION['hospital_session'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

include_once('connection.php');

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$hospital_id = $_SESSION['hospital_session'];

$query = "
    SELECT 
        tbl_child.name AS 'pname', 
        tbl_hospital.name AS 'hname', 
        tbl_vaccine.name AS 'vname', 
        tbl_appointment.* 
    FROM tbl_appointment 
    INNER JOIN tbl_child ON tbl_appointment.p_id = tbl_child.id 
    INNER JOIN tbl_hospital ON tbl_appointment.h_id = tbl_hospital.id 
    INNER JOIN tbl_vaccine ON tbl_appointment.v_id = tbl_vaccine.id
    WHERE tbl_appointment.h_id = $hospital_id
";

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Error in query execution: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Hospital - Appointments</title>
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
                    <h1 class="h2 mb-3 p-3">Appointments</h1>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Patient</th>
                                <th scope="col">Vaccine</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>
                                            <td>{$row['id']}</td>
                                            <td>{$row['pname']}</td>
                                            <td>{$row['vname']}</td>
                                            <td>{$row['date']}</td>
                                            <td>{$row['time']}</td>
                                            <td>{$row['status']}</td>
                                            <td>";

                                    // adding Confirm Vaccination link
                                    if ($row['status'] != 'done') {
                                        echo "<a href='confirm_vaccination.php?id={$row['id']}' style='color:#6f42c1;'>Confirm Vaccination</a>";
                                    } else {
                                        echo "<span class='text-muted'>Completed</span>";
                                    }

                                    echo "</td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center'  style='color:#6f42c1;'>No appointments found</td></tr>";
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
