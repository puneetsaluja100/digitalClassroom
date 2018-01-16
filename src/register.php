<?php
	include "getConnection.php";

	function register($fields)
	{
		$dbconn = getConnection();

		if($dbconn === "Connection Failed")
			$passErr = "Connection Failed";
		else
		{
			$checkfields = array('username'=>$fields['username']);
			if($resultSelect = pg_select($dbconn,'user',$checkfields))
				return false;
			else if(pg_insert($dbconn,'user',$fields))
			{
				$resultSelect = pg_select($dbconn,'user',$checkfields);
				print_r($resultSelect);
				if(mkdir("../src/uploads/".$resultSelect[0]['uid']))
					return true;
			}
		}
	}
?>
