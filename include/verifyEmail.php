<?php ob_start(); ?> <!-- Had to have this code otherwise it gave me header() errors -->
<?php
	require_once("db_connect.php");
	session_start();

		$username = ($_GET['username']);

		$verificationCode = ($_GET['verificationCode']);

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

?>

<?php
    function RedirectToURL($url)
    {
        header("Location: $url");
        exit;
    }
?>
<?php ob_flush(); ?>