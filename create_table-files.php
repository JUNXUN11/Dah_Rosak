<?php

// Q1: establish connection to database using config.php
include 'db_conn.php';

// Q2: sql to create table
$sql = "CREATE TABLE files (
    report_id INT(6) UNSIGNED AUTO_INCREMENT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_type ENUM('picture', 'video') NOT NULL,
    FOREIGN KEY (report_id) REFERENCES damage_reports(id) ON DELETE CASCADE
);";

if ($conn->query($sql) === TRUE) {
  echo "Table user created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

mysqli_close($conn);
?>
