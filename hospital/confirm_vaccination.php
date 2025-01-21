<?php
include_once('connection.php');
session_start();

if (!isset($_SESSION['hospital_session'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

// checking if the ID is passed
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $appointment_id = $_GET['id'];

    // ensuring the appointment belongs to the logged-in hospital
    $hospital_id = $_SESSION['hospital_session'];
    $check_query = "SELECT * FROM tbl_appointment WHERE id = $appointment_id AND h_id = $hospital_id";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // updating the status in the database
        $query = "UPDATE tbl_appointment SET status = 'done' WHERE id = $appointment_id";
        $result = mysqli_query($connection, $query);

        if ($result) {
            echo "<script>
                window.location.href = 'appointments.php';
            </script>";
        }
        else {
            // Display an error message on failure
            echo "Error updating record: " . mysqli_error($connection);
        }
?>
