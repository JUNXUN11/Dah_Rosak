<?php

//Q1: call config.php to open connection to database before performing SELECT
require_once ('db_conn.php');

//Q2: access the fieldname id using POST or GET method?
/*
    POST method?
    GET method?
    review guest_list-s.php and see how are the fieldname id is passed to edit-guest-s.php
*/
$id = $_GET['id'];

$sql = "SELECT * FROM user WHERE id = $id";
$result = mysqli_query($conn, $sql);

//Q3: perform retrieving data from table myguests according to fieldname id
            
            if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) 
            {
                //Q4: get all the fieldnames from the selected row
                $firstname = $row['username'];
                $email = $row['email'];               
            }
        }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Profile with Data and Skills - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        body {
            margin-top: 20px;
            color: #1a202c;
            text-align: left;
            background-color: #e2e8f0;
        }
        .main-body {
            padding: 15px;
        }
        .card {
            box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
        }
        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0,0,0,.125);
            border-radius: .25rem;
        }
        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="main-body">
            <nav aria-label="breadcrumb" class="main-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                </ol>
            </nav>
            <div class="row gutters-sm">
                
            <!--PROFILE CARD-->
                <div class="col-md-4 mb-3">                  
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
                                <div class="mt-3">
                                   
                                </div>
                            </div>
                        </div>
                    </div>                  
                </div>
            <!-- END OF PROFILE CARD-->

                <div class="col-md-8">
                    <form method="post" action="edit_profile.php">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Full Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="firstName" value="<?php echo $firstname;?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="email" value="<?php echo $email;?>">
                                    </div>
                                </div>
                                <hr><br><br>                    
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>