<?php
  session_start();
  if(isset($_POST['submitStudyMaterial']))
  {
    $batch = "'".$_POST["batch"]."'";
    $year = "'".$_POST["year"]."'";
    $senderRole = 'te';
    $assignment = 'false';
    $approve = 'false';
    $type = "'".(string)$_POST["type"]."'";
    $target_dir = "../../src/uploads/".$_SESSION['id']."/".$_POST["type"]."/";
    $target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);

    $content = "'".$_FILES["fileToUpload"]["name"]."'";
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));



    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($type=='image')
    {
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
          echo '<script language="javascript">';
          echo 'alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.")';
          echo '</script>';
          $uploadOk = 0;
      }
    }
    else if($type=='video')
    {
      if($imageFileType != "3gp" && $imageFileType != "mp4" && $imageFileType != "mkv"
      && $imageFileType != "MP4" && $imageFileType != "avi" ) {
          echo '<script language="javascript">';
          echo 'alert("Sorry, only 3gp, mp4, mkv & avi files are allowed.")';
          echo '</script>';
          $uploadOk = 0;
      }
    }
    else if($type=='ppt')
    {
      if($imageFileType != "ppt" && $imageFileType != "pptx") {
          echo '<script language="javascript">';
          echo 'alert(""Sorry, only ppt, pptx files are allowed."")';
          echo '</script>';
          $uploadOk = 0;
      }
    }
    else if($type=='pdf')
    {
      if($imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "docx") {
          echo "Sorry, only pdf, doc, docx files are allowed.";
          $uploadOk = 0;
      }
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {

        include "../../src/query.php";
        $sentFrom = "'".$_SESSION['id']."'";
        $query = new PostData($sentFrom);
        $result = $query->studyMaterial($content,$type,$approve,$batch,$year,$assignment,$senderRole);
        if($result === true)
        {
          echo '<script language="javascript">';
          echo 'alert("Successfully Uploaded")';
          echo '</script>';
          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

          } else {
              echo "Sorry, there was an error uploading your file.";
          }
        }
        else if($result === false)
        {

        }
    }
  }


  if(isset($_POST['submitAssignment']))
  {
    $batch = "'".$_POST["batch"]."'";
    $year = "'".$_POST["year"]."'";
    $senderRole = 'te';
    $assignment = 'true';
    $approve = 'false';
    $type = "'".(string)$_POST["type"]."'";
    $target_dir = "../../src/uploads/".$_SESSION['id']."/".$_POST["type"]."/";
    $target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);

    $content = "'".$_FILES["fileToUpload"]["name"]."'";
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));



    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }


    if($type=='pdf')
    {
      if($imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "docx") {
          echo "Sorry, only pdf, doc, docx files are allowed.";
          $uploadOk = 0;
      }
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {

        include "../../src/query.php";
        $sentFrom = "'".$_SESSION['id']."'";
        $query = new PostData($sentFrom);
        $result = $query->studyMaterial($content,$type,$approve,$batch,$year,$assignment,$senderRole);
        if($result === true)
        {
          echo '<script language="javascript">';
          echo 'alert("Successfully Uploaded")';
          echo '</script>';
          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

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
					        <img src="../../image/images.png" class="img-responsive" alt="">
                  <a href="#">Puneet Saluja</a>
				    </div>
            <hr>

            <div>
               <li>
                 <a href="#" onclick="showStudyMaterial()" class="active">Study Material&nbsp;&nbsp;<i class="fa fa-book"></i></a>
               </li>

               <li>
                 <a href="#"  onclick="showAssignments()">Assignments&nbsp;&nbsp;<span class="fa fa-pencil"></span></a>
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


  <div id="study" style="display:none;">
    <div class="row">
      <div class="col-md-5">
        <div class="card" style="width: 30rem;height:35rem;display: inline-block;margin:30px;">

          <div class="card-block">
            <!-- Use any element to open the sidenav -->
            <form action="" method="post" enctype="multipart/form-data">
              <label for="year">Year:</label>
              <select class="form-control" name="year">
                  <option value="1">First</option>
                  <option value="2">Second</option>
                  <option value="3">Third</option>
                  <option value="4">Fourth</option>
              </select>
              <br>
              <label for="branch">Branch:</label>
              <select class="form-control" name="batch">
                  <option value="cse">CS</option>
                  <option value="ece">Mechanical</option>
                  <option  value="mech">Mechanical</option>
                  <option  value="meta">Metallurgy</option>
              </select>
              <br>
              <label for="type">Type:</label>
              <select class="form-control" name="type">
                  <option value="image">image</option>
                  <option value="video">video</option>
                  <option value="ppt">ppt</option>
                  <option value="pdf">pdf</option>
              </select>
              <br>
                  <button class="btn btn-primary"><input type="file" name="fileToUpload" id="fileToUpload"></button>
              <br>
              <br>
              <button class="btn btn-primary" name="submitStudyMaterial" type="submit">Submit</button>
            </form>
          </div>
        </div>
      </div>

      <div class="col-md-7"style="text-align:center;">
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
  </div>

  <div id="assignment" style="display:none;">
    <div class="row">
      <div class="col-md-5">
        <div class="card" style="width: 30rem;height:35rem;display: inline-block;margin:30px;">

          <div class="card-block">
            <!-- Use any element to open the sidenav -->
            <form action="" method="post" enctype="multipart/form-data">
              <h1>Upload Assignment</h1>
              <hr>
              <br>
              <label for="year">Year:</label>
              <select class="form-control" name="year">
                  <option value="1">First</option>
                  <option value="2">Second</option>
                  <option value="3">Third</option>
                  <option value="4">Fourth</option>
              </select>
              <br>
              <label for="branch">Branch:</label>
              <select class="form-control" name="batch">
                  <option value="cse">CS</option>
                  <option value="ece">Mechanical</option>
                  <option  value="mech">Mechanical</option>
                  <option  value="meta">Metallurgy</option>
              </select>
              <br>
              <label for="type">Type:</label>
              <select class="form-control" name="type">
                  <option value="pdf">pdf/document</option>
              </select>
              <br>
                  <button class="btn btn-primary"><input type="file" name="fileToUpload" id="fileToUpload"></button>
              <br>
              <br>
              <button class="btn btn-primary" name="submitAssignment" type="submit">Submit</button>
            </form>
          </div>
        </div>
      </div>

      <div class="col-md-7">

        <?php
            include_once "../../src/query.php";
            $sentFrom = "'".$_SESSION['id']."'";
            $query = new GetData($sentFrom);
            $type = "pdf";
            $assignment = 'true';
            $role = "'".$_SESSION['role']."'";
            $teacher = "te";
            $student = "st";
            if($role=="'".$teacher."'")
            {
              $assignments = $query->getStudyMaterialMadeByMeById("'".$type."'",$assignment);
              if($assignments)
              {
                echo "<div>
                  <br>
                  <table align='center' class='table table-hover table-striped' style='width:70%;font-size:15px'>
                  <thead class='thead-inverse'><TR class='danger'><TH style='text-align:center;'>Assignment</TH><TH style='text-align:center;'>Year</TH><TH style='text-align:center;'>Batch</TH><TH style='text-align:center;'>Download</TH></TR></thread>";
                foreach ($assignments as $row) {
                  $fileName = basename($row['content'],".pdf");
                  $path = "'"."../../src/uploads/".$row['send_from']."/".$row['type']."/".$row['content']."'";
                  //file name having spaces have problem

                  echo "<TR><TD>".$fileName."</TD><TD>".$row['year']."</TD><TD>".$row['batch']."</TD><TD><button type='button' onclick=downloadPDF(".$path.") class='btn btn-info'>Download</button></TD></TR>";
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

    </div>
  </div>




</body>
