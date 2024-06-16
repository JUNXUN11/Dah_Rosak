<?php  

session_start();
include('db_conn.php');

if(isset($_POST['register'])){
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 'user';

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (username,password,email,role) VALUES('$username','$hashed_password','$email','$role')";
    
    $result = mysqli_query($conn,$sql);

    if($result){      
        echo"<script>
        alert(
            'Registration Successful! Please login to continue.'
        );
        window.location.href='index.php';
        </script>";   
    }
    else{
        die(mysqli_error($conn)) ;
    }
}
