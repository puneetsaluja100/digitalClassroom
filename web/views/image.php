<?php
  session_start();
  $alternate = 0;
  include "../../src/query.php";
  $sentFrom = "'".$_SESSION['id']."'";
  $query = new GetData($sentFrom);
  $type = "image";

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
    <link rel="stylesheet" type="text/css" href="../css/style_slideshow.css">
    <title></title>
  </head>
  <body>
  <div style="text-align:center;" class="header" id="myHeader">
      <h1>Images</h1>
      <button class="btn" onclick="one()">Large</button>
      <button class="btn active" onclick="two()">Medium</button>
      <button class="btn" onclick="four()">Small</button>
  </div>


  <div class="row">
  <div class="column">
    <?php
      if($result)
      {
          $toggle = 0;
          foreach ($result as $row) {
            if($toggle%3 == 0)
            {
              $fileName = basename($row['content'],".");
              $fileName = preg_replace("/\.[^.]+$/", "", $fileName);
              $path = "../../src/uploads/".$row['send_from']."/".$row['type']."/".$row['content']."";
              echo "<img  src='".$path."' style='width:100%;'></img>";
            }
          $toggle++;
        }
      }
      else{
        echo "no data available";
      }
     ?>
  </div>

  <div class="column">
    <?php
      if($result)
      {
          $toggle = 0;
          foreach ($result as $row) {
            if($toggle%3 == 1)
            {
              $fileName = basename($row['content'],".");
              $fileName = preg_replace("/\.[^.]+$/", "", $fileName);
              // print_r($fileName);
              $path = "../../src/uploads/".$row['send_from']."/".$row['type']."/".$row['content']."";
              echo "<img  src='".$path."' style='width:100%;'></img>";
            }
            $toggle++;
        }
      }
      else{
        echo "no data available";
      }
     ?>
  </div>

  <div class="column">
    <?php
      if($result)
      {
          $toggle = 0;
          foreach ($result as $row) {
            if($toggle%3 == 2)
            {
              $fileName = basename($row['content'],".");
              $fileName = preg_replace("/\.[^.]+$/", "", $fileName);
              $path = "../../src/uploads/".$row['send_from']."/".$row['type']."/".$row['content']."";
              echo "<img  src='".$path."' style='width:100%;'></img>";
            }
            $toggle++;
          }
      }
      else{
        echo "no data available";
      }
     ?>
  </div>



</div>










 <script>
// Get the elements with class="column"
var elements = document.getElementsByClassName("column");

// Declare a loop variable
var i;

// Full-width images
function one() {
    for (i = 0; i < elements.length; i++) {
        elements[i].style.msFlex = "100%";  // IE10
        elements[i].style.flex = "100%";
    }
}

// Two images side by side
function two() {
    for (i = 0; i < elements.length; i++) {
        elements[i].style.msFlex = "50%";  // IE10
        elements[i].style.flex = "50%";
    }
}

// Four images side by side
function four() {
    for (i = 0; i < elements.length; i++) {
        elements[i].style.msFlex = "25%";  // IE10
        elements[i].style.flex = "25%";
    }
}

// Add active class to the current button (highlight it)
var header = document.getElementById("myHeader");
var btns = header.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
  });
}
</script>
  </body>
</html>
