<?php
	//include the file getConnection.php to connect to the postgres
	include "getConnection.php";

	//login
	function login($checkfields)
	{
		//calling the function from getConnection.php to establish connection
		$dbconn = getConnection();

		if($dbconn === "Connection Failed")
			$passErr = "Connection Failed";
		else if($result = pg_select($dbconn,'users',$checkfields))
		{
			//login done successfully
			return $result;
		}
		else
			return false;
	}
?>
