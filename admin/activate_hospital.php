<?php
include("connection.php");

// Validate and sanitize the `id` parameter
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $hospital_id = intval($_GET['id']); // Ensure `id` is treated as an integer

    // Prepare the SQL query
    $query = "UPDATE tbl_hospital SET status = 'activated' WHERE id = $hospital_id";

    // Execute the query and check for success
    if (mysqli_query($connection, $query)) {
        // Redirect on success
        echo "<script>window.location.href='hospitals.php';</script>";
    } else {
        // Display an error message on failure
        echo "Error updating record: " . mysqli_error($connection);
    }
} 
?>
