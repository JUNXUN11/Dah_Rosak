<?php
session_start();
include("db_conn.php");

// Check if email, password, and role are set in POST request
if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['selected_role'])) {

    // Function to validate user input
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['email']);
    $pass = validate($_POST['password']);
    $role = validate($_POST['selected_role']);

    // Check if email or password is empty
    if (empty($email) && empty($pass)) {
        header("Location: loginpage.php?error=Email and Password are required");
        exit();
    } else if (empty($email)) {
        header("Location: loginpage.php?error=Email is required");
        exit();
    } else if (empty($pass)) {
        header("Location: loginpage.php?error=Password is required");
        exit();
    } else if (empty($role)) {
        header("Location: loginpage.php?error=Role is required");
        exit();
    }

    // SQL query to check if the user exists
    $sql = "SELECT * FROM user WHERE email=?";

    // Prepare and execute the query
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Check if the query returns exactly one row
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            // Check password based on role
            $passwordVerified = false;
            if ($role === 'user') {
                $passwordVerified = password_verify($pass, $row['password']);
            } else if ($role === 'admin' && $pass === $row['password']) {
                $passwordVerified = true;
            }

            if ($passwordVerified && $role === $row['role']) {
                // Login successful, set session variables
                $_SESSION['email'] = $row['email'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['name'] = $row['username'];

                // Redirect based on the role
                if ($role === 'admin') {
                    header("Location: admin.php");
                } else if ($role === 'user') {
                    header("Location: index.php");
                }
                exit();
            } else {
                header("Location: loginpage.php?error=Incorrect Username, Password, or Role");
                exit();
            }
        } else {
            header("Location: loginpage.php?error=Incorrect Username, Password, or Role");
            exit();
        }
    } else {
        header("Location: loginpage.php?error=Database query failed");
        exit();
    }
} else {
    header("Location: loginpage.php?error=All fields are required");
    exit();
}


