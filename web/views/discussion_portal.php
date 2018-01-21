<?php
  //start the session
  session_start();
  //include query.php file to get data from the database
  include "../../src/query.php";
  //put the user id by session variable to $uid
  $uid = $_SESSION['id'];
  //make an object for GetData class in query.php
  $query_get = new GetData($uid);
  //get messages from the database
  $messages = $query_get->getMessages();
  //make an object for PostData class in query.php
  $query_post = new PostData($uid);

  //get message and receiver username from the html form send the data to the database
  $toErr = "";
  $to = $content = "";
  if(isset($_POST['send'])){
    if (empty($_POST["receiver"])) {
      $toErr = "* Receiver's Name is required";
    } else {
      $to = $_POST["receiver"];
    }
    $content = $_POST["message"];
    if($toErr == ""){
      //if no error insert into the table message by calling the function messages
      if($query_post->messages($content,$to)){
        $to = $content = "";
        // if($query_post->notification("You received a message","cse",3)){
        //   echo "success";
        // }else{
        //   echo "failure";
        // }
      }else {
        //the username of the receiver is not valid
        $toErr = "Sorry no ".$to." exists";
        $to = "";
      }
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Discussion Portal</title>
    <!-- call all the  files required-->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
      body{
        margin-top:20px;
      }
      .row{
        margin-top:1%;
      }
    </style>
    <script type="text/javascript">
      function deleteRow(mid){
        <?php $query_post->deleteMessage($mid);?>
      }
    </script>
  </head>
  <body>
    <div class="container">
      <!-- the image  -->
      <div style="margin-bottom:1%;">
        <img src="../../image/Twitter_chat_image1.png" class="" alt="sorry" style="width:100%;height:340px;"/>
      </div>
      <!-- the form to write the message -->
      <div class="well well-sm">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          <div class="form-group">
            <textarea class="form-control" type="text" placeholder="Write your message here" name="message" value="<?php echo $content;?>"></textarea>
            <div class="row">
              <div class="col-md-1 col-lg-1 col-sm-12" style="text-align:center;">
                <label class="form-label">To:</label>
              </div>
              <div class="col-md-10 col-lg-10 col-sm-12">
                <input type="text" class="form-control" placeholder="Write the receiver's name" name="receiver" value="<?php echo $to;?>"/>
              </div>
              <div class="col-md-1 col-lg-1 col-sm-12 pull-right">
                <button type="submit" name="send" class="btn btn-small btn-primary"><i class="fa fa-send"></i></button>
              </div>
            </div>
            <div>
              <span class="error" style="margin-left:75%;color:red;margin-top:5%;"> <?php echo $toErr;?></span>
            </div>
          </div>
        </form>
      </div>
      <!-- show all the messages for the user and by the user -->
      <div>
        <div class="form">
          <?php while ($row = pg_fetch_row($messages)) {
              if($row[3] == $uid){
                  $receiver = $query_get->getUserDataFromID($row[2]);
                  $sender = $query_get->getUserDataFromID($uid);
              }
              else {
                $sender = $query_get->getUserDataFromID($row[3]);
                $receiver = $query_get->getUserDataFromID($uid);
              }
              ?>
              <div class="well well-sm" style="margin-bottom:3%;">
              <div class="row">
                <div class="col-md-1 col-lg-1 col-sm-12">
                  <img src="../../image/<?php echo $sender['profile_picture'] ?>" class="img-rounded" alt="sorry" width="40px" height="40px" style="margin-left:5%;">
                </div>
                <div class="col-md-11 col-lg-11 col-sm-12">
                  <label class="form-label" style="font-size:18px;margin-top:1%;margin-left:-2%;"><?php echo $sender['username']?> to <?php echo $receiver['username']?></label>
                </div>
                <!-- <div class="col-md-1 col-lg-1 col-sm-12">
                  <a style="color:#ff0000;" onselect="<?php //$query_post->deleteMessage($mid);?>"><i class="fa fa-trash"></i></a>
                </div> -->
              </div>
              <div class="row" style="margin-left:0.2%;margin-right:0.2%;">
                <textarea class="form-control"><?php echo $row[1] ?></textarea>
              </div>
            </div>
    <?php  } ?>
        </div>
      </div>
    </div>
  </body>
</html>
