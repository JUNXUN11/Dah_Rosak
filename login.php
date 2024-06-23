<?php
session_start();
include("db_conn.php");

// Check if email and password are set in POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email']) && isset($_POST['password'])) {

    // Function to validate user input
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['email']);
    $pass = validate($_POST['password']);

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

            // Verify password
            if (password_verify($pass, $row['password'])) {
                // Login successful, set session variables
                $_SESSION['email'] = $row['email'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['name'] = $row['username'];

                // Set cookies that expire in 30 days
                setcookie("user_id", $row['id'], time() + (86400 * 30), "/");
                setcookie("user_name", $row['username'], time() + (86400 * 30), "/");

                // Redirect based on the role
                if ($row['role'] === 'admin') {
                    header("Location: admin.php");
                } else {
                    header("Location: index.php");
                }
                exit();
            } else {
                header("Location: loginpage.php?error=Incorrect Email or Password");
                exit();
            }
        } else {
            header("Location: loginpage.php?error=Incorrect Email or Password");
            exit();
        }
    } else {
        header("Location: loginpage.php?error=Database query failed");
        exit();
    }
} else {
    // If the request is not a POST request, do nothing or redirect to the login page
    header("Location: loginpage.php");
    exit();
}
?>
