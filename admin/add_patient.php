<?php
session_start();

if (!isset($_SESSION['admin_session'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

include_once('connection.php');
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM tbl_city";
$result = mysqli_query($connection, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin - Add New Child</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,900" rel="stylesheet">
    <link href="./assets/css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body id="page-top">
    <div id="wrapper">

        <?php include_once('include/sidebar.php'); ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div class="container">
                <h1 class="h2 mb-3 mt-3">Add Child</h1>
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Age</label>
                        <input type="number" class="form-control" id="age" name="age" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gender</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Male" required>
                            <label class="form-check-label" for="genderMale">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Female">
                            <label class="form-check-label" for="genderFemale">Female</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="genderOther" value="Other">
                            <label class="form-check-label" for="genderOther">Other</label>
                        </div>
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
                    <button type="submit" class="btn btn-primary" name="btn_add" style="background-color: #6F42C1;">Add</button>
                </form>

                <?php
                if (isset($_POST['btn_add'])) {
                    $name = mysqli_real_escape_string($connection, $_POST['name']);
                    $age = mysqli_real_escape_string($connection, $_POST['age']);
                    $gender = mysqli_real_escape_string($connection, $_POST['gender']);
                    $city = mysqli_real_escape_string($connection, $_POST['city']);
                    $address = mysqli_real_escape_string($connection, $_POST['address']);
                    $contact_no = mysqli_real_escape_string($connection, $_POST['contact_no']);
                    $email = mysqli_real_escape_string($connection, $_POST['email']);
                    $password = mysqli_real_escape_string($connection, $_POST['password']);

                    $query = "INSERT INTO tbl_child(name, age, gender, cid, address, contact, email, password) 
                              VALUES('$name', '$age', '$gender', '$city', '$address', '$contact_no', '$email', '$password')";

                    if (mysqli_query($connection, $query)) {
                        echo "<script>Swal.fire({icon: 'success', title: 'New patient added!', showConfirmButton: false, timer: 1500});</script>";
                        echo "<script>window.location.href = 'patients.php';</script>";
                    } else {
                        echo "<script>console.log('Error: " . mysqli_error($connection) . "');</script>";
                        echo "<script>Swal.fire({icon: 'warning', title: 'Oops...', text: 'Something went wrong!'});</script>";
                    }
                }
                ?>
            </div>
            <?php include_once('include/footer.php'); ?>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
