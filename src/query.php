<?php

	include "getConnection.php";

//the class GetData gets the required data from the database by selection
  class GetData{
    var $dbconn;
    var $field;

    public function __construct($id)
    {
			//constructor to connect to postgres and putting the session id of the user in the variable $field
      $this->dbconn = getConnection();
      $this->field = array("uid"=>$id);
    }

    public function __destruct()
    {
			//destructor
      // pg_close($this->dbconn);
    }

		//get any user data from user's id
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

		//get username of any user by id
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

		//get user id from the username
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

		//get all the teacher's information who has not been approved yet by admin and show it on admin's page
		public function getTeacherDetailForApproval()
		{
			$query = "select * from users where role = 'te' and approve = 'false';";
			if($result = pg_query($this->dbconn,$query))
			{
				$result = pg_fetch_all($result);
				return $result;
			}
		}

		//get study material the user in session made and uploaded by user id
		public function getStudyMaterialMadeByMeById($type,$assignment)
		{
			$query = "select * from users INNER JOIN studymaterial ON studyMaterial.send_from = users.uid where send_from=".$this->field['uid']." and type=".$type." and assignment=".$assignment.";" ;
			//print_r($query);
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

		//get study material for the user in session by user id
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

		//get all the study material for student for given branch and year
		public function getStudyMaterialForStudent($batch,$year,$type,$assignment)
		{
			$query = "select * from users INNER JOIN studymaterial ON studyMaterial.send_from = users.uid where studyMaterial.approve=true and studyMaterial.batch = ".$batch." and studyMaterial.year =  ".$year." and studyMaterial.type=".$type."and assignment=".$assignment.";";
			if($result = pg_query($this->dbconn,$query))
			{
				$result = pg_fetch_all($result);
				return $result;
			}
			else {
				return false;
			}
		}

		//get study material for admin to approve
		public function getStudyMaterialForAdmin()
		{
			$query = "select * from users INNER JOIN studymaterial ON studyMaterial.send_from = users.uid where studyMaterial.approve = false and studyMaterial.assignment = false;";
			if($result = pg_query($this->dbconn,$query))
			{
				$result = pg_fetch_all($result);
				return $result;
			}
			else {
				return false;
			}
		}

		//get subject wise study material made by admin for students
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

		//get subject wise study material to show it to admin
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

		//get messages for discussion portal
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

		//notify the users on the basis if branch and year
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

		//get the quiz details on the basis of batch and year
		public function getQuizDetail($batch,$year)
		{
			$query = "select * from quizdetail where batch = ".$batch." and year = ".$batch.";";
			if($result = pg_query($this->dbconn,$query))
			{
				return $result;
			}
			else {
				return false;
			}
		}

		//get the quiz questions for a particular topic
		public function getQuizQuestion($hid)
		{
			$query = "select * from quizquestion where hid = ".$hid.";";
			if($result = pg_query($this->dbconn,$query))
			{
				return $result;
			}
			else {
				return false;
			}
		}

		//get response the student made for a particular question
		public function getQuizUserResponse($qid)
		{
			$query = "select * from quizuserresponse where qid = ".$qid.";";
			if($result = pg_query($this->dbconn,$query))
			{
				return $result;
			}
			else {
				return false;
			}
		}

  }

//the class PostData inserts the given data into the database
	class PostData{

		var $dbconn;
		var $field;

		public function __construct($id)
		{
			//constructor to connect to postgres and putting the session id of the user in the variable $field
			$this->dbconn = getConnection();
			$this->field = array("uid"=>$id);
		}

		public function __destruct()
		{
			//destructor
			// pg_close($this->dbconn);
		}

		//change the profile picture
		public function changeProfilePic($userpic)
		{
			$data = array("profile_picture"=>$userpic);
			if(pg_update($this->dbconn,"users",$data,$this->field))
				return true;
			else
				return false;
		}

		//change password
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

		//reject teacher by admin so that the teacher cann't login
		public function rejectTeacher($uid)
		{
			//here $uid is the uid of teacher
			$query = "delete from users where uid = ".$uid.";";
			$result = pg_query($this->dbconn,$query);
			return $result;
		}

		//approve teacher and let her login
		public function approveTeacher($uid)
		{
			//here $uid is the uid of teacher
			$query = "update users set approve = true where uid = ".$uid.";";
			$result = pg_query($this->dbconn,$query);
			return $result;
		}

		//approve study material by the admin as before going to students the admin should approve it
		public function approveStudyMaterial($sid)
		{
			$query = "update studyMaterial set approve = true where sid = ".$sid.";";
			$result = pg_query($this->dbconn,$query);
			return $result;
		}

		//reject study material by admin
		public function rejectStudyMaterial($sid)
		{
			$query = "delete from studyMaterial where sid = ".$sid.";";
			$result = pg_query($this->dbconn,$query);
			return $result;
		}

		//send the study material information
		public function studyMaterial($content,$type,$approve,$batch,$year,$assignment,$senderRole,$sendTo)
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

			}

			$query = "insert into studyMaterial (content,send_to,send_from,type,approve,batch,year,assignment) values(".$content.",".$sendTo.",".$this->field['uid'].",".$type.",".$approve.",".$batch.",".$year.",".$assignment.");";
			if($result = pg_query(getConnection(),$query))
			{
				return true;
			}
			else {
				return false;
			}
		}

		//insert into subject wise study material
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

		//insert into the table message
		public function messages($message,$sendToUsername)
		{
			$field2 = array("username"=>$sendToUsername);
			if($result = pg_select($this->dbconn,"users",$field2))
			{
				if($result != []){
					$send_to = $result[0]['uid'];
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

		//delete the message from the table message
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

		//insert notification into the table
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

	//insert quiz information
	public function quizDetail($subject,$topic,$batch,$year,$timeDuration)
	{
		$query = "insert into quizdetail (subject,topic,batch,year,made_by,timeduration,launch) values('".$subject."','".$topic."','".$batch."',".$year.",".$this->field['uid'].",".$timeDuration.",false);";
		if($result = pg_query($this->dbconn,$query))
		{
			return true;
		}
		else {
			return false;
		}
	}

	//launch the quiz
	public function launch()
	{
		$query = "update quizdetail set launch = true;";
		if($result = pg_query($this->dbconn,$query))
		{
			return true;
		}
		else {
			return false;
		}
	}

	//insert into quiz question
	public function quizQuestion($hid,$question,$op1,$op2,$op3,$op4,$correctOption)
	{
		$query = "insert into quizquestion (hid,question,option1,option2,option3,option4,correct_option) values(".$hid.",'".$question."','".$op1."','".$op2."','".$op3."','".$op4."','".$correctOption."');";
		if($result = pg_query($this->dbconn,$query))
		{
			return true;
		}
		else {
			return false;
		}
	}
	//insert into quiz user response
	public function quizUserResponse($qid,$hid,$answerOption)
	{
		$query = "insert into quizuserresponse (qid,hid,answeroption,uid) values(".$qid.",".$hid.",'".$answerOption."',".$this->field['uid'].");";
		if($result = pg_query($this->dbconn,$query))
		{
			return true;
		}
		else {
			return false;
		}
	}

	//update the student's answer
	public function updateUserQuizResponse($aid,$answerOption)
	{
		$query = "update quizuserresponse set answeroption = ".$answerOption." where aid = ".$aid.";";
		if($result = pg_query($this->dbconn,$query))
		{
			return true;
		}
		else {
			return false;
		}
	}
}
?>
