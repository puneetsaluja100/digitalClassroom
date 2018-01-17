<?php
	include "getConnection.php";
//uid of admin should be 1
	function register($fields)
	{
		$dbconn = getConnection();

		if($dbconn === "Connection Failed")
			$passErr = "Connection Failed";
		else
		{
			$checkfields = array('email'=>$fields['email']);
			if($resultSelect = pg_select($dbconn,'users',$checkfields))
				return false;
			else if(pg_insert($dbconn,'users',$fields))
			{
				$resultSelect = pg_select($dbconn,'users',$checkfields);
				// if($fields['role'] == 'st'){
				// 	//add student details in groupStudent table
				// 	$query = "select gid from groupStudent where year ==".$fields['year']."and batch ==".$fields['batch'] ;
				// 	$result = pg_query($dbconn,$query);
				// 	if($result == []){
				// 		$params['year']=$resultSelect['year'];
				// 		$params['batch']=$resultSelect['batch'];
				// 		$params['uid'][0]=$resultSelect['uid'];
				// 		if(pg_insert($dbconn,'groupStudent',$params))
				// 		{
				// 			return true;
				// 		}
				// 		else{
				// 			return false;
				// 		}
				// 	}
				// 	else{
				// 		$query = "update groupStudent set uid = uid || '{".$resultSelect['uid']."}' where gid = ".$result['gid'];
				// 		$resultUpdation = pg_query($dbconn,$query);
				// 	}
				// }
				// print_r($resultSelect);
				if(mkdir("./src/uploads/".$resultSelect[0]['uid']))
					return true;
			}
		}
	}
?>
