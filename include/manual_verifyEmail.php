<?php ob_start(); ?> <!-- Had to have this code otherwise it gave me header() errors -->
<?php
	require_once("db_connect.php");
	session_start();

	if(isset($_REQUEST['submit']))
	{
		$verificationCode = ($_REQUEST['verificationCode']);
		$username = ($_GET['username']);

		$db_link = db_connect("project2");
		$query = "SELECT * FROM user WHERE username = '$username' AND verificationCode = '$verificationCode'";

		$result = mysql_query($query) or die (mysql_error());
		$numrows = mysql_num_rows($result);

		if($numrows == 1)
		{
			$query = "UPDATE user SET verified=1 WHERE username='$username'";

			$result = mysql_query($query) or die (mysql_error());


			print("Your account has been verified, You may now log in");
			mysql_close();
		}
		else
		{
			print("Sorry there was a problem with your verification");
		}

	}
?>

<html>
<head>
</head>
    <body>
	<p><a href="../index.html">Index</a></p>
		<form method="POST">
			<h2>Hello <?php echo $_GET['username'] ?> </h2>
			<h3>Please enter your email verification code below to verify your account</h3>
			<table>
				<tr>
					<td><p><strong><label>Confirmation Code</label></strong></p><input tabindex="1" class="inputtext" type="text" name="verificationCode" id="verificationCode" /></td>
				</tr>
				<tr>
					<td style="padding-top: 10px;"><input class="bprimarypub80" type="submit" name="submit" value="Confirm" /></td>
				</tr>
			</table>
		</form>
    </body>
</html>
<?php
    function RedirectToURL($url)
    {
        header("Location: $url");
        exit;
    }
?>
<?php ob_flush(); ?>