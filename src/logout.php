<?php
		session_start();
	
		if(isset($_SESSION['id']))
		{
			print_r($_SESSION);
			session_destroy();
		}

		header("Location: ../web/index.php#tologin");
?>
