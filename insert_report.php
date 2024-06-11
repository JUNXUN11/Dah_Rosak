<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Guest</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>

	  <?php

        
	    $firstName = $_POST['firstname'];
		$tel = $_POST['tel'];
		$location = $_POST['location'];
        $floor = $_POST['floor'];
        $damage_type = $_POST['damage_type'];
        $roomNum = $_POST['roomNum'];
        $description = $_POST['description'];


	    
		require_once ('db_conn.php');


	    $sql = "INSERT INTO damage 
        (firstname, telephone, location, floor, damage_type, roomNum, description ) VALUES 
		('$firstName', '$tel', '$location', '$floor', '$damage_type', '$roomNum', '$description')";

		if (mysqli_query($conn, $sql)) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

	     mysqli_close($conn);
	   ?>

	   <BR><BR>
	   <a href="index.php">Click here to list the guests</a>

</body>
</html>