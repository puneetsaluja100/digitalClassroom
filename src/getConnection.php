<?php
function getConnection()
{
  if($conn = pg_connect("host=localhost port=5432 dbname=digitalClassroom user=postgres password=postgres"))
  {
    echo "hey himani";
    echo $conn;
    return $conn;
  }
  else {
    return "Connection Failed";
  }
}
?>
