<?php

	include "getConnection.php";

  class GetData{
    var $dbconn;
    var $field;

    public function __construct($id)
    {
      $this->dbconn = getConnection();
      $this->field = array("uid"=>$id);
    }

    public function __destruct()
    {
      // pg_close($this->dbconn);
    }

    public function getUserDataFromID($id)
		{
			$field2 = array("uid"=>$id);
			if($result = pg_select($this->dbconn,"users",$field2))
			{
				return $result[0];
			}
			else
				return "Sorry, Couldn't get the user data";
		}

		public function getNameById($id)
		{
			$field2 = array("uid"=>$id);
			if($result = pg_select($this->dbconn,"users",$field2))
			{
				return $result[0]['username'];
			}
			else
				return 'Name';
		}

		public function getIdByUsername($username)
		{
			$field2 = array("username"=>$username);
			if($result = pg_select($this->dbconn,"users",$field2))
			{
				return $result[0]['id'];
			}
			else
				return $username;
		}

		public function getTeacherDetailForApproval()
		{
			$query = "select * from users where role = 'te' and approve = 'false';";
			if($result = pg_query($this->dbconn,$query))
			{
				return $result;
			}
		}

		public function getStudyMaterialMadeByMeById($type,$assignment)
		{
			//$query = "select * from users INNER JOIN (select * from studymaterial where send_from = ".$this->field['uid'].") ON studyMaterial.send_from = users.uid;";
			$query = "select * from users INNER JOIN studymaterial ON studyMaterial.send_from = users.uid where send_from=".$this->field['uid']." and type=".$type."and assignment=".$assignment.";" ;
			if($result = pg_query($this->dbconn,$query))
			{

				$result = pg_fetch_all($result);
				// print_r($result);
				return $result;
			}
			else {
				return false;
			}
		}
		public function getStudyMaterialForMeById()
		{
			$query = "select * from studymaterial where send_to = ".$this->field['uid'].";";
			if($result = pg_query($this->dbconn,$query))
			{
				$resultSendTo = getUserDataFromID($query['send_from']);//not right
				return $result;//don't know what result does the query sends and here i have to concat the $result with $resultSendTo
			}
			else {
				return false;
			}
		}

		public function getStudyMaterialForStudent($batch,$year,$type,$assignment)
		{
			$query = "select * from users INNER JOIN studymaterial ON studyMaterial.send_from = users.uid where studyMaterial.batch = ".$batch." and studyMaterial.year =  ".$year." and studyMaterial.type=".$type."and assignment=".$assignment.";";
			if($result = pg_query($this->dbconn,$query))
			{
				$result = pg_fetch_all($result);
				return $result;
			}
			else {
				return false;
			}
		}

		public function getSubjectWiseStudyMaterialForStudent($batch,$year)
		{
			 $query = "select * from subjectWiseStudyMaterial where batch = '".$batch."' and year = ".$year.";";
			 if($result = pg_query($this->dbconn,$query))
 			 {
 				 return $result;
 			 }
 			 else {
 				 return false;
 			 }
		}

		public function getSubjectWiseStudyMaterialForAdmin()
		{
			 $query = "select * from subjectWiseStudyMaterial;";
			 if($result = pg_query($this->dbconn,$query))
 			 {
 				 return $result;
 			 }
 			 else {
 				 return false;
 			 }
		}

		public function getMessages()
		{
			//all the messages the user received or send
			$query = "select * from message where send_from = ".$this->field['uid']." or send_to = ".$this->field['uid']." order by mid asc;";
			if($result = pg_query($this->dbconn,$query))
			{
				return $result;
			}
			else {
				return false;
			}
		}

		public function notify($batch,$year)
		{
			$query = "select * from notification where batch = '".$batch."' and year = ".$year." order by nid desc limit 5;";
			if($result = pg_query($this->dbconn,$query))
			{
				return $result;
			}
			else {
				return false;
			}
		}

  }

	class PostData{

		var $dbconn;
		var $field;

		public function __construct($id)
		{
			$this->dbconn = getConnection();
			$this->field = array("uid"=>$id);
		}

		public function __destruct()
		{
			// pg_close($this->dbconn);
		}

		public function changeProfilePic($userpic)
		{
			$data = array("profile_picture"=>$userpic);
			if(pg_update($this->dbconn,"users",$data,$this->field))
				return true;
			else
				return false;
		}

		public function changePassword($newPassword)
		{
			$data = array("password"=>$newPassword);

			if(pg_update($this->dbconn,"users",$data,$this->field))
			{
				return true;
			}
			else {
				return false;
			}
		}

		public function rejectTeacher($uid)
		{
			//here $uid is the uid of teacher
			$query = "delete from users where uid = ".$uid.";";
			$result = pg_query($this->dbconn,$query);
		}

		public function approveTeacher($uid)
		{
			//here $uid is the uid of teacher
			$query = "update users set approve = true where uid = ".$uid.";";
			$result = pg_query($this->dbconn,$query);
		}

		public function studyMaterial($content,$type,$approve,$batch,$year,$assignment,$senderRole)
		{
			//$content is the path or the name of the file and it is in string
			//$sendTo is the username of the person to be send-admin or teacher name
			//$type is img/vid/ppt/pdf
			//send_from is uid of the user which will be taken from $this->field
			//$approve is true if the send_From is the student or admin and it is false if the send_from is the techer
			//$senderRole is te or st
			if($senderRole == 'te')
			{
				$sendTo = 1;//uid of admin
			}
			if($senderRole == 'st')
			{
				$query1 = "select uid from users where username = ".$sendTo.";";
				if($sendTo = pg_query($this->dbconn,$query1))
				{
					$sendTo = $sendTo[0];
				}
			}



			$query = "insert into studyMaterial (content,send_to,send_from,type,approve,batch,year,assignment) values(".$content.",".$sendTo.",".$this->field['uid'].",".$type.",".$approve.",".$batch.",".$year.",".$assignment.");";
      // print_r($query);
      if($result = pg_query(getConnection(),$query))
			{
				return true;
			}
			else {
				return false;
			}
		}

		public function subjectWiseStudyMaterial($content,$subject,$topic,$batch,$year)
		{
			//$content is an array of text. It should be in the form {"-1.jpg","1.jpg"}
			$query = "insert into subjectwisestudymaterial (content,subject,topic,batch,year) values('".$content."','".$subject."','".$topic."','".$batch."',".$year.");";
			if($result = pg_query($this->dbconn,$query))
			{
				return true;
			}
			else {
				return false;
			}
		}

		public function messages($message,$sendToUsername)
		{
			$field2 = array("username"=>$sendToUsername);
			if($result = pg_select($this->dbconn,"users",$field2))
			{
				if($result != []){
					$send_to = $result[0]['uid'];
					print_r($send_to);
					$query = "insert into message (content,send_to,send_from) values('".$message."',".$send_to.",".$this->field['uid'].");";
					if($result1 = pg_query($this->dbconn,$query))
					{
						return true;
					}
					else {
						return false;
					}
				}
				else{
					return false;
				}
			}
			else
				return false;
		}

		public function deleteMessage($mid){
			$query = "delete from message where mid = ".$mid.";";
			if($result = pg_query($this->dbconn,$query))
			{
				return true;
			}
			else {
				return false;
			}
		}

		public function notification($message,$batch,$year)
		{
				$query = "insert into notification (content,send_from,batch,year) values('".$message."',".$this->field['uid'].",'".$batch."',".$year.");";
				if($result = pg_query($this->dbconn,$query))
				{
					return true;
				}
				else {
					return false;
				}
		}
	}

/*-- select * from notification where batch = 'ece' and year = 2013 order by nid desc limit 2;

-- insert into notification (content,send_from,batch,year) values('assignment not submitted',3,'cse',2013);

-- select * from message where send_from = 3 or send_to = 3;

-- insert into message (content,send_to,send_from) values('well do not know',5,3);

-- select * from subjectWiseStudyMaterial where batch = 'cse' and year = 2015;

-- insert into studymaterial (content,send_to,send_from,type,approve,batch,year,assignment) values('-1.jpg',4,3,'img',true,ece,2013,false);

-- select * from users INNER JOIN (select * from studymaterial where send_from = ".$this->field['uid'].";) ON studyMaterial.send_to = users.uid

-- insert into users (username,email,password,college_id,role,batch,year,approve,profile_picture)

-- insert into subjectwisestudymaterial (content,subject,topic,batch,year) values('{"-1.jpg","1.jpg"}','physics','thermodynamics','cse',2015);*/

?>
