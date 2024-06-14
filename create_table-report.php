<?php
// Q1: establish connection to database using config.php
include 'db_conn.php';

// Array of SQL statements to create tables
$sql_statements = [   
    "CREATE TABLE locations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL
    )",
    
    "CREATE TABLE damage_types (
        id INT AUTO_INCREMENT PRIMARY KEY,
        type VARCHAR(255) NOT NULL
    )",
     
    "CREATE TABLE damage_reports (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL,
        firstname VARCHAR(30) NOT NULL,
        telephone VARCHAR(30) NOT NULL,
        location_id INT NOT NULL,
        floor VARCHAR(30) NOT NULL,
        damage_type_id INT NOT NULL,
        roomNum VARCHAR(30) NOT NULL,
        description VARCHAR(255),
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        user_id INT NOT NULL,
        status BOOLEAN DEFAULT 0,
        FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
        FOREIGN KEY (location_id) REFERENCES locations(id) ON DELETE CASCADE,
        FOREIGN KEY (damage_type_id) REFERENCES damage_types(id) ON DELETE CASCADE      
    )"
];

// Execute each SQL statement
foreach ($sql_statements as $sql) {
    if ($conn->query($sql) === TRUE) {
        echo "Table created successfully: " . $sql . "<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }
}

mysqli_close($conn);
?>
