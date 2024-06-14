<?php

session_start();

// Check if user is logged in
if (!isset($_SESSION["id"]) || !isset($_SESSION["email"])) {
    echo "Error: User not logged in";
    exit;
}

// Get user details from session
$userId = $_SESSION["id"];
$userEmail = $_SESSION["email"];

// Include database connection file
require_once 'db_conn.php';

// Get POST data (assuming they are sanitized and validated)
$firstName = $_POST['firstname'];
$tel = $_POST['tel'];
$location = $_POST['location'];
$floor = $_POST['floor'];
$damage_type = $_POST['damage_type'];
$roomNum = $_POST['roomNum'];
$description = $_POST['description'];

// Start transaction
mysqli_begin_transaction($conn);

try {
	$status = 0 ;

    // Insert into locations table
    $locationSql = "INSERT INTO locations (name) VALUES (?)";
    $locationStmt = mysqli_prepare($conn, $locationSql);
    mysqli_stmt_bind_param($locationStmt, "s", $location);
    mysqli_stmt_execute($locationStmt);

    // Get the auto-generated ID from the locations table
    $locationId = mysqli_insert_id($conn);

    // Insert into damage_types table
    $damageTypeSql = "INSERT INTO damage_types (type) VALUES (?)";
    $damageTypeStmt = mysqli_prepare($conn, $damageTypeSql);
    mysqli_stmt_bind_param($damageTypeStmt, "s", $damage_type);
    mysqli_stmt_execute($damageTypeStmt);

    // Get the auto-generated ID from the damage_types table
    $damageTypeId = mysqli_insert_id($conn);

    // Insert into damage_reports table
    $damageReportSql = "INSERT INTO damage_reports (email, firstname, telephone, location_id, floor, damage_type_id, roomNum, description, user_id, status) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $damageReportStmt = mysqli_prepare($conn, $damageReportSql);
    mysqli_stmt_bind_param($damageReportStmt, "sssisssssi", $userEmail, $firstName, $tel, $locationId, $floor, $damageTypeId, $roomNum, $description, $userId, $status);
    mysqli_stmt_execute($damageReportStmt);

    // Commit transaction if all queries succeed
    mysqli_commit($conn);
    echo "Data inserted into all tables successfully";
} catch (Exception $e) {
    // Rollback transaction if any query fails
    mysqli_rollback($conn);
    echo "Error inserting data: " . $e->getMessage();
}

// Close connection
mysqli_close($conn);

?>