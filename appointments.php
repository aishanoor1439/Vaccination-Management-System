<?php 
session_start();
include_once('connection.php');

if (!isset($_SESSION['child_session']) || empty($_SESSION['child_session'])) {
  echo "<script>
    window.location.href = 'login.php';
</script>";
}

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
$stmt->close();
?>

<!doctype html>
<html lang="en">
<head>
  <title>VMS - Appointments</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
<div class="site-wrap">

  <!-- Header -->
  <?php include_once('include/header.php'); ?>

  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <form method="post">
        <h2 class="mt-5 mb-5">Book an Appointment</h2>
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="hidden" class="form-control" name="pid" value="<?php echo htmlspecialchars($patient['id']); ?>" readonly>
            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($patient['name']); ?>" readonly>
          </div>
          <div class="mb-3">
            <select class="form-select" name="hid" required>
              <option hidden>Hospital</option>
              <?php
              $query = "SELECT * FROM tbl_hospital WHERE status = 'activated'";
              $result = $connection->query($query);
              if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                      echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['name']) . "</option>";
                  }
              } else {
                  echo "<option disabled>No hospitals available</option>";
              }
              ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" class="form-control" required>
          </div>
          <div class="mb-3">
            <select class="form-select" name="time" required>
              <option hidden>Time-Slot</option>
              <option value="8-10">8-10</option>
              <option value="10-12">10-12</option>
              <option value="12-1">12-1</option>
              <option value="1-3">1-3</option>
              <option value="3-5">3-5</option>
              <option value="5-7">5-7</option>
              <option value="7-9">7-9</option>
            </select>
          </div>
          <div class="mb-3">
            <select class="form-select" name="vid" required>
              <option hidden>Vaccine</option>
              <?php
              $query = "SELECT * FROM tbl_vaccine WHERE status = 'available'";
              $result = $connection->query($query);
              if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                      echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['name']) . "</option>";
                  }
              } else {
                  echo "<option disabled>No vaccines available</option>";
              }
              ?>
            </select>
          </div>
          <button type="submit" class="btn btn-primary" name="btn_book">Book</button>
        </form>

        <?php
        if (isset($_POST['btn_book'])) {
            $pid = intval($_POST['pid']);
            $hid = intval($_POST['hid']);
            $vid = intval($_POST['vid']);
            $date = htmlspecialchars($_POST['date']);
            $time = htmlspecialchars($_POST['time']);

            // checking for existing appointment
            $check_query = "SELECT * FROM tbl_appointment WHERE h_id = ? AND date = ? AND time = ? AND p_id = ?";
            $stmt = $connection->prepare($check_query);
            $stmt->bind_param("issi", $hid, $date, $time, $pid);
            $stmt->execute();
            $check_result = $stmt->get_result();

            if ($check_result->num_rows > 0) {
                echo "
                <script>
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Appointment already exists for this time slot.',
                        icon: 'error',
                        confirmButtonText: 'Okay'
                    });
                </script>";
            } else {
                // inserting appointment into the database
                $insert_query = "INSERT INTO tbl_appointment (p_id, h_id, v_id, date, time) VALUES (?, ?, ?, ?, ?)";
                $stmt = $connection->prepare($insert_query);
                $stmt->bind_param("iisss", $pid, $hid, $vid, $date, $time);

                if ($stmt->execute()) {
                    echo "
                    <script>
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Appointment has been booked!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(() => { window.location.href = 'index.php'; }, 1500);
                    </script>";
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
                $stmt->close();
            }
        }
        ?>

        <h2 class="mt-5 mb-5">Your Appointments</h2>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Hospital</th>
              <th scope="col">Vaccine</th>
              <th scope="col">Date</th>
              <th scope="col">Time</th>
              <th scope="col">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = "SELECT tbl_hospital.name AS hname, tbl_vaccine.name AS vname, tbl_appointment.* 
                      FROM tbl_appointment 
                      INNER JOIN tbl_hospital ON tbl_appointment.h_id = tbl_hospital.id 
                      INNER JOIN tbl_vaccine ON tbl_appointment.v_id = tbl_vaccine.id 
                      WHERE tbl_appointment.p_id = ?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("i", $_SESSION['child_session']);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                      <td>" . htmlspecialchars($row['hname']) . "</td>
                      <td>" . htmlspecialchars($row['vname']) . "</td>
                      <td>" . htmlspecialchars($row['date']) . "</td>
                      <td>" . htmlspecialchars($row['time']) . "</td>
                      <td>" . htmlspecialchars($row['status']) . "</td>
                    </tr>";
                }
            } else {
                echo "
                <tr>
                    <td colspan='5' class='text-center' style='color:#6F42C1;'>No appointments found!</td>
                </tr>";
            }
            $stmt->close();
            ?>
          </tbody>
        </table>
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
