<?php
session_start();
include "db_conn.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT dr.id, dr.firstname, dr.telephone, l.name AS location, dr.floor, dr.roomNum, dt.type AS damage_type, dr.description, dr.reg_date, dr.status, f.file_name AS image_path
                            FROM damage_reports dr
                            INNER JOIN locations l ON dr.location_id = l.id
                            INNER JOIN damage_types dt ON dr.damage_type_id = dt.id
                            LEFT JOIN files f ON dr.id = f.report_id AND f.file_type = 'picture'
                            WHERE dr.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $report = $result->fetch_assoc();
        $imagePath = $report['image_path'];
    } else {
        header("Location: tables.php?message=Report+not+found");
        exit();
    }
    $stmt->close();

    // Delete report
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_delete'])) {
        $delete_stmt = $conn->prepare("DELETE FROM damage_reports WHERE id = ?");
        $delete_stmt->bind_param("i", $id);
        if ($delete_stmt->execute()) {
            header("Location: tables.php?message=Report+deleted+successfully");
        } else {
            echo "Error deleting report: " . $conn->error;
        }
        $delete_stmt->close();
    }
} else {
    header("Location: tables.php");
    exit();
}

$conn->close();
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

<?php include 'header.php'?>

<body>
    <div class="container">
        <br><br>
        <h1 class="h3 mb-4 text-gray-800">Edit Report</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Report Details</h6>
            </div>
            <div class="card-body">
                <form id="editForm" action="update_report.php" method="POST">
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
                            <td><textarea class="form-control" name="description" rows="5"><?php echo htmlspecialchars($report['description']); ?></textarea></td>
                        </tr>
                        <tr>
                            <th>Image Uploaded</th>
                            <td>
                                <?php if (!empty($imagePath)): ?>
                                    <img src="uploads/<?php echo htmlspecialchars($imagePath); ?>" alt="Damage Image" style="max-width: 100%; height: auto;">
                                <?php else: ?>
                                    No image uploaded.
                                <?php endif; ?>
                            </td>
                        </tr>
                        <input type="hidden" name="id" value="<?php echo $report['id']; ?>">
                    </table>
                    <div class="button-container">
                    <form action=update_report.php?id=<?php echo $id; ?> method="POST" style="display:inline;">
                        <button class="btn btn-primary" type="submit" name="confirm_update">Update</button>
                    </form>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to delete this report?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form action="delete_report-user.php?id=<?php echo $id; ?>" method="POST" style="display:inline;">
                        <button class="btn btn-danger" type="submit" name="confirm_delete">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
