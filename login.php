<?php
	require_once __DIR__ . '/db_connect.php';
	
	include 'authenticate.php';
	
	$db = new DB_CONNECT();
	
	$response = array();
	
	if(isset($_POST['email']) && isset($_POST['password']))
	{
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		//$user = $db
		$result = mysql_query("SELECT * FROM accounts WHERE email = '$email'");
		
		if(!empty($result))
		{
			if(mysql_num_rows($result) > 0)
			{
				$result = mysql_fetch_array($result);
				
				$salt = $result["salt"];
				$encrypted_password = stripcslashes($result["password"]);
				$hash = base64_encode(sha1($password . $salt, true) . $salt);
				
				if($encrypted_password == $hash)
				{
					$account = array();
					$account["id"] = $result["id"];
					$account["email"] = $result["email"];
					$account["name"] = $result["name"];
					//$account["gender"] = $result["gender"];
					//$account["height"] = $result["height"];
					//$account["weight"] = $result["weight"];
					//$account["build"] = $result["build"];
					$account["auth"] = authenticate($account["email"]);
					
					//success
					$response["success"] = 1;
					
					//user node
					$response["login"] = array();
					
					array_push($response["login"], $account);
					
					//echoing JSON response
					echo json_encode($response);
				}
				else
				{
					//no account found, so report it and echo JSON response
					$response["success"] = 0;
					$response["message"] = "Invalid password";
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
		$response["message"] = "You failed to provide an email and password";
		echo json_encode($response);
	}
?>