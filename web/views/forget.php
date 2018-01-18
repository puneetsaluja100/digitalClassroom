

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
    #forgetlinkform{
      display: block;
    }

    #otpform{
      display: none;
    }
    </style>
</head>
<body >
<div style="height:20%"></div>
<div class="mycard" style="height: 400px">
    <div id="forgetlinkform" class="mycard-header" style="height: 300px">
        <div class="logo" style="height: 60px">
            <a href="index.php"><img src="../../image/logo.png" style="max-height: 100%;max-width: 100%" alt="logo"></a>
        </div>
        <div class="form-heading" style="height: 60px;">Forget Password</div>
        <div class="form-group" style="height: 280px">
            <form class="login" action="" method="post" style="text-align: center">
                <input class="form-control" name="email" type="email" placeholder="@email"  required><br>
                <button class="mybutton" style="background-color: 	#FF6347" name="forget" type="submit">Send me link</button>
            </form>
        </div>
    </div>
    <div id="otpform" class="mycard-header" style="height: 300px">
        <div class="logo" style="height: 60px">
            <img src="../../image/logo.png" style="max-height: 100%;max-width: 100%" alt="logo">
        </div>
        <div class="form-heading" style="height: 60px;">Forget Password</div>
        <div class="form-group" style="height: 280px">
            <form class="login" action="" method="post" style="text-align: center">
                <input class="form-control" name="otp" type="number" placeholder="OTP"  required><br>
                <button class="mybutton" style="background-color: 	#FF6347" name="verifyotp" type="submit">Verify OTP</button>
            </form>
        </div>
    </div>
    <div class="mycard-footer" style="height: 100px;padding: 20px">
        <div class="footer-text"><a href="login.php">Sign in</a></div>
        <hr style="margin: 20px 20px 0 20px">
        <div class="contact-us">contact us</div>
    </div>
</div>
<div style="height: 10%"></div>

<script>
function getotp()
{
  document.getElementById("forgetlinkform").style.display = "none";
  document.getElementById("otpform").style.display ="block";
}
</script>
</body>
</html>




<?php
    if(isset($_POST['forget']))
    {
      $to = $_POST['email'];
      $subject = "Reset Password";
      $digit = 6;
      $otp = rand(pow(10,$digit-1),pow(10,$digit)-1);
      $cookie_name = "otp";
      setcookie($cookie_name, $otp, time() + (60 * 3), "/");
      $text = "Your OTP is:" + $otp;
      $headers = "From: tanmaysonkusle@gmail.com";
      mail($to,$subject,$text,$headers);
      ?>
      <script>
        alert("yes");
        document.getElementById("forgetlinkform").style.display = "none";
        document.getElementById("otpform").style.display ="block";
      </script>
      <?php
    }
    if(isset($_POST['verifyotp']))
    {
      if($_COOKIE["otp"]==$_POST["otp"])
      {
        header("Location:dashboard.php");
      }
    }

?>
