<?php
// Establish connection to database
require_once ("db_conn.php");

// Check if the fieldname 'id' is set and not null
if(isset($_POST['id']) && !empty($_POST['id'])){
    $id = $_POST['id'];
} else {
    echo "<script>alert('Error: ID is not set or empty.'); window.location.href = 'edit_profilepage.php';</script>";
    exit();
}

// Access the field names from the form
$firstName = $_POST['firstName'];
$email = $_POST['email'];

// Update table 'user' according to 'id' using UPDATE
$sql = "UPDATE user SET username='$firstName', email='$email' WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Record updated successfully.'); window.location.href = 'profile.php';</script>";
} else {
    echo "<script>alert('Error updating record: " . mysqli_error($conn) . "'); window.location.href = 'edit_profilepage.php';</script>";
}

// Close the database connection
mysqli_close($conn);
?>
