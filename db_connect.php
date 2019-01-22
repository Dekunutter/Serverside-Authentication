<?php
	//class for connecting to a database
	class DB_CONNECT
	{
			//constructor to initialize connection to a database
			function __construct()
			{
				$this->connect();
			}
			
			//destructor to close connection to a database
			function __destruct()
			{
				$this->close();
			}
			
			//connect to a database
			function connect()
			{
				//import database connection variables from the db_config file
				require_once __DIR__ . '/db_config.php';
				
				//connect to the database server
				$con = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die(mysql_error());
				
				//select the database to connect to on the server
				$db = mysql_select_db(DB_DATABASE) or die(mysql_error()) or die(mysql_error());
				
				return $con;
			}
			
			//close the database connection
			function close()
			{
				mysql_close();
			}
	}
?>