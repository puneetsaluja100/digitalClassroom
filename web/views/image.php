<?php
  session_start();
  include "../../src/query.php";
  $sentFrom = "'".$_SESSION['id']."'";
  $query = new GetData($sentFrom);
  $type = "img";

  $result = $query->getStudyMaterialMadeByMeById($type,"false");
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
    <link rel="stylesheet" type="text/css" href="./bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./bootstrap-4.0.0-alpha.6-dist/css/bootstrap.css">
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
        <h1>IMAGE</h1>
    </div>
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
                ?>
                <div style='margin:10px;'>
                  <img width='320' src="../../src/uploads/<?php echo $send_from; ?>/images/<?php $row['content'];?>" height='240'>
                  </img>
                  <p>About this</p>
                </div>
              <?php
              }
            }
            else{?>
              <div style="margin-left:32%;">
                <img width='550' src="../../image/NoDataAvailable.png" height='500'>
                </img>
              </div>
            <?php }
           ?>

        </div>
   </div>
 </div>
  </body>
</html>
