<?php
function getConnection()
{
  //connect to postgres which runs on localhost port number 5432. The database name is digitalClassroom and password is himani
  if($conn = pg_connect("host=localhost port=5432 dbname=digitalClassroom user=postgres password=himani"))
  {
    //connection established Successfully
    return $conn;
  }
  else {
    return "Connection Failed";
  }
}
?>
