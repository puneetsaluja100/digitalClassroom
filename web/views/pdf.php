<?php
  session_start();
  include "../../src/query.php";
  $sentFrom = "'".$_SESSION['id']."'";
  $query = new GetData($sentFrom);
  $type = "pdf";

  $role = "'".$_SESSION['role']."'";
  $teacher = "te";
  $student = "st";
  if($role=="'".$student."'")
  {
    $assignment = 'false';
    $batch =  "'".$_SESSION['batch']."'";
    $year =  "'".$_SESSION['year']."'";
    $result = $query->getStudyMaterialForStudent($batch,$year,"'".$type."'",$assignment);
  }
  else if($role=="'".$teacher."'")
  {
    $assignment = 'false';
    $result = $query->getStudyMaterialMadeByMeById("'".$type."'",$assignment);
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
      function downloadPDF(path){
        location.href = path;
      }
    </script>
    <title></title>
    <style media="screen">
      .mainHead{
        border: 1px solid #5bc0de;
        background-color: #5bc0de;
        color:#ffffff;
        padding:1%;
      }
    </style>
  </head>
  <body>
    <div style="text-align:center;" class="header mainHead" id="myHeader">
        <h1>PDF</h1>
    </div>

    <div class="row">
    <div class="col-md-12" style="text-align:center;">
          <?php
            if($result)
            {
              echo "<div>
                <br>
                <table align='center' class='table table-hover table-striped' style='width:70%;font-size:15px'>
                <thead class='thead-inverse'><TR class='danger'><TH style='text-align:center;'>pdf</TH><TH style='text-align:center;'>Uploaded By</TH><TH style='text-align:center;'>Download</TH></TR></thread>";
              foreach ($result as $row) {
                $fileName = basename($row['content'],".pdf");
                $path = "../../src/uploads/".$row['send_from']."/".$row['type']."/".$row['content']."";
                echo "<TR><TD>".$fileName."</TD><TD>".$row['username']."</TD><TD><button type='button' onclick=downloadPDF("."'".$path."'".") class='btn btn-info'>Download</button></TD></TR>";
              }
              echo "</table>
              </div>";
            }
            else{?>
              <div style="margin-left:4%;">
                <img width='550' src="../../image/NoDataAvailable.png" height='500'>
                </img>
              </div>
            <?php }
           ?>
   </div>
 </div>
  </body>
</html>
