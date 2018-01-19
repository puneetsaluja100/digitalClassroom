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

function goToVideos()
{

}

function approve(uid){
    <?php
        $query_post->approveTeacher(uid);
        // echo "approveTeacher(uid)";
    ?>
}

function reject(uid)
{
    <?php
        echo "rejectTeacher('.uid.')";
    ?>
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
                 <a href="#" class="active">Quiz&nbsp;&nbsp;<i class="fa fa-book"></i></a>
               </li>

               <li>
                 <a href="#">Assignments&nbsp;&nbsp;<span class="fa fa-pencil"></span></a>
               </li>

               <li>
                 <a href="#">Performance&nbsp;&nbsp;<span class="fa fa-line-chart"></span></a>
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


<div class="col-md-12 container"style="text-align:center;">

  <table align='center' class="table table-hover" >
    <?php
    session_start();
    include "../../src/query.php";
    //$sentFrom = "'".$_SESSION['id']."'";
      $uid = 1;
    $query = new GetData($uid);
    $query_post = new PostData($uid);
    echo "<TR class="."table-success"."><TH>Name</TH><TH>email</TH><TH>Department</TH><TH>Action</TH></TR>";
    echo "<form id='' method='post' action=''>";
    $result = $query->getTeacherDetailForApproval();
    echo "<TR class="."active".">";
    foreach($result as $row)
    {
      print_r($row);
      echo sprintf("<TD >%s</TD><TD>%s</TD><TD>%s</TD><TD><input onclick='approve(".$row['uid'].")' type='submit' value='Accept'  name='' ><input type='submit' onclick='reject(".$row['uid'].")'value='Reject'  name='' ></TD></TR>",$row['username'],$row['email'],$row['batch']);
    }
    echo "</form>";
    echo "</table>";

  ?>
</div>

</div>

</body>
