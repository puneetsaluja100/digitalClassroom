<?php


if(isset($_POST['submitLogin']))

{

  include "../../src/login.php";
  $password = getCorrectInput($_POST["password"]);
  $salt = sha1(md5($password));
  $password = md5($salt.$password);
  $fields = array("email"=>$_POST['email'],"password"=>$password);
  $result = login($fields);


  if($result)
  {
    session_start();
    $_SESSION['id'] = $result[0]['uid'];
    $_SESSION['role'] = $result[0]['role'];
    $role = "'".$_SESSION['role']."'";
    $teacher = "te";
    $student = "st";
    if($role=="'".$student."'")
    {
      header("Location:dashboard.php");
    }
    else if($role=="'".$teacher."'")
    {
      header("Location:teacher_dashboard.php");
    }
  }
  else
  {
    $errStringLogin = "* Invalid credentials";
  }
}

function getCorrectInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


?>










<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
    <link rel="stylesheet" media="screen and (min-width: 1000px)" href="../css/style.css">
    <link rel="stylesheet" media="screen and (max-width: 1000px)" href="../css/mobile.css" />
</head>
<body >
<div style="height:10%"></div>
<div class="row">
    <div id="home" class="mycard" style="height: 650px">
        <div id="homelogo" class="logo" style="height: 200px">
            <img src="../../image/logo.png" style="max-height: 100%;max-width: 100%" alt="logo">
        </div>
        <div id="logo-heading" style="height: 100px">Digital classroom</div>
        <div id="message" style="height: 250px">
            <quo
            <blockquote>There can be infinite uses of the computer and of new age technology,
            but if teachers themselves are not able to bring it into the classroom and make it work, then it fails.
              –Nancy Kassebaum
        </div>
        <div style="height: 100px" >
            <img src="../../image/digital_india.png" class="logo" style="width: 150px">

        </div>
    </div>
    <div id="home-login" class="mycard" style="height: 650px;width: 400px;margin-left: 0;">
        <div class="mycard-header" style="height: 450px">
            <div class="logo" style="height: 60px">

            </div>
            <div class="form-heading" style="height: 60px;">Login</div>
            <div class="form-group" style="height: 330px">
                <form class="login" action="" method="post" style="text-align: center">
                    <input class="form-control" name="email" type="email" placeholder="@email"  required><br>
                    <input class="form-control" name="password" type="password" placeholder="#password" required><br>
                    <div style="text-align: center"><a href="forget.php">forget password?</a> </div><br>
                    <button class="mybutton" name="submitLogin" type="submit">Sign in</button>
                </form>
            </div>
        </div>
        <div class="mycard-footer" style="height: 200px">
            <div class="google">
                <button class="btn"><img src="../../image/google.png" style="height: 20px;width: 20px">   Sign in with Google+</button>
            </div>
            <div class="footer-text"><a href="register.php">Create an account</a></div>
            <hr style="margin: 0">
            <div class="contact-us">contact us</div>
        </div>
    </div>
</div>
<div style="height: 5%"></div>
</body>
</html>
