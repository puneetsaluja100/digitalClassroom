<?php
  session_start();
  include "../../src/query.php";
  $sentFrom = "'".$_SESSION['id']."'";
  $query = new GetData($sentFrom);
  $type = "ppt";

  $role = "'".$_SESSION['role']."'";
  $teacher = "te";
  $student = "st";
  if($role=="'".$student."'")
  {
    $batch =  "'".$_SESSION['batch']."'";
    $year =  "'".$_SESSION['year']."'";
    $result = $query->getStudyMaterialForStudent($batch,$year,"'".$type."'");
  }
  else if($role=="'".$teacher."'")
  {
    $result = $query->getStudyMaterialMadeByMeById("'".$type."'");
  }

  if($result)
  {

  }
  else if(!$result)
  {

  }


?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.css">
    <script>
      function downloadPPT(path){
        location.href = path;
      }
    </script>
    <title></title>
  </head>
  <body>

    <div style="text-align:center;" class="header" id="myHeader">
        <h1>ppt</h1>
    </div>

    <div class="row">
    <div class="col-md-12" style="text-align:center;">
          <?php
            if($result)
            {

              echo "<div>
                <br>
                <table align='center' class='table table-hover table-striped' style='width:100%;font-size:15px'>
                  <thead class='thead-inverse'><TR  class='danger'><TH style='text-align:center;'>ppt</TH><TH style='text-align:center;'>Uploaded By</TH><TH style='text-align:center;'>Download</TH></TR></thread>";
              foreach ($result as $row) {
                $fileName = basename($row['content'],".ppt");
                // print_r($row);
                $path = "../../src/uploads/".$row['send_from']."/".$row['type']."/".$row['content']."";
                echo "<TR><TD>".$fileName."</TD><TD>".$row['username']."</TD><TD><button type='button' onclick=downloadPPT("."'".$path."'".") class='btn btn-info'>Download</button></TR>";
              }
              echo "</table>
              </div>";
            }
            else {
              echo "no data available";
            }
           ?>
   </div>
 </div>
  </body>
</html>
