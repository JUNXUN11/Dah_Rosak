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
    $report = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    // Update report status
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_update'])) {
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $update_sql = "UPDATE damage_reports SET status = $status WHERE id = $id";
        if (mysqli_query($conn, $update_sql)) {
            header("Location: tables.php?message=Report+updated+successfully");
        } else {
            echo "Error updating report: " . mysqli_error($conn);
        }
    }

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
    <script>
        $(document).ready(function(){
            $('#updateModal').on('show.bs.modal', function (e) {
                var status = $('#status').val();
                $(this).find('input[name="status"]').val(status);
            });
        });
    </script>
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
                <table class="table table-bordered">
                    <tr>
                        <th>Name</th>
                        <td><?php echo htmlspecialchars($report['firstname']); ?></td>
                    </tr>
                    <tr>
                        <th>Telephone</th>
                        <td><?php echo htmlspecialchars($report['telephone']); ?></td>
                    </tr>
                    <tr>
                        <th>Location</th>
                        <td><?php echo htmlspecialchars($report['location']); ?></td>
                    </tr>
                    <tr>
                        <th>Floor</th>
                        <td><?php echo htmlspecialchars($report['floor']); ?></td>
                    </tr>
                    <tr>
                        <th>Room Number</th>
                        <td><?php echo htmlspecialchars($report['roomNum']); ?></td>
                    </tr>
                    <tr>
                        <th>Damage Type</th>
                        <td><?php echo htmlspecialchars($report['damage_type']); ?></td>
                    </tr>
                    <tr>
                        <th>Damage Description</th>
                        <td><?php echo htmlspecialchars($report['description']); ?></td>
                    </tr>
                    <tr>
                        <th>Registration Date</th>
                        <td><?php echo htmlspecialchars($report['reg_date']); ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><?php echo $report['status'] == 0 ? 'Not fixed' : 'Fixed'; ?></td>
                    </tr>
                </table>
                <form action="edit_report.php?id=<?php echo $id; ?>" method="POST">
                    <div class="form-group">
                        <label for="status">Update Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="0" <?php echo $report['status'] == 0 ? 'selected' : ''; ?>>Not fixed</option>
                            <option value="1" <?php echo $report['status'] == 1 ? 'selected' : ''; ?>>Fixed</option>
                        </select>
                    </div>
                    <button type="button" name="update" class="btn btn-primary" data-toggle="modal" data-target="#updateModal">Update</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to delete this report?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form action="edit_report.php?id=<?php echo $id; ?>" method="POST" style="display:inline;">
                        <button type="submit" name="confirm_delete" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Confirmation Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Confirm Update</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to update the status of this report?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form action="edit_report.php?id=<?php echo $id; ?>" method="POST" style="display:inline;">
                        <input type="hidden" name="status" id="modal-status">
                        <button type="submit" name="confirm_update" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
