<?php
include "../../src/query.php";
session_start();
$uid = $_SESSION['id'];
$query_get = new GetData($uid);
$query_post = new PostData($uid);

if(isset($_POST['updatePassword']))
{

    $password = getCorrectInput($_POST["password"]);
    $salt = sha1(md5($password));
    $password = md5($salt.$password);
    $result = $query_post->changePassword($password);
    if($result)
    {
      echo '<script language="javascript">';
      echo 'alert("Password Successfully changed")';
      echo '</script>';
    }
    else{
      echo '<script language="javascript">';
      echo 'alert("Sorry Unable to reset password")';
      echo '</script>';
    }


}

if(isset($_POST['updateImage']))
{
    $target_dir = "../../image/";
    $target_file = $target_dir.basename($_FILES["image"]["name"]);
    $content = $_FILES["image"]["name"];
    $result = $query_post->changeProfilePic($content);
    if($result)
    {
      if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        echo '<script language="javascript">';
        echo 'alert("Profile Picture Uploaded")';
        echo '</script>';
      } else {
          echo "Sorry, there was an error uploading your file.";
      }
    }
    else{
      echo '<script language="javascript">';
      echo 'alert("Sorry Unable to change profile picture")';
      echo '</script>';
    }
}


function getCorrectInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
 ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
    <link rel="stylesheet" media="screen and (min-width: 1000px)" href="../css/style.css">
    <link rel="stylesheet" media="screen and (max-width: 1000px)" href="../css/mobile.css" />
    <style>
    .mybutton {
        background-color: transparent;
        transition-duration: 0.4s;
        width: 150px;
        height: 50px;
        color: white;
        border-width: thin;
        text-align: center;
        border-radius: 12px;
    }
    </style>
</head>
<body >
<div style="height:10%"></div>
<div>
    <div class="mycard" style="background-color:	#5BECB7;height: 650px;width: 600px">
      <div style="height:400px" >
        <div style="height: 200px;text-align:center">
            <img src="../../image/logo.png" style="max-height: 100%;max-width: 100%" alt="logo">
        </div>
        <form class="login" enctype='multipart/form-data' action="" method="post" style="text-align: center;padding:50px 100px">
            <input class="form-control" name="image" id='image' type="file" placeholder="Select Image"  required><br>
            <button class="mybutton" style="background-color: 	#FF6347" name="updateImage" type="submit">Update</button>
        </form>
      </div>
      <div style="height:250px;background-color:#7a7a7a">
        <form class="login" action="" method="post" style="text-align: center;padding:50px 100px">
            <input class="form-control" name="password" type="password" placeholder="#password"  required><br>
            <input class="form-control" name="cpassword" type="password" placeholder="#confirm-password" required><br>
            <button class="mybutton" style="background-color: 	#FF6347" name="updatePassword" type="submit">Update</button>
        </form>
      </div>
    </div>
</div>
<div style="height: 5%"></div>
</body>
</html>
