<?php 
// Q1: Start the session
   session_start();
   include "db_conn.php";
  
   //query
   $sql = 'SELECT dr.firstname, dr.telephone, l.name AS location, dr.floor, dr.roomNum, dt.type AS damage_type, dr.description, dr.reg_date
        FROM damage_reports dr
        INNER JOIN locations l ON dr.location_id = l.id
        INNER JOIN damage_types dt ON dr.damage_type_id = dt.id
        ORDER BY dr.reg_date';

   //get result
   $result = mysqli_query($conn, $sql);
  
   //fetch in array form 
   $damages = mysqli_fetch_all($result, MYSQLI_ASSOC);
   
   mysqli_free_result($result);

   // Query to get the count of each damage type
    $sql_count = 'SELECT dt.type, COUNT(dr.id) AS count 
    FROM damage_reports dr
    INNER JOIN damage_types dt ON dr.damage_type_id = dt.id
    GROUP BY dt.type';

    $count_result = mysqli_query($conn, $sql_count);

    // Fetch counts in array form
    $damage_counts = mysqli_fetch_all($count_result, MYSQLI_ASSOC);
    // Return the result as JSON
    header('Content-Type: application/json');
    echo json_encode($damage_counts);
    
    mysqli_free_result($count_result);

    // Query to get the total number of damage reports
    $sql_total_reports = 'SELECT COUNT(id) AS total_reports FROM damage_reports';
    $total_reports_result = mysqli_query($conn, $sql_total_reports);
    $total_reports = mysqli_fetch_assoc($total_reports_result)['total_reports'];

    mysqli_free_result($total_reports_result);

   // Query to fetch location reports
    $sql = "SELECT l.name AS location, COUNT(dr.id) AS count
    FROM damage_reports dr
    INNER JOIN locations l ON dr.location_id = l.id
    GROUP BY dr.location_id";

    $result = mysqli_query($conn, $sql);
    $location_reports = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_free_result($result);

    // Query to get count of requests per floor
    $sql = "SELECT floor, COUNT(*) AS num_requests FROM damage_reports GROUP BY floor";

    $result = mysqli_query($conn, $sql);

    // Create an associative array to store floor-wise request counts
    $floorRequests = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $floorRequests[$row['floor']] = $row['num_requests'];
    }

    mysqli_free_result($result);
    mysqli_close($conn);

    // Encode data to JSON format
    $locationReportsJson = json_encode($location_reports);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3"> Admin </div>
            </a><br>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="admin.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
        
            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="tables.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                
                <?php   include "admin-header.php";?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>                       
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Damage Reports</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $total_reports; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Damage Types</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    foreach ($damage_counts as $damage_count) {
                                                        echo $damage_count['type'] . ": " . $damage_count['count'] . "<br>";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-wrench fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Requests Per Floor
                                            </div class>
                                            <?php
                                                foreach ($floorRequests as $floor => $numRequests) {
                                                    echo '<div class="h5 mb-0 font-weight-bold text-gray-800">' .'Floor '. htmlspecialchars($floor) . ': ' . $numRequests . '</div>';
                                                }
                                            ?>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pending Requests</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Requests Overview</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">For more:</div>
                                            <a class="dropdown-item" href="tables.php">More Details</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Locations</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">For more:</div>
                                            <a class="dropdown-item" href="tables.php">View Details</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#" id="MA1">MA1 Maps</a>
                                            <a class="dropdown-item" href="#" id="MA4">MA4 Maps</a>
                                            <a class="dropdown-item" href="#" id="MA7">MA7 Maps</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> MA1
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> MA4
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> MA7
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script>
    document.getElementById('MA1').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default action of the link

        // Open a new window with specified dimensions
        window.open('https://shorturl.at/pmuWQ','_blank');
    });
    </script>

    <script>
    document.getElementById('MA4').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default action of the link

        // Open a new window with specified dimensions
        window.open('https://shorturl.at/2ZMJI','_blank');
    });
    </script>

    <script>
    document.getElementById('MA7').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default action of the link

        // Open a new window with specified dimensions
        window.open('https://shorturl.at/dVgtN','_blank');
    });
    </script>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>