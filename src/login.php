<?php
	include "getConnection.php";

	function login($checkfields)
	{
		$dbconn = getConnection();

		if($dbconn === "Connection Failed")
			$passErr = "Connection Failed";
		else if($result = pg_select($dbconn,'user',$checkfields))
		{
			return $result;
		}
		else
			return false;
	}
?>
