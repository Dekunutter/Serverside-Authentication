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
				//no account found, so report it and echo JSON response
				$response["success"] = 0;
				$response["message"] = "Account associated with this email address already exists";
				echo json_encode($response);
			}
			else
			{
				$salt = sha1(rand());
				$salt = substr($salt, 0, 10);
				$encrypted_password = base64_encode(sha1($password . $salt, true) . $salt);
				
				$result = mysql_query("INSERT INTO accounts(email, password, salt) VALUES('$email', '$encrypted_password', '$salt')") or die(mysql_error());
				if($result)
				{
					$result = mysql_query("SELECT * FROM accounts WHERE email = '$email'");
					if(!empty($result))
					{
						if(mysql_num_rows($result) > 0)
						{
							$result = mysql_fetch_array($result);
							
							$account = array();
							$account["id"] = $result["id"];
							$account["email"] = $result["email"];
							$account["name"] = $result["name"];
							//$account["gender"] = $result["gender"];
							//$account["height"] = $result["height"];
							//$account["weight"] = $result["weight"];
							//$account["build"] = $result["build"];
							$account["auth"] = authenticate($account["email"]);
							
							$response["success"] = 1;
					
							//user node
							$response["register"] = array();
							
							array_push($response["register"], $account);
							
							//echoing JSON response
							echo json_encode($response);
						}
						else
						{
							//no account found, so report it and echo JSON response
							$response["success"] = 0;
							$response["message"] = "Account not found after registration.";
							echo json_encode($response);
						}
					}
					else
					{
						//no account found, so report it and echo JSON response
						$response["success"] = 0;
						$response["message"] = "Account not found after registration.";
						echo json_encode($response);
					}
				}
				else
				{
					//no account found, so report it and echo JSON response
					$response["success"] = 0;
					$response["message"] = "Failed to register user.";
					echo json_encode($response);
				}
			}
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