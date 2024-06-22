<?php
session_start();
include "db_conn.php";

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch the existing report details
    $sql = "SELECT dr.id, dr.firstname, dr.telephone, l.name AS location, dr.floor, dr.roomNum, dt.type AS damage_type, dr.description, dr.reg_date, dr.status
            FROM damage_reports dr
            INNER JOIN locations l ON dr.location_id = l.id
            INNER JOIN damage_types dt ON dr.damage_type_id = dt.id
            WHERE dr.id = $id";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $report = mysqli_fetch_assoc($result);
    } else {
        // Handle case where no report is found
        header("Location: tables.php?message=Report+not+found");
        exit();
    }
    mysqli_free_result($result);

    // Delete report
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_delete'])) {
        $delete_sql = "DELETE FROM damage_reports WHERE id = $id";
        if (mysqli_query($conn, $delete_sql)) {
            header("Location: tables.php?message=Report+deleted+successfully");
        } else {
            echo "Error deleting report: " . mysqli_error($conn);
        }
    }
} else {
    header("Location: tables.php");
    exit();
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Report</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        .button-container {
            display: flex;
            gap: 10px;
            justify-content: flex-start;
        }
    </style>
</head>
<body>
    <div class="container">
        <br><br>
        <h1 class="h3 mb-4 text-gray-800">Edit Report</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Report Details</h6>
            </div>
            <div class="card-body">
                <form action="update_report.php" method="POST">
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <td><input type="text" class="form-control" name="firstname" value="<?php echo htmlspecialchars($report['firstname']); ?>"></td>
                        </tr>
                        <tr>
                            <th>Telephone</th>
                            <td><input type="text" class="form-control" name="telephone" value="<?php echo htmlspecialchars($report['telephone']); ?>"></td>
                        </tr>
                        <tr>
                            <th>Location</th>
                            <td><input type="text" class="form-control" name="location" value="<?php echo htmlspecialchars($report['location']); ?>"></td>
                        </tr>
                        <tr>
                            <th>Floor</th>
                            <td>
                                <select class="form-select form-control" name="floor" id="floor">
                                    <option value="G" <?php if ($report['floor'] == 'G') echo 'selected'; ?>>Floor G</option>
                                    <option value="1" <?php if ($report['floor'] == '1') echo 'selected'; ?>>Floor 1</option>
                                    <option value="2" <?php if ($report['floor'] == '2') echo 'selected'; ?>>Floor 2</option>
                                    <option value="3" <?php if ($report['floor'] == '3') echo 'selected'; ?>>Floor 3</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Room Number</th>
                            <td><input type="text" class="form-control" name="roomNum" value="<?php echo htmlspecialchars($report['roomNum']); ?>"></td>
                        </tr>
                        <tr>
                            <th>Damage Type</th>
                            <td>
                                <select class="form-select form-control" name="damage_type" id="damageType">
                                    <option value="civil" <?php if ($report['damage_type'] == 'civil') echo 'selected'; ?>>Civil Damage</option>
                                    <option value="electrical" <?php if ($report['damage_type'] == 'electrical') echo 'selected'; ?>>Electrical Damage</option>
                                    <option value="furniture" <?php if ($report['damage_type'] == 'furniture') echo 'selected'; ?>>Furniture Damage</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Damage Description</th>
                            <td><input type="text" class="form-control" name="description" value="<?php echo htmlspecialchars($report['description']); ?>"></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><input type="text" class="form-control" name="status" value="<?php echo htmlspecialchars($report['status']); ?>"></td>
                        </tr>
                        <input type="hidden" name="id" value="<?php echo $report['id']; ?>">
                    </table>
                    <div class="button-container">
                        <button type="submit" name="confirm_update" class="btn btn-primary">Update</button>
                        <form action="edit_report_user.php?id=<?php echo $id; ?>" method="POST" style="display:inline;">
                            <button type="submit" name="confirm_delete" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
