<?php
function getConnection()
{
  if($conn = pg_connect("host=localhost port=5432 dbname=digitalClassroom user=postgres password=himani"))
  {
    return $conn;
  }
  else {
    return "Connection Failed";
  }
}
?>
