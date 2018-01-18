<?php
  session_start();
  include "../../src/query.php";
  $sentFrom = "'".$_SESSION['id']."'";
  $query = new GetData($sentFrom);
  $type = "pdf";

  $result = $query->getStudyMaterialMadeByMeById("'".$type."'");
  if($result)
  {
      print_r($result);
  }
  else if(!$result)
  {

  }


?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="./bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./bootstrap-4.0.0-alpha.6-dist/css/bootstrap.css">
    <title></title>
  </head>
  <body>

    <div class="row">
    <div class="col-md-4">


    </div>
    <div class="col-md-8" style="text-align:center;">
        <div class="row">

          <?php
            if($result)
            {
              foreach ($result as $row) {
                print_r($row['content']);
              // echo "
              // <div style='margin:10px;''>
              //   <img width='320' src='".$row['content']."' height='240'>
              //   </img>
              //   <p>About this</p>
              // </div>";
              }
            }
            else{
              echo "no data available";
            }
           ?>

        </div>
   </div>
 </div>
  </body>
</html>
