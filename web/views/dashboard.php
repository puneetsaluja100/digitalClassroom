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
    alert("video");
    location.href = "video.php";
}

function goToImages()
{
    alert("yes");
    location.href = "image.php";
}

function goToPPT()
{
    alert("yes");
    location.href = "ppt.php";
}

function goToPDF()
{
    alert("yes");
    location.href = "pdf.php";
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


<div class="row">
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

</body>
