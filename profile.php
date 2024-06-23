<?php

session_start();

if (!isset($_SESSION["id"])) {
    // Redirect to login page or handle the missing session case.
    header("Location: login.php");
    exit();
}

$id = $_SESSION["id"];
$role = $_SESSION["role"];

require_once('db_conn.php');

$sql = "SELECT username, email FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $name = $user['username'];
    $email = $user['email'];
} else {
    // Handle the case where the user is not found.
    $name = "Unknown";
    $email = "Unknown";
}

$stmt->close();

$sql = 'SELECT dr.id, dr.firstname, dr.telephone, l.name AS location, dr.floor, dr.roomNum, dt.type AS damage_type, dr.description, dr.reg_date, dr.status
        FROM damage_reports dr
        INNER JOIN locations l ON dr.location_id = l.id
        INNER JOIN damage_types dt ON dr.damage_type_id = dt.id
        WHERE dr.user_id = ?';

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$damages = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>User Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style type="text/css">
        body {
            margin-top: 20px;
            color: #1a202c;
            background-color: #e2e8f0;
        }
        .main-body {
            padding: 15px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1), 0 6px 20px rgba(0,0,0,0.1);
            border-radius: .25rem;
        }
        .card-body {
            padding: 1rem;
        }
        .gutters-sm {
            margin-right: -8px;
            margin-left: -8px;
            margin-top: 3rem;
        }
        .mb-3, .my-3 {
            margin-bottom: 1rem!important;
        }
        .bg-gray-300 {
            background-color: #e2e8f0;
        }
        .h-100 {
            height: 100%!important;
        }
        .shadow-none {
            box-shadow: none!important;
        }
        .profile-card img {
            width: 150px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .profile-card .mt-3 {
            margin-top: 1rem;
        }
        .profile-card .btn {
            margin-top: 0.5rem;
        }
        .breadcrumb-item a {
            color: #007bff;
        }
        .breadcrumb-item.active {
            color: #6c757d;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table .btn {
            padding: 0.25rem 0.5rem;
        }
        .icon {
            font-size: 1.2em;
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0,0,0,.125);
            border-radius: .25rem .25rem 0 0;
            padding: 0.75rem 1.25rem;
        }
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <div class="main-body">
            <nav aria-label="breadcrumb" class="main-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                </ol>
            </nav>
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <!-- PROFILE CARD -->
                    <div class="card profile-card">
                        <div class="card-body text-center">
                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle">
                            <div class="mt-3">
                                <h4><?php echo htmlspecialchars($name); ?></h4>
                                <p class="text-secondary mb-1 px-2"><?php echo htmlspecialchars($role); ?><i class=" pl-2 fas fa-user icon"></i> </p>
                                <p class="text-muted font-size-sm px-2"> <?php echo htmlspecialchars($email); ?><i class="pl-2 fas fa-envelope icon"></i></p>
                                <a class="btn btn-primary px-4 mt-6" href="edit_profilepage.php?id=<?php echo $id; ?>">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h2 class="mt-3 mb-3 text-center">Reported Damages</h2>
                        </div>
                        <div class="card-body">
                            <!-- SHOW REPORTED CASE -->
                            <?php foreach($damages as $damage): ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <table class="table table-bordered table-hover">
                                        <thead class="text-center">
                                            <tr>
                                                <th>Location</th>
                                                <th>Floor</th>
                                                <th>Room </th>
                                                <th>Type</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <tr>
                                                <td><?php echo htmlspecialchars($damage['location']); ?></td>
                                                <td><?php echo htmlspecialchars($damage['floor']); ?></td>
                                                <td><?php echo htmlspecialchars($damage['roomNum']); ?></td>
                                                <td><?php echo htmlspecialchars($damage['damage_type']); ?></td>
                                                <td><?php echo htmlspecialchars($damage['reg_date']); ?></td>
                                                <td><?php echo $damage['status'] == 0 ? 'Not fixed' : '<strong>Fixed</strong>'; ?></td>
                                                <td>
                                                    <a class="btn btn-primary btn-sm" href="edit_report_user.php?id=<?php echo $damage['id']; ?>"> View</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <!-- END OF SHOW REPORTED CASE -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section></section>
    <section></section>
</body>

<?php include 'footer.php'; ?>
</html>
