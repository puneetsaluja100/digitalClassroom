<?php
session_start();
include "../../src/query.php";
$uid = $_SESSION['id'];
$query_get = new GetData($uid);
$query_post = new PostData($uid);
$userdata = $query_get->getUserDataFromID($uid);
$notification = $query_get->notify($userdata['batch'],$userdata['year']);

if(isset($_REQUEST['submitAssignment'])){
  $batch = "'".$_SESSION["batch"]."'";
  $year = -1;
  $senderRole = 'st';
  $assignment = 'true';
  $approve = 'true';
  $type = 'pdf';
  $target_dir = "../../src/uploads/".$_SESSION['id']."/pdf/";
  $target_file = $target_dir.basename($_FILES["assignmentToUpload"]["name"]);
  $content = "'".$_FILES["assignmentToUpload"]["name"]."'";
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  // Check file size
  if ($_FILES["assignmentToUpload"]["size"] > 500000000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
      $sendTo = "'".$_POST["send_to"]."'";
      $result = $query_post->studyMaterial($content,"'".$type."'",$approve,$batch,$year,$assignment,$senderRole,$sendTo);
      if($result === true)
      {
        if (move_uploaded_file($_FILES["assignmentToUpload"]["tmp_name"], $target_file)) {
          echo '<script language="javascript">';
          echo 'alert("Successfully Uploaded")';
          echo '</script>';
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
      }
      else if($result === false)
      {

      }
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
  <script type="text/javascript">
  /* Set the width of the side navigation to 250px */
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function logout() {
  session_unset();
}

function openNotify(){
  document.getElementById("notifynav").style.width = "250px";
}

function closeNotify(){
  document.getElementById("notifynav").style.width = "0";
}

/* Set the width of the side navigation to 0 */
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}


function goToVideos()
{
    location.href = "video.php";
}

function goToImages()
{
    location.href = "image.php";
}

function goToPPT()
{
    location.href = "ppt.php";
}

function goToPDF()
{
    location.href = "pdf.php";
}

function showStudyMaterial(){
    var el = document.getElementById('assignment');
    el.style.display = 'none';
    document.getElementById('study').removeAttribute("style");
    closeNav();
}

function showAssignments(){
    var el = document.getElementById('study');
    el.style.display = 'none';
    document.getElementById('assignment').removeAttribute("style");
    closeNav();
}

function downloadPDF(path){
  location.href = path;
}

  </script>

</head>

<body>

  <nav class="navbar navbar-inverse bg-inverse">

      <span class="nav navbar-nav navbar-left" onclick="openNav()" style="font-size:30px;cursor:pointer;color:white;width:100px" >&#9776;
      </span>



      <ul class="nav navbar-nav navbar-right pull-right">
        <li class="active"><a onclick="logout()" href='index.php'></span> Logout<span class="sr-only">(current)</span></a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right pull-right">
        <li class="active">  <a class="btn btn-small btn-primary pull-right" type="button" onclick="openNotify()"><span class="fa fa-bell"></span></a></li>
      </ul>
      <!-- <ul class="nav navbar-nav navbar-right" style="width:50px;height:50px">
        <img class="img-responsive" src='../../image/videos.png' width=100% height=100% style='padding:0'></img>
      </ul> -->



   </nav>




  <div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
         <div class="menu"  style="text-align:center;">
            <div class="profile-userpic">
			        <img src="../../image/<?php echo $userdata['profile_picture'] ?>" alt="../../image/image.png" class="img-responsive" alt="">
            </div>
            <div>
              <span style="font-size:25px;color:#ffffff;"><?php echo $userdata['username'] ?></span>
				    </div>
            <hr>


            <div>

               <li>
                 <a href="#" class="active" onclick="showStudyMaterial()">Study Material&nbsp;&nbsp;<i class="fa fa-book"></i></a>
               </li>

               <li>
                 <a href="#"  onclick="showAssignments()">Assignments&nbsp;&nbsp;<span class="fa fa-pencil"></span></a>
               </li>

               <li>
                 <a href="profile.php">Settings&nbsp;&nbsp;<span class="fa fa-line-chart"></span></a>
               </li>

               <li>
                 <a href="discussion_portal.php">Discussion Portal&nbsp;&nbsp;<span class="fa fa-wechat"></span></a>
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

  <div id="notifynav" class="sidenavRight">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNotify()">&times;</a>
      <div class="menu" style="text-align:center;">
        <?php while ($row = pg_fetch_row($notification)) {
            $sender = $query_get->getUserDataFromID($row[2]);
          ?>
          <li style="margin-top:2%;">
            <span style="color:#ffffff;"><?php echo $row[1] ?></span>
            <div>
              <span>From: <?php echo $sender['username']?></span>
            </div>
          </li>
        <?php } ?>
      </div>
    </a>
  </div>


<div class="row" id="study">
  <div class="col-md-2">

  <!-- Use any element to open the sidenav -->

  </div>

  <div class="col-md-8"style="text-align:center;">

    <div>
        <div class="card" onclick="goToImages()" style="width: 15rem;height:15rem;display: inline-block;margin:30px;">
          <img class="card-img-top" style="height:150px;padding-top:10px;" src="../../image/images.png" alt="Card image cap">
          <div class="card-block">
            <h4 class="card-title">Images</h4>
          </div>
        </div>



        <div class="card" onclick="goToVideos()" style="width: 15rem;height:15rem;display: inline-block;margin:30px;">
          <img class="card-img-top" style="height:150px;padding-top:10px;" src="../../image/videos.png" alt="Card image cap">
          <div class="card-block">
            <h4 class="card-title">Videos</h4>
          </div>
        </div>
    </div>

    <div>
          <div class="card" onclick="goToPDF()" style="width: 15rem;height:15rem;display: inline-block;margin:30px;">
          <img class="card-img-top" style="height:150px;padding-top:10px" src="../../image/pdf.png" alt="Card image cap">
          <div class="card-block">
            <h4 class="card-title">pdf</h4>
          </div>
        </div>

        <div class="card" onclick="goToPPT()" style="width: 15rem;height:15rem;display: inline-block;margin:30px;">
          <img class="card-img-top" style="height:150px;padding-top:10px;" src="../../image/ppt.png" alt="Card image cap">
          <div class="card-block">
            <h4 class="card-title">ppt</h4>
          </div>
        </div>
    </div>

  </div>
</div>

<div id="assignment" style="display:none;">
  <div class="row">
    <div class="col-md-1">
    </div>

    <div class="col-md-10" style="text-align:center;">

      <?php
          include_once "../../src/query.php";
          $sentFrom = "'".$_SESSION['id']."'";
          $query = new GetData($sentFrom);
          $type = "pdf";
          $assignment = 'true';
          $role = "'".$_SESSION['role']."'";
          $teacher = "te";
          $student = "st";
          if($role=="'".$student."'")
          {
            $batch =  "'".$_SESSION['batch']."'";
            $year =  "'".$_SESSION['year']."'";
            $assignment = 'true';
            $assignments = $query->getStudyMaterialForStudent($batch,$year,"'".$type."'",$assignment);
            if($assignments)
            {
              echo "<div>
                <br>
                <table align='center' class='table table-hover table-striped' style='width:70%;font-size:15px'>
                <thead class='thead-inverse'><TR class='danger'><TH style='text-align:center;'>Assignment</TH><TH style='text-align:center;'>Faculty</TH><TH style='text-align:center;'>Download</TH><TH style='text-align:center;'>Submit Assignment</TH><TH></TH></TR></thread>";
              foreach ($assignments as $row) {
                $fileName = basename($row['content'],".pdf");
                $path = "'"."../../src/uploads/".$row['send_from']."/".$row['type']."/".$row['content']."'";
                //file name having spaces have problem

                echo "<TR><TD>".$fileName."</TD><TD>".$row['username']."</TD><TD><button type='button' onclick=downloadPDF(".$path.") class='btn btn-info'>Download</button></TD><form enctype='multipart/form-data' action='' method='post'><input style='display:none;' name='send_to' value='".$row['send_from']."'><TD><input type='file' name='assignmentToUpload' id='assignmentToUpload'></TD><TD><button name='submitAssignment' value='submitAssignment' type='submit' class='btn btn-info'>Submit</button></form></TD></TR>";
              }
              echo "</table>
              </div>";
            }
            else{
              echo "no data available";
            }
          }
       ?>
    </div>
    <div class="col-md-1">
    </div>

  </div>
</div>

</body>
</html>
