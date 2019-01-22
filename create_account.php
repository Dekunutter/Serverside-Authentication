<?php
	//Create a new row in the account table, reading the details from a HTTP post request
	
	
	//array to store response
	$response = array();
	
	//check that the required fields exist in the table before continuing
	if(isset($_POST['email'] && isset($_POST['name'] && isset($_POST['gender'] && isset($_POST['height'] && isset($_POST['weight'] && isset($_POST['build'])
	{
		$email = $_POST['email'];
		$name = $_POST['name'];
		$gender = $_POST['gender'];
		$height = $_POST['height'];
		$weight = $_POST['weight'];
		$build = $_POST['build'];
		
		//include the class for initializing a database connection
		require_once __DIR__ . '/db_connect.php';
		
		//connect to the database
		$db = new DB_CONNECT();
		
		//insert a new row into the accounts table
		$result = mysql_query("INSERT INTO accounts(email, name, gender, height, weight, build) VALUES('$email', '$name', '$gender', '$height', '$weight', '$build')");
		
		//check to see if the row was inserted or not
		if($result)
		{
			//insertion was successful, so report it and echo JSON response
			$response["success"] = 1;
			$response["message"] = "Account successfully created.";
			echo json_encode($response);
		}
		else
		{
			//insertion failed, so report it and echo JSON response
			$response["success"] = 0;
			$response["message"] = "An error occured writing to the accounts table.";
			echo json_encode($response);
		}
	}
	else
	{
		//a required field in the table is missing, so report it and echo JSON response
		$response["success"] = 0;
		$response["message"] = "Required field(s) are missing from account insertion.";
		echo json_encode($response);
	}
?>