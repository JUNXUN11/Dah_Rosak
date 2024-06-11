<?php

// Q1: establish connection to database using config.php
include 'db_conn.php';

// Q2: sql to create table
$sql = "CREATE TABLE user(
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL, 
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  role VARCHAR(255) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
  echo "Table user created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

mysqli_close($conn);
?>
