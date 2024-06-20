<?php 

$sname = "localhost"; // Server name
$uname = "root";    // Username
$password = ""; // Password
$db_name = "dah_rosak";  // Database name
$port = 8000; // MySQL port

// Create connection
$conn = mysqli_connect($sname, $uname, $password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully";

