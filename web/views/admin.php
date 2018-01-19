<?php
    if(isset($_REQUEST['Approve'])){
        $uid = $_POST['uid'];
        include_once "../../src/query.php";
        $query = new PostData(1);
        $result = $query->approveTeacher($uid);
        if($result)
        {
          echo '<script language="javascript">';
          echo 'alert("Teacher Account Successfully Approved")';
          echo '</script>';
          header("Location:admin.php");
        }
    }
    else if(isset($_REQUEST['Reject'])){
        $uid = $_POST['uid'];
        include_once "../../src/query.php";
        $query = new PostData(1);
        $result = $query->rejectTeacher($uid);
        if($result)
        {
          echo '<script language="javascript">';
          echo 'alert("Teacher Account Successfully Rejected")';
          echo '</script>';
          header("Location:admin.php");
        }
    }
    else if(isset($_REQUEST['approveAssignment'])){
          $sid = $_POST['sid'];
          echo($sid);
          include_once "../../src/query.php";
          $query = new PostData(1);
          $result = $query->approveStudyMaterial($sid);
          if($result)
          {
            echo '<script language="javascript">';
            echo 'alert("Study Material Successfully Approved")';
            echo '</script>';
            header("Location:admin.php");
          }

      }
      else if(isset($_REQUEST['rejectAssignment'])){
            $sid = $_POST['sid'];
            echo($sid);
            include_once "../../src/query.php";
            $query = new PostData(1);
            $result = $query->approveStudyMaterial($sid);
            if($result)
            {
              echo '<script language="javascript">';
              echo 'alert("Study Material Rejected")';
              echo '</script>';
              header("Location:admin.php");
            }
        }
 ?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
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


      function showTeacher(){
          var el = document.getElementById('assignment');
          el.style.display = 'none';
          document.getElementById('teacher').removeAttribute("style");
          closeNav();
      }

      function showAssignments(){
          var el = document.getElementById('teacher');
          el.style.display = 'none';
          document.getElementById('assignment').removeAttribute("style");
          closeNav();
      }
  </script>
</head>

<body>

  <nav class="navbar navbar-inverse bg-inverse ">
      <span class="nav navbar-nav navbar-left" onclick="openNav()" style="font-size:30px;cursor:pointer;color:white;width:100px" >&#9776;
      </span>
      <div class="row">
        <ul class="nav navbar-nav navbar-right">
          <li class="active"><a onclick="logout()" href='index.php'></span> Logout<span class="sr-only">(current)</span></a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right" style="width:50px;height:50px">
          <img class="img-responsive" src='videos.png' width=100% height=100% style='padding:0'></img>
        </ul>
      </div>
   </nav>

  <div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
         <div class="menu"  style="text-align:center;">
            <div class="profile-userpic">
					        <img src="../../image/image.png" class="img-responsive" alt="">
                  <a href="#">Admin</a>
				    </div>
            <hr>


            <div>
               <li>
                 <a href="#" onclick="showTeacher()" class="active">Teacher Accounts&nbsp;&nbsp;<i class="fa fa-user"></i></a>
               </li>

               <li>
                 <a href="#" onclick="showAssignments()" >Assignments&nbsp;&nbsp;<span class="fa fa-pencil"></span></a>
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


  <div id="teacher" class="col-md-12 container"style="text-align:center;">

    <table align='center' class="table table-hover" >
      <?php
      session_start();
      include "../../src/query.php";
      //$sentFrom = "'".$_SESSION['id']."'";
      $uid = 1;
      $query = new GetData($uid);

      echo "<TR class="."table-success"."><TH>Name</TH><TH>email</TH><TH>Department</TH><TH>Action</TH></TR>";
      $result = $query->getTeacherDetailForApproval();
      echo "<TR class="."active".">";
      if($result)
      {
        foreach($result as $row)
        {
          echo sprintf("<TD >%s</TD><TD>%s</TD><TD>%s</TD><TD><form method='post' action=''><input name='uid' style='display:none;' value='".$row['uid']."'><button type='submit' class='btn btn-success' value='Accept'  name='Approve' >Approve</button>&nbsp;&nbsp;<button class='btn btn-danger' type='submit' value='Reject' name='Reject'>Reject</button></form></TD></TR>",$row['username'],$row['email'],$row['batch']);
        }
      }
      echo "</table>";
      ?>
  </div>
  <div id="assignment" style="display:none;">
    <div style="text-align:center;">
    <?php
        include_once "../../src/query.php";
        $uid = "'".$_SESSION['id']."'";
        $query = new GetData($uid);
        $role = "'".$_SESSION['role']."'";
        $admin = "ad";
        if($role=="'".$admin."'")
        {
          $assignments = $query->getStudyMaterialForAdmin();
          if($assignments)
          {
            echo "<div>
              <br>
              <table align='center' class='table table-hover table-striped' style='width:70%;font-size:15px'>
              <thead class='thead-inverse'><TR class='danger'><TH style='text-align:center;'>Assignment</TH><TH style='text-align:center;'>Teacher</TH><TH style='text-align:center;'>Year</TH><TH style='text-align:center;'>Batch</TH><TH style='text-align:center;'>Action</TH><TH></TH></TR></thread>";
            foreach ($assignments as $row) {
              $fileName = basename($row['content'],".pdf");
              $path = "'"."../../src/uploads/".$row['send_from']."/".$row['type']."/".$row['content']."'";
              //file name having spaces have problem

              echo "<TR><TD>".$fileName."</TD><TD>".$row['username']."</TD><TD>".$row['year']."</TD><TD>".$row['batch']."</TD><TD><form method='post' action=''><input name='sid' style='display:none;' value='".$row['sid']."'><button type='submit' name='approveAssignment' class='btn btn-success'>Approve</button></TD><TD><button type='submit' name='rejectAssignment' class='btn btn-danger'>Reject</button></form></TD></TR>";
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

</body>
