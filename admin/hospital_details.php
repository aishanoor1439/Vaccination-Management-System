<?php
session_start();

if (!isset($_SESSION['admin_session'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

include_once('connection.php');

// fetching hospital and city data
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $hospital_id = intval($_GET['id']); // sanitizing input

    $query = "SELECT tbl_hospital.*, tbl_city.name as city_name 
              FROM tbl_hospital 
              INNER JOIN tbl_city ON tbl_hospital.cid = tbl_city.id 
              WHERE tbl_hospital.id = ?";
              
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $hospital_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
} else {
    echo "Invalid ID";
    exit;
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
                <h1 class="h2 m-3" style="">Hospital Details</h1>
                <section class="bg-light">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 mb-4 mb-sm-5">
                                <div class="card card-style1 border-0">
                                    <div class="card-body p-1-9 p-sm-2-3 p-md-6 p-lg-7">
                                        <div class="row align-items-center">
                                            <div class="col-lg-12 px-xl-10">
                                                <div class="d-lg-inline-block py-1-9 px-1-9 px-sm-6 mb-5">
                                                    <h3 class="h2 mb-0"><?php echo htmlspecialchars($row['name']); ?></h3>
                                                    <span class="text-primary">Hospital</span>
                                                </div>
                                                <ul class="list-unstyled mb-1-9">
                                                    <li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">City: </span><?php echo htmlspecialchars($row['city_name']); ?></li>
                                                    <li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">Address: </span><?php echo htmlspecialchars($row['address']); ?></li>
                                                    <li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">Status: </span><?php echo htmlspecialchars($row['status']); ?></li>
                                                    <li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">Contact no: </span><?php echo htmlspecialchars($row['contact']); ?></li>
                                                    <li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">Email: </span><?php echo htmlspecialchars($row['email']); ?></li>
                                                    <li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">Password: </span><?php echo htmlspecialchars($row['password']); ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
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
