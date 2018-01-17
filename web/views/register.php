<?php
  session_start();
    if(isset($_POST['submitRegister']))
    {
		$usernameSignUp = getCorrectInput($_POST["username"]);
		$emailSignUp = getCorrectInput($_POST["email"]);
		$passwordSignUp = getCorrectInput($_POST["password"]);
		$salt = sha1(md5($passwordSignUp));
		$passwordSignUp = md5($salt.$passwordSignUp);
		$passwordSignUp_confirm = getCorrectInput($_POST["cpassword"]);
		$salt = sha1(md5($passwordSignUp_confirm));
		$passwordSignUp_confirm = md5($salt.$passwordSignUp_confirm);
    $roleSignUp = getCorrectInput($_POST["role"]);
    $college_idSignUp = getCorrectInput($_POST["college_id"]);
    $batchSignUp = getCorrectInput($_POST["batch"]);
    $yearSignUp = getCorrectInput($_POST["year"]);

		if($passwordSignUp != $passwordSignUp_confirm)
		{
			$errStringRegister = "* Passwords do not match!";
		}
		else
		{
			include "../../src/register.php";

			/*associative array with keys as the column name of table and their values as the values inserted by the user in the registration form*/
			$fields = array("username"=>$usernameSignUp,"college_id"=>$college_idSignUp,"email"=>$emailSignUp,"password"=>$passwordSignUp,"role"=>$roleSignUp,"college_id"=>$college_idSignUp,"batch"=>$batchSignUp,"year"=>$yearSignUp);
 			$result = register($fields);
			if($result === true)
			{
				header("Location: login.php");
			}
			else if($result === false)
			{
				$errStringRegister = "* This username already exists";
			}
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
    <link rel="stylesheet" href="../css/style.css">
    <style media="screen">
        #faculty{
          display: none;
        }
        #student{
          display: none;
        }
    </style>
</head>
<body >
<div style="height:5%"></div>
<div id="mycardID" class="mycard" style="height: 800px">
    <div id="mycard-headerID" class="mycard-header" style="height: 600px">
        <div class="logo" style="height: 60px">
            <a href="index.php"><img src="../../image/logo.png" style="max-height: 100%;max-width: 100%" alt="logo"></a>
        </div>
        <div class="form-heading" style="height: 60px;">Register</div>
        <div id="form-groupID" class="form-group" style="height: 480px">
            <form class="login"  action=""  method="post" style="text-align: center">
                <input class="form-control" name="username" type="text" placeholder="John Doe"  required><br>
                <input class="form-control" name="email" type="email" placeholder="@email" required><br>
                <input class="form-control" name="password" type="password" placeholder="#password" required><br>
                <input class="form-control" name="cpassword" type="password" placeholder="#confirm-password" required><br>
                <div class="radio">
                    <label><input type="radio" value="tr" name="role" onclick="faculty()"> Faculty </label>
                    <label><input type="radio" value="st" name="role" onclick="student()"> Student </label>
                </div><br>
                <div id="faculty">
                  <select name="batch">
                    <option  value="cse" >Computer science</option>
                    <option  value="ece" >Electrical</option>
                    <option  value="mech">Mechanical</option>
                    <option  value="meta">Metallurgy</option>
                  </select>
                </div>
                <div id="student">
                  <div>
                  <select name="year">
                    <option value="1">1st year</option>
                    <option value="2">2nd year</option>
                    <option value="3">3rd year</option>
                    <option value="4">4th year</option>
                  </select>
                  <select name="batch">
                    <option value="cse">Computer science</option>
                    <option value="ece" >Electrical</option>
                    <option value="mech">Mechanical</option>
                    <option value="meta">Metallurgy</option>
                  </div>
                  </select>
                  </div><br>
                  <div>
                      <input class="form-control" name="college_id" type="text" placeholder="College-ID" required><br>
                  </div>
                </div>
                <br>
                <button class="mybutton" name="submitRegister" type="submit">Sign up</button>
            </form>
        </div>
    </div>
    <div class="mycard-footer" style="height: 200px;">
        <div class="google">
            <button class="btn"><img src="../../image/google.png" style="height: 20px;width: 20px">   Sign up with Google+</button>
        </div>
        <div class="footer-text">Already have an account ? <a href="login.php">Sign in</a></div>
        <hr style="margin: 0">
        <div class="contact-us">contact us</div>
    </div>
</div>
<div style="height: 10%"></div>

<script>
    function faculty()
    {
        document.getElementById("faculty").style.display = "block";
        document.getElementById("student").style.display ="none";
        document.getElementById("mycardID").style.height = "800px";
        document.getElementById("mycard-headerID").style.height = "600px";
        document.getElementById("form-groupID").style.height = "480px";
    }
    function student()
    {
        document.getElementById("faculty").style.display = "none";
        document.getElementById("student").style.display ="block";
        document.getElementById("mycardID").style.height = "900px";
        document.getElementById("mycard-headerID").style.height = "700px";
        document.getElementById("form-groupID").style.height = "580px";

    }
</script>


</body>
</html>
