<?php

session_start();
if($_SESSION['username'])
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> Home Page </title>
			<link href="../css/style.css" rel="stylesheet" type="text/css">
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	</head>
	<?php include("../inc/header.php"); ?>
	<!-- Horizontal Menu -->
	<div id="menu"></div>
	<!-- Container -->
	<div id="container">
		<!-- Login Box-->
		<div id="loginBox"><h2>Login Successful</h2><P><?php echo "Welcome, " .$_SESSION['username']."!"; ?></P></div>
	</div>
	<?php include("../inc/footer.html"); ?>
	<body>

	</body>
</html>
<?php
	}else{
	RedirectToURL("login.php");
	echo "Wrong password";
		}
?>
<?php
    function RedirectToURL($url)
    {
        header("Location: $url");
        exit;
    }
?>



