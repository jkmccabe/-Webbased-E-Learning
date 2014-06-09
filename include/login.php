<?php ob_start();?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Log In</title>
			<link href="css/style.css" rel="stylesheet" type="text/css">
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	</head>
<?php
	require_once("db_connect.php");

	if (isset($_REQUEST['username']) && isset($_REQUEST['password']))
	{
		$regExp = "^[a-zA-Z0-9]+$";

		$username = ($_REQUEST['username']);

		$password = ($_REQUEST['password']);

		$db_link = db_connect("project");
		$query = "SELECT * FROM user WHERE username = '$username' AND password = password('$password')";

		$result = mysql_query($query) or die (mysql_error());
		$numrows = mysql_num_rows($result);
		
		if($numrows == 1)
		{
			$_SESSION['valid_user'] = $username;
			$_SESSION['authenticated'] = true;

			mysql_free_result($result);
			mysql_close();
			$_SESSION['username']=$username;
			RedirectToURL("member.php");

		}
		else
		{
			login_page("Invalid login! Try again");
		}
	}
	else
	{
		$_SESSION['username'] = "";
		login_page("");
	}
?>
<?php
function login_page($message)
{
?>
	<body>
<?php include("../inc/header.php");?>
	<!-- Horizontal Menu -->
	<div id="menu"></div>
	<!-- Container -->
	<div id="container">
		<!-- Login Box-->
		<div id="loginBox">
			<form class="loginForm" method="POST">
			<h2 class="loginMessage"><?php echo $message?></h2>
				<table>
					<tr>
						<td><p class="loginFormText">Username</p><input type="text" name="username"/></td>
					</tr>
					<tr>
						<td><p class="loginFormText">Password</p><input type="password" name="password" /></td>
					</tr>
					<tr>
						<td><input class="loginButton" type="submit" value="Sign In" /></td>
					</tr>
					<tr>
						<td style="padding-top: 0.4em;">
						<a class="loginPassword" href="forgotpwd.php">Can't access your account?</a>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
<?php include("../inc/footer.html"); ?>
	</body>
</html>
<?php
}
?>
<?php
    function RedirectToURL($url)
    {
        header("Location: $url");
        exit;
    }
?>
<?php ob_flush(); ?>