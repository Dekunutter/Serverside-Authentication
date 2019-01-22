<?php
	//delete an account from the accounts table identified by email
	
	//array for JSON response
	$response = array();
	
	//check for required fields
	if(isset($_POST['email']))
	{
		$email = $_POST['email'];
		
		//include the db_connect class for initializing database connections
		require_once __DIR__ . '/db_connect.php';
		
		//connect to the database
		$db = new DB_CONNECT();
		
		//update row with matching email address
		$result = mysql_query("DELETE FROM accounts WHERE email = $email");
		
		//check if row was deleted or not
		if(mysql_affected_rows() > 0)
		{
			//success
			$response["success"] = 1;
			$response["message"] = "Product successfully deleted.";
			echo json_encode($response);
		}
		else
		{
			//no account was found
			$response["success"] = 1;
			$response["message"] = "No account found.";
			echo json_encode($response);
		}
	}
	else
	{
		//a required field in the table is missing, so report it and echo JSON response
		$response["success"] = 1;
		$response["message"] = "Required field(s) are missing from accounts table";
		echo json_encode($response);
	}
?>