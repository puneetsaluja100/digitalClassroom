<?php
	//include the file getConnection.php to connect to the postgres
	include "getConnection.php";
	//uid of admin should be 1
	function register($fields)
	{
		//calling the function from getConnection.php to establish connection
		$dbconn = getConnection();

		if($dbconn === "Connection Failed")
			$passErr = "Connection Failed";
		else
		{
			//check if the fields already exists
			$checkfields = array('email'=>$fields['email']);
			if($resultSelect = pg_select($dbconn,'users',$checkfields))
				return false;
			else if(pg_insert($dbconn,'users',$fields))
			{
				//Registered Successfully
				$resultSelect = pg_select($dbconn,'users',$checkfields);
				//make folders in /src/uploads by user id and make folders image, video, pdf, ppt
				if(mkdir("../../src/uploads/".$resultSelect[0]['uid'])){
					mkdir("../../src/uploads/".$resultSelect[0]['uid']."/image");
					mkdir("../../src/uploads/".$resultSelect[0]['uid']."/video");
					mkdir("../../src/uploads/".$resultSelect[0]['uid']."/pdf");
					mkdir("../../src/uploads/".$resultSelect[0]['uid']."/ppt");
					return true;
				}
			}
		}
	}
?>
