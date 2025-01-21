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

// Get the patient ID from the query string
$patient_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the current hospital details from the database
$query = "SELECT * FROM tbl_child WHERE id = $patient_id";
$result = mysqli_query($connection, $query);

// Check if the record exists
if (!$result || mysqli_num_rows($result) === 0) {
    die("Error: Patient record not found.");
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin - Edit Child Details</title>
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
                    <h1 class="h2 mb-3 mt-3">Edit Child Details</h1>
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required value="<?php echo htmlspecialchars($row['name']); ?>">
                        </div>
                        <div class="form-check">
    <input class="form-check-input" type="radio" name="gender" id="male" value="Male" 
        <?php echo ($row['gender'] === 'Male') ? 'checked' : ''; ?> required>
    <label class="form-check-label" for="male">Male</label>
</div>
<div class="form-check mb-3">
    <input class="form-check-input" type="radio" name="gender" id="female" value="Female" 
        <?php echo ($row['gender'] === 'Female') ? 'checked' : ''; ?> required>
    <label class="form-check-label" for="female">Female</label>
</div>

                        <div class="mb-3">
                            <label class="form-label">Age</label>
                            <input type="text" class="form-control" id="age" name="age" required value="<?php echo htmlspecialchars($row['age']); ?>">
                        </div>
                        <div class="mb-3">
                            <select class="form-select" aria-label="Default select example" name="city" required>
                                <option hidden>City</option>
                                <?php
                                // Query to get the cities
                                $city_query = "SELECT * FROM tbl_city";
                                $city_result = mysqli_query($connection, $city_query);
                                while ($city_row = mysqli_fetch_assoc($city_result)) {
                                    $selected = ($city_row['id'] == $row['cid']) ? "selected" : "";
                                    echo "<option value='{$city_row['id']}' $selected>{$city_row['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required value="<?php echo htmlspecialchars($row['address']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact no</label>
                            <input type="text" class="form-control" id="contact_no" name="contact_no" required value="<?php echo htmlspecialchars($row['contact']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required value="<?php echo htmlspecialchars($row['email']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password" required value="<?php echo htmlspecialchars($row['password']); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary" name="btn_update">Update</button>
                    </form>

                    <?php
                    if (isset($_POST['btn_update'])) {

                        // Fetch submitted form data
                        $name = mysqli_real_escape_string($connection, $_POST['name']);
                        $age = mysqli_real_escape_string($connection, $_POST['age']);
                        $gender = mysqli_real_escape_string($connection, $_POST['gender']);
                        $city = mysqli_real_escape_string($connection, $_POST['city']);
                        $address = mysqli_real_escape_string($connection, $_POST['address']);
                        $contact_no = mysqli_real_escape_string($connection, $_POST['contact_no']);
                        $email = mysqli_real_escape_string($connection, $_POST['email']);
                        $password = mysqli_real_escape_string($connection, $_POST['password']);

                        // Update query
                        $update_query = "UPDATE tbl_child SET 
                            name = '$name', 
                            age = '$age',
                            gender = '$gender',
                            cid = '$city', 
                            address = '$address', 
                            contact = '$contact_no', 
                            email = '$email', 
                            password = '$password', 
                            status = '$status' 
                            WHERE id = $patient_id";

if (mysqli_query($connection, $update_query)) {
    echo "
    <script>
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Patients details have been updated!',
            showConfirmButton: false,
            timer: 1500
        });                                   
    </script>";
    echo "<script>window.location.href = 'patients.php';</script>";
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
