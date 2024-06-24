<?php
session_start();
include "db_conn.php";

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    $sql = "DELETE FROM damage_reports WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        // Redirect to the tables page with a success message
        header("Location: profile.php?message=Report+deleted+successfully");
    } else {
        // Redirect to the tables page with an error message
        header("Location: profile.php?message=Error+deleting+report");
    }
} else {
    // Redirect to the tables page if no ID is provided
    header("Location: profile.php");
}

mysqli_close($conn);
?>
