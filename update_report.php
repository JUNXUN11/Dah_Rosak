<?php
require_once "db_conn.php";

if (isset($_POST['confirm_update'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $telephone = mysqli_real_escape_string($conn, $_POST['telephone']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $floor = mysqli_real_escape_string($conn, $_POST['floor']);
    $roomNum = mysqli_real_escape_string($conn, $_POST['roomNum']);
    $damage_type = mysqli_real_escape_string($conn, $_POST['damage_type']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Debugging: Print the values being updated
    echo "ID: $id<br>";
    echo "Firstname: $firstname<br>";
    echo "Telephone: $telephone<br>";
    echo "Location: $location<br>";
    echo "Floor: $floor<br>";
    echo "RoomNum: $roomNum<br>";
    echo "Damage Type: $damage_type<br>";
    echo "Description: $description<br>";
    echo "Status: $status<br>";

    // Prepare update SQL query
    $update_sql = "UPDATE damage_reports SET";
    $updates = [];

    if (!empty($firstname)) {
        $updates[] = " firstname = '$firstname'";
    }
    if (!empty($telephone)) {
        $updates[] = " telephone = '$telephone'";
    }
    if (!empty($location)) {
        $updates[] = " location_id = (SELECT id FROM locations WHERE name = '$location' LIMIT 1)";
    }
    if (!empty($floor)) {
        $updates[] = " floor = '$floor'";
    }
    if (!empty($roomNum)) {
        $updates[] = " roomNum = '$roomNum'";
    }
    if (!empty($damage_type)) {
        $updates[] = " damage_type_id = (SELECT id FROM damage_types WHERE type = '$damage_type' LIMIT 1)";
    }
    if (!empty($description)) {
        $updates[] = " description = '$description'";
    }
    if (!empty($status)) {
        $updates[] = " status = '$status'";
    }

    if (!empty($updates)) {
        $update_sql .= implode(",", $updates);
        $update_sql .= " WHERE id = $id";

        if (mysqli_query($conn, $update_sql)) {
            header("Location: profile.php?message=Report+updated+successfully");
        } else {
            echo "Error updating report: " . mysqli_error($conn);
        }
    } else {
        header("Location: profile.php");
    }
}

mysqli_close($conn);
?>
