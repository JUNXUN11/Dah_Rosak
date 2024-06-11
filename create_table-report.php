<?php

//Q1: establish connection to database using config.php
include 'db_conn.php';

//Q2: sql to create table
$sql = "CREATE TABLE damage(
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  firstname VARCHAR(30) NOT NULL,
  telephone VARCHAR(30) NOT NULL,
  location VARCHAR(255) NOT NULL,
  floor VARCHAR(30) NOT NULL,
  damage_type VARCHAR(255) NOT NULL,
  roomNum VARCHAR(30) NOT NULL,
  description VARCHAR(255),
  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";


if($conn->query($sql) === TRUE){
  echo "Table damage_report created successfully";
}else{
  echo "Error creating table: " . $conn->error;
}



mysqli_close($conn);
?>