<?php
session_start();
if (!isset($_SESSION['admin_session'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}
include_once('connection.php');
$admin_id = $_SESSION['admin_session'];
$query = "SELECT * FROM tbl_admin WHERE id = $admin_id";
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
    <title>Admin - Profile</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,900" rel="stylesheet">
    <link href="./assets/css/sb-admin-2.min.css" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <style>
.btn{
    background-color:  #6F42C1;
    color:white;
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
            <div id="content">
                <section class="bg-light">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <div class="card card-style1 border-0 p-3">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-lg-6 mb-4">
                                            <div style="width: 500px; height: 400px; overflow: hidden; border: 1px solid #ccc;" class="mb-3">
                                                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Admin Profile" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <div class="mb-3">
                                                    <input class="form-control form-control-sm" id="formFileSm" type="file" name="image" required>
                                                </div>
                                                <button type="submit" class="btn" name="btn_upload">Upload</button>
                                            </form>
                                            <?php
                                            if (isset($_POST['btn_upload'])) {

                                                $image_name = $_FILES['image']['name'];
                                                $temp_name = $_FILES['image']['tmp_name'];
                                                $upload_dir = "assets/images/image_name";
                                                $path = $upload_dir . basename($image_name);
                                                if (move_uploaded_file($temp_name, $path)) {
                                                    $query = "UPDATE tbl_admin SET image='$path' WHERE id=$_SESSION[admin_session]";
                                                    $update_result = mysqli_query($connection, $query);
                                                    if ($update_result) {
                                                        echo "<script>
                                                            Swal.fire({
                                                                position: 'center',
                                                                icon: 'success',
                                                                title: 'Profile Updated Successfully!',
                                                                showConfirmButton: false,
                                                                timer: 1500
                                                            });
                                                        </script>";
                                                    } else {
                                                        echo "<script>
                                                            Swal.fire({
                                                                position: 'center',
                                                                icon: 'warning',
                                                                title: 'Database Update Failed!',
                                                                showConfirmButton: false,
                                                                timer: 1500
                                                            });
                                                        </script>";
                                                    }
                                                } else {
                                                    echo "<script>
                                                            Swal.fire({
                                                                position: 'center',
                                                                icon: 'warning',
                                                                title: 'Database Update Failed!',
                                                                showConfirmButton: false,
                                                                timer: 1500
                                                            });
                                                        </script>";
                                                }
                                            }
                                            ?>
                                            </div>
                                            
                                            <div class="col-lg-6">
                                                <div class="mb-5">
                                                    <h1 class="h2 mb-0">My Profile</h1>
                                                    <span class="text-primary" style="color:  #6F42C1;";>Admin</span>
                                                </div>
                                                <form method="post">
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email Address</label>
                                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="password" class="form-label">Password</label>
                                                        <input type="password" class="form-control" id="password" name="password" value="<?php echo htmlspecialchars($row['password']); ?>" required>
                                                    </div>
                                                    <button type="submit" class="btn" name="btn_update" style="background-color:#6f42c1;">Update</button>
                                                </form>
                                                <?php
                                                if (isset($_POST['btn_update'])) {
                                                    $email = mysqli_real_escape_string($connection, $_POST['email']);
                                                    $password = mysqli_real_escape_string($connection, $_POST['password']);
                                                    $update_query = "UPDATE tbl_admin SET email='$email', password='$password' WHERE id=$admin_id";
                                                    $update_result = mysqli_query($connection, $update_query);

                                                    if ($update_result) {
                                                        echo "<script>
                                                            Swal.fire({
                                                                position: 'center',
                                                                icon: 'success',
                                                                title: 'Profile Updated Successfully!',
                                                                showConfirmButton: false,
                                                                timer: 1500
                                                            });
                                                        </script>";
                                                    } else {
                                                        echo "<script>
                                                            Swal.fire({
                                                                position: 'center',
                                                                icon: 'warning',
                                                                title: 'Database Update Failed!',
                                                                showConfirmButton: false,
                                                                timer: 1500
                                                            });
                                                        </script>";
                                                    }
                                                }
                                                ?>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Footer -->
            <?php include_once('include/footer.php'); ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
