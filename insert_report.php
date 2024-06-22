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
    $status = 0;

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

    // Get the auto-generated ID from the damage_reports table
    $reportId = mysqli_insert_id($conn);

    // Handle file uploads
    $targetDir = "uploads/";

    // Picture upload
    if (!empty($_FILES["picture"]["name"])) {
        $pictureFileName = basename($_FILES["picture"]["name"]);
        $targetFilePath = $targetDir . $pictureFileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Check if file is a valid image type
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["picture"]["tmp_name"], $targetFilePath)) {
                // Insert picture file information into files table
                $fileSql = "INSERT INTO files (report_id, file_name, file_type) VALUES (?, ?, 'picture')";
                $fileStmt = mysqli_prepare($conn, $fileSql);
                mysqli_stmt_bind_param($fileStmt, "is", $reportId, $pictureFileName);
                mysqli_stmt_execute($fileStmt);
            } else {
                throw new Exception("Error uploading picture.");
            }
        } else {
            throw new Exception("Only JPG, JPEG, PNG, and GIF files are allowed.");
        }
    }

    // Video upload
    if (!empty($_FILES["video"]["name"])) {
        $videoFileName = basename($_FILES["video"]["name"]);
        $targetFilePath = $targetDir . $videoFileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Check if file is a valid video type
        $allowTypes = array('mp4', 'avi', 'mov', 'wmv');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["video"]["tmp_name"], $targetFilePath)) {
                // Insert video file information into files table
                $fileSql = "INSERT INTO files (report_id, file_name, file_type) VALUES (?, ?, 'video')";
                $fileStmt = mysqli_prepare($conn, $fileSql);
                mysqli_stmt_bind_param($fileStmt, "is", $reportId, $videoFileName);
                mysqli_stmt_execute($fileStmt);
            } else {
                throw new Exception("Error uploading video.");
            }
        } else {
            throw new Exception("Only MP4, AVI, MOV, and WMV files are allowed.");
        }
    }

    // Commit transaction if all queries succeed
    mysqli_commit($conn);
    $successMessage = "Damage report added successfully!";
    echo "<script>alert('$successMessage'); window.location.href = 'index.php';</script>";
    exit;

} catch (Exception $e) {
    // Rollback transaction if any query fails
    mysqli_rollback($conn);
    echo "Error inserting data: " . $e->getMessage();
}

// Close connection
mysqli_close($conn);
?>
