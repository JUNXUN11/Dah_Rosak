<?php

// Q1: establish connection to database using config.php
include 'db_conn.php';

// Q2: sql to create users
$sql = "INSERT INTO `user` (`id`, `username`, `password`, `email`, `created_at`, `role`) VALUES
(NULL, 'Amy', '$2y$10$.M9mzYWuq5JFRTP8qVhx/OD7LjJmitS0uI8TgOxO0XBNi3LUg2dlK', 'Amy@gmail.com', current_timestamp(), 'admin'),
(NULL, 'John', '$2y$10$.M9mzYWuq5JFRTP8qVhx/OD7LjJmitS0uI8TgOxO0XBNi3LUg2dlK', 'John@gmail.com', current_timestamp(), 'user'),
(NULL, 'Sara', '$2y$10$.M9mzYWuq5JFRTP8qVhx/OD7LjJmitS0uI8TgOxO0XBNi3LUg2dlK', 'Sara@gmail.com', current_timestamp(), 'user'),
(NULL, 'Mike', '$2y$10$.M9mzYWuq5JFRTP8qVhx/OD7LjJmitS0uI8TgOxO0XBNi3LUg2dlK', 'Mike@gmail.com', current_timestamp(), 'user'),
(NULL, 'Jane', '$2y$10$.M9mzYWuq5JFRTP8qVhx/OD7LjJmitS0uI8TgOxO0XBNi3LUg2dlK', 'Jane@gmail.com', current_timestamp(), 'user'),
(NULL, 'Tom', '$2y$10$.M9mzYWuq5JFRTP8qVhx/OD7LjJmitS0uI8TgOxO0XBNi3LUg2dlK', 'Tom@gmail.com', current_timestamp(), 'admin'),
(NULL, 'Lucy', '$2y$10$.M9mzYWuq5JFRTP8qVhx/OD7LjJmitS0uI8TgOxO0XBNi3LUg2dlK', 'Lucy@gmail.com', current_timestamp(), 'user'),
(NULL, 'Robert', '$2y$10$.M9mzYWuq5JFRTP8qVhx/OD7LjJmitS0uI8TgOxO0XBNi3LUg2dlK', 'Robert@gmail.com', current_timestamp(), 'user'),
(NULL, 'Emma', '$2y$10$.M9mzYWuq5JFRTP8qVhx/OD7LjJmitS0uI8TgOxO0XBNi3LUg2dlK', 'Emma@gmail.com', current_timestamp(), 'user'),
(NULL, 'Charlie', '$2y$10$.M9mzYWuq5JFRTP8qVhx/OD7LjJmitS0uI8TgOxO0XBNi3LUg2dlK', 'Charlie@gmail.com', current_timestamp(), 'admin'),
(NULL, 'Sophia', '$2y$10$.M9mzYWuq5JFRTP8qVhx/OD7LjJmitS0uI8TgOxO0XBNi3LUg2dlK', 'Sophia@gmail.com', current_timestamp(), 'user'),
(NULL, 'James', '$2y$10$.M9mzYWuq5JFRTP8qVhx/OD7LjJmitS0uI8TgOxO0XBNi3LUg2dlK', 'James@gmail.com', current_timestamp(), 'user'),
(NULL, 'Olivia', '$2y$10$.M9mzYWuq5JFRTP8qVhx/OD7LjJmitS0uI8TgOxO0XBNi3LUg2dlK', 'Olivia@gmail.com', current_timestamp(), 'user'),
(NULL, 'David', '$2y$10$.M9mzYWuq5JFRTP8qVhx/OD7LjJmitS0uI8TgOxO0XBNi3LUg2dlK', 'David@gmail.com', current_timestamp(), 'admin'),
(NULL, 'Lily', '$2y$10$.M9mzYWuq5JFRTP8qVhx/OD7LjJmitS0uI8TgOxO0XBNi3LUg2dlK', 'Lily@gmail.com', current_timestamp(), 'user'),
(NULL, 'Daniel', '$2y$10$.M9mzYWuq5JFRTP8qVhx/OD7LjJmitS0uI8TgOxO0XBNi3LUg2dlK', 'Daniel@gmail.com', current_timestamp(), 'admin'),
(NULL, 'Grace', '$2y$10$.M9mzYWuq5JFRTP8qVhx/OD7LjJmitS0uI8TgOxO0XBNi3LUg2dlK', 'Grace@gmail.com', current_timestamp(), 'user'),
(NULL, 'Chris', '$2y$10$.M9mzYWuq5JFRTP8qVhx/OD7LjJmitS0uI8TgOxO0XBNi3LUg2dlK', 'Chris@gmail.com', current_timestamp(), 'admin'),
(NULL, 'Hannah', '$2y$10$.M9mzYWuq5JFRTP8qVhx/OD7LjJmitS0uI8TgOxO0XBNi3LUg2dlK', 'Hannah@gmail.com', current_timestamp(), 'user'),
(NULL, 'Peter', '$2y$10$.M9mzYWuq5JFRTP8qVhx/OD7LjJmitS0uI8TgOxO0XBNi3LUg2dlK', 'Peter@gmail.com', current_timestamp(), 'user');
";

if ($conn->query($sql) === TRUE) {
  echo "users created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

mysqli_close($conn);
?>
