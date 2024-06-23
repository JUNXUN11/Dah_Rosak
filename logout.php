<?php
session_start();

// Unset and destroy all session variables
session_unset();
session_destroy();

// Clear cookies by setting them to a past expiration date
if (isset($_COOKIE['user_id'])) {
    setcookie("user_id", "", time() - 3600, "/");
}
if (isset($_COOKIE['user_name'])) {
    setcookie("user_name", "", time() - 3600, "/");
}

// Redirect to homepage
header("Location: index.php");
exit();
?>