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

    // Query to get the total number of solved reports
    $sql_solved_reports = 'SELECT COUNT(id) AS solved_reports FROM damage_reports WHERE status = 1';
    $solved_reports_result = mysqli_query($conn, $sql_solved_reports);
    $solved_reports = mysqli_fetch_assoc($solved_reports_result)['solved_reports'];

    // Query to get the total number of unsolved reports
    $sql_unsolved_reports = 'SELECT COUNT(id) AS unsolved_reports FROM damage_reports WHERE status = 0';
    $unsolved_reports_result = mysqli_query($conn, $sql_unsolved_reports);
    $unsolved_reports = mysqli_fetch_assoc($unsolved_reports_result)['unsolved_reports'];

    mysqli_free_result($solved_reports_result);
    mysqli_free_result($unsolved_reports_result);

    // Create an associative array to store floor-wise request counts
    $floorRequests = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $floorRequests[$row['floor']] = $row['num_requests'];
    }

    mysqli_free_result($result);

    // Query to get the count of requests received today
    $current_date = date('Y-m-d');
    $sql_requests_today = "SELECT COUNT(*) AS requests_today
                        FROM damage_reports
                        WHERE DATE(reg_date) = '$current_date'";

    $requests_today_result = mysqli_query($conn, $sql_requests_today);
    $requests_today = mysqli_fetch_assoc($requests_today_result)['requests_today'];

    mysqli_free_result($requests_today_result);

    // Query to get the number of reports with a description
    $sql_reports_with_description = "SELECT COUNT(id) AS reports_with_description FROM damage_reports WHERE description IS NOT NULL AND TRIM(description) != ''";
    $reports_with_description_result = mysqli_query($conn, $sql_reports_with_description);
    $reports_with_description = mysqli_fetch_assoc($reports_with_description_result)['reports_with_description'];

    mysqli_free_result($reports_with_description_result);

    //Get date for chart
    $query = "SELECT DATE(reg_date) AS report_date, COUNT(*) AS num_reports 
          FROM damage_reports
          GROUP BY report_date
          ORDER BY report_date";
    
    $result = mysqli_query($conn, $query);

    // Prepare the data for the chart
    $labels = array();
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $labels[] = $row['report_date'];
        $data[] = $row['num_reports'];
    }

    // Query to fetch location reports
    $sql = "SELECT l.name AS location, COUNT(dr.id) AS count
    FROM damage_reports dr
    INNER JOIN locations l ON dr.location_id = l.id
    GROUP BY dr.location_id";

    $result = mysqli_query($conn, $sql);
    $location_reports = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_free_result($result);

    //Query for building name
    $sql = "SELECT SUBSTRING_INDEX(l.name, '-', 1) AS building, COUNT(dr.id) AS count
    FROM damage_reports dr
    INNER JOIN locations l ON dr.location_id = l.id
    GROUP BY building";

    $result = mysqli_query($conn, $sql);
    $building_reports = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_free_result($result);

    // Prepare the data for the pie chart
    $building_labels = array();
    $building_data = array();

    foreach ($building_reports as $report) {
        $building_labels[] = $report['building'];
        $building_data[] = $report['count'];
    }

    // Prepare the data for the pie chart
    $location_labels = array();
    $location_data = array();

    foreach ($location_reports as $report) {
    $location_labels[] = $report['location'];
    $location_data[] = $report['count'];
    }
    
    mysqli_close($conn);

    // Encode data to JSON format
    $locationReportsJson = json_encode($location_reports);
    $labelsJson = json_encode($labels);
    $dataJson = json_encode($data);
    $locationLabelsJson = json_encode($location_labels);
    $locationDataJson = json_encode($location_data);
    $buildingLabelsJson = json_encode($building_labels);
    $buildingDataJson = json_encode($building_data);
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

                        <!-- Total damage reports -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Requests</div>
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

                        <!-- Number of reports per damage tyoe -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Solved Requests</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    echo $solved_reports;
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

                        <!-- Number of reports per floor -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Unsolved Requests</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                                echo $unsolved_reports;
                                            ?>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reports with description -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Today's Requests</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $requests_today; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-pen fa-2x text-gray-300"></i>
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
                                            <a class="dropdown-item" href="#" id="maps">To Find Location</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                    <?php
                                        $colors = array('#4e73df', '#1cc88a', '#36b9cc','#5a5cdd','#17a589','#33b1c7','#7a81e0','#2ed573','#74b9ff','#e17055','#fdcb6e');
                                        $i = 0;
                                        foreach ($building_labels as $label) {
                                            echo '<span class="mr-2"><i class="fas fa-circle" style="color: ' . $colors[$i] . ';"></i> ' . $label . '</span>';
                                            $i = ($i + 1) % count($colors);
                                        }
                                    ?>
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
                        <span>Copyright &copy; Your Website 2024</span>
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
    document.getElementById('maps').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default action of the link

        // Open a new window with specified dimensions
        window.open('https://www.google.com/maps','_blank');
    });
    </script>

    <script>
        var labelsData = <?php echo $labelsJson; ?>;
        var chartData = <?php echo $dataJson; ?>;
        var locationLabels = <?php echo $locationLabelsJson; ?>;
        var locationData = <?php echo $locationDataJson; ?>;
        var buildingLabels = <?php echo $buildingLabelsJson; ?>;
        var buildingData = <?php echo $buildingDataJson; ?>;
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