	<!-- Top header -->
	<div id="header">
		<div class="headerMenu">
<?php
			if($_SESSION['username'] && $_SESSION['username'] != "")
			{
?>
			<a class="headerFont" href="../include/logout.php">Logout</a>
<?php
			}
			else
			{
?>
			<a class="headerFont" href="../include/register.php">Register</a>&nbsp|&nbsp <a class="headerFont" href="../include/login.php">Login</a>
<?php
			}
?>
		</div>
	</div>