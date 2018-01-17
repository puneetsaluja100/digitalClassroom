<?php

  if(isset($_POST['submitStudyMaterial']))
  {
  $batch = "'".$_POST["batch"]."'";
  $year = "'".$_POST["year"]."'";
  $senderRole = 'te';
  $sendTo = 1;
  $assignment = 'false';
  $approve = 'false';
  $type = "'".(string)$_POST["type"]."'";
  $content = "'../../src/uploads/'";

  include "../../src/query.php";


  $query = new PostData($_SESSION['id']);
  $result = $query->studyMaterial($content,$sendTo,$type,$approve,$batch,$year,$assignment,$senderRole);


  if($result === true)
  {
    echo "yes";
  }
  else if($result === false)
  {

  }

}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dashboard</title>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/style_dashboard.css">
  <script>
  /* Set the width of the side navigation to 250px */
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function logout() {
  session_unset();
}

/* Set the width of the side navigation to 0 */
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

function goToVideos()
{

}

function showStudyMaterial(){

    document.getElementById('study').style.visibility = "visible";

}

  </script>

</head>

<body>

  <nav class="navbar navbar-inverse bg-inverse">

      <span class="nav navbar-nav navbar-left" onclick="openNav()" style="font-size:30px;cursor:pointer;color:white;width:100px" >&#9776;
      </span>

      <ul class="nav navbar-nav navbar-right">
        <li class="active"><a onclick="logout()" href='index.php'></span> Logout<span class="sr-only">(current)</span></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right" style="width:50px;height:50px">
        <img class="img-responsive" src='videos.png' width=100% height=100% style='padding:0'></img>
      </ul>

   </nav>

  <div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
         <div class="menu"  style="text-align:center;">
            <div class="profile-userpic">
					        <img src="../../image/image.png" class="img-responsive" alt="">
                  <a href="#">Puneet Saluja</a>
				    </div>
            <hr>

            <div>
               <li>
                 <a href="#study" onclick="showStudyMaterial()" class="active">Study Material&nbsp;&nbsp;<i class="fa fa-book"></i></a>
               </li>

               <li>
                 <a href="#">Assignments&nbsp;&nbsp;<span class="fa fa-pencil"></span></a>
               </li>

               <li>
                 <a href="#">Quiz&nbsp;&nbsp;<span class="fa fa-line-chart"></span></a>
               </li>

            </div>
            <div class="card">
              <div class="header">
                <?php
                echo date("j");
                ?>
              </div>

              <div class="content">
                <p><?php echo date("F")." ".date("j").", ".date("Y"); ?></p>
              </div>
            </div>
         </div>
  </div>


  <div id="study" style="visibility:hidden;">
    <form action="" method="post">
      <select name="year">
          <option value="1">First</option>
          <option value="2">Second</option>
          <option value="3">Third</option>
          <option value="4">Fourth</option>
      </select>
      <select name="batch">
          <option value="cs">CS</option>
          <option value="me">Mechanical</option>
          <option value="ar">Architecture</option>
          <option value="ec">ECE</option>
      </select>
      <select name="type">
          <option value="image">image</option>
          <option value="video">video</option>
          <option value="ppt">ppt</option>
          <option value="pdf">pdf</option>
      </select>
      <div  style="margin-left:21%;height:20%">
          <button class="btn btn-primary"><input type="file" name="fileToUpload" id="fileToUpload" required></button>
      </div>
      <button name="submitStudyMaterial" type="submit">Submit</button>
    </form>
  </div>








</body>
