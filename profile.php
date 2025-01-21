<?php
session_start();
include_once('connection.php');

// checking if the session is valid
if (!isset($_SESSION['child_session']) || empty($_SESSION['child_session'])) {
    die("Invalid session. Please log in again.");
}

// fetching the current hospital details from the database
$query = "SELECT * FROM tbl_child WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $_SESSION['child_session']);
$stmt->execute();
$result = $stmt->get_result();

// checking if the record exists
if ($result->num_rows === 0) {
  echo"<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
  echo "<script>
  Swal.fire({
      title: 'Invalid ID',
      icon: 'warning',
  });
  </script>";
}

$patient = $result->fetch_assoc();
?>

<!doctype html>
<html lang="en">
<head>
  <title>VMS - Profile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    

  <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
<div class="site-wrap">

  <!-- Header -->
  <?php include_once('include/header.php'); ?>

<!-- Hero Section -->
<div class="hero-v1">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mr-auto text-center text-lg-left">
        <span class="d-block subheading">Child Health Matters</span>
<h1 class="heading mb-3">Protect. Prevent. Vaccinate.</h1>
<p class="mb-5">Ensure a healthy future for your child with timely vaccinations. Stay informed, stay proactive, and safeguard their well-being with our trusted vaccination management system.</p>

          <p class="mb-4"><a href="appointments.php" class="btn btn-primary">Book Appointment</a></p>
        </div>
        <div class="col-lg-6">
          <figure class="illustration">
            <img src="./assets/images/rb_1622.png" alt="Image" class="img-fluid">
          </figure>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <form method="post">
          <div class="mb-3">
            <h2 class="mt-5 mb-5">Child Profile</h2>
          </div>
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="name" required value="<?php echo htmlspecialchars($patient['name']); ?>">
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" id="male" value="Male" 
              <?php echo ($patient['gender'] === 'Male') ? 'checked' : ''; ?> required>
            <label class="form-check-label" for="male">Male</label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="gender" id="female" value="Female" 
              <?php echo ($patient['gender'] === 'Female') ? 'checked' : ''; ?> required>
            <label class="form-check-label" for="female">Female</label>
          </div>
          <div class="mb-3">
            <label class="form-label">Age</label>
            <input type="text" class="form-control" name="age" required value="<?php echo htmlspecialchars($patient['age']); ?>">
          </div>
          <div class="mb-3">
            <select class="form-select" name="city" required>
              <option hidden>City</option>
              <?php
              $city_query = "SELECT * FROM tbl_city";
              $city_result = $connection->query($city_query);
              while ($row = $city_result->fetch_assoc()) {
                  $selected = ($row['id'] == $patient['cid']) ? 'selected' : '';
                  echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
              }
              ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" class="form-control" name="address" required value="<?php echo htmlspecialchars($patient['address']); ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Contact no</label>
            <input type="text" class="form-control" name="contact_no" required value="<?php echo htmlspecialchars($patient['contact']); ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" class="form-control" name="email" required value="<?php echo htmlspecialchars($patient['email']); ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required value="<?php echo htmlspecialchars($patient['password']); ?>">
          </div>
          <button type="submit" class="btn btn-primary" name="btn_update">Update</button>
        </form>

        <?php
        if (isset($_POST['btn_update'])) {
          // fetching submitted form data
          $name = mysqli_real_escape_string($connection, $_POST['name']);
          $age = mysqli_real_escape_string($connection, $_POST['age']);
          $gender = mysqli_real_escape_string($connection, $_POST['gender']);
          $city = mysqli_real_escape_string($connection, $_POST['city']);
          $address = mysqli_real_escape_string($connection, $_POST['address']);
          $contact_no = mysqli_real_escape_string($connection, $_POST['contact_no']);
          $email = mysqli_real_escape_string($connection, $_POST['email']);
          $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

          $update_query = "UPDATE tbl_child SET name = ?, age = ?, gender = ?, cid = ?, address = ?, contact = ?, email = ?, password = ? WHERE id = ?";
          $stmt = $connection->prepare($update_query);
          $stmt->bind_param("sissssssi", $name, $age, $gender, $city, $address, $contact_no, $email, $password, $_SESSION['child_session']);

          if ($stmt->execute()) {
              echo "
              <script>
                  Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: 'Child details have been updated!',
                      showConfirmButton: false,
                      timer: 1500
                  });
                  setTimeout(() => { window.location.href = 'index.php'; }, 1500);
              </script>";
          } else {
              echo "
              <script>
              Swal.fire({
              icon: 'warning',
              title: 'Oops...',
              text: 'Something went wrong!',
              });
              </script>";
          }
        }
        ?>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include_once('include/footer.php'); ?>

</div>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
