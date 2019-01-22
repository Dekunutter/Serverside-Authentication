<?php
	//Get an account's information from the database
	
	//array for JSON response
	$response = array();
	
	//include the db_connect class for initializing a connection to the database
	require_once __DIR__ . '/db_connect.php';
	
	//connect to the database
	$db = new DB_CONNECT();
	
	//check for post data
	if(isset($_GET["id"]))
	{
		$id = $_GET['id'];
		
		//get an account from the accounts table
		$result = mysql_query("SELECT * FROM accounts WHERE id = '$id'");
		
		//if a result was found
		if(!empty($result))
		{
			//sanity check to ensure that the result was not empty
			if(mysql_num_rows($result) > 0)
			{
				$result = mysql_fetch_array($result);
				
				$account = array();
				$account["id"] = $result["id"];
				$account["email"] = $result["email"];
				$account["name"] = $result["name"];
				$account["gender"] = $result["gender"];
				$account["height"] = $result["height"];
				$account["weight"] = $result["weight"];
				$account["build"] = $result["build"];
				
				//success
				$response["success"] = 1;
				
				//user node
				$response["account"] = array();
				
				array_push($response["account"], $account);
				
				//echoing JSON response
				echo json_encode($response);
			}
			else
			{
				//no account found, so report it and echo JSON response
				$response["success"] = 0;
				$response["message"] = "No account found.";
				echo json_encode($response);
			}
		}
		else
		{
			//no account found, so report it and echo JSON response
			$response["success"] = 0;
			$response["message"] = "No account found.";
			echo json_encode($response);
		}
	}
	else
	{
		//a required field in the table is missing, so report it and echo JSON response
		$response["success"] = 0;
		$response["message"] = "Required field(s) are missing from accounts table";
		echo json_encode($response);
	}
?>