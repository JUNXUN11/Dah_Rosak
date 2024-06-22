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
$role = $_POST['role'];


$sql = "UPDATE user SET username=?, email=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $firstName, $email, $id);

// Execute the statement
if ($stmt->execute()) {
    if ($role === 'admin') {
        echo "<script>alert('Record updated successfully.'); window.location.href = 'admin-profile.php';</script>";
    } else {
        echo "<script>alert('Record updated successfully.'); window.location.href = 'profile.php';</script>";
    }
} else {
    echo "<script>alert('Error updating record: " . htmlspecialchars($stmt->error) . "'); window.location.href = 'edit_profilepage.php';</script>";
}

// Close statement and connection
$stmt->close();
$conn->close();
?>