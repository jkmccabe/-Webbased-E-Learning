<?php ob_start(); ?> <!-- Had to have this code otherwise it gave me header() errors -->
<?php
	$self = $_SERVER['PHP_SELF'];
	require_once("db_connect.php");
?>
<?php
	if(isset($_REQUEST['submit']))
	{
	$error = validate();
		if ($error)
		{
			display_register($error);
		}
		else
		{
			$db_link = db_connect('project');
			$name = $_REQUEST['name'];
			$surname = $_REQUEST['surname'];
			$course = $_REQUEST['course'];
			$email = $_REQUEST['email']."@".$_REQUEST['emailEx'];
			$username = $_REQUEST['email'];
			$password = $_REQUEST['password'];
			$year = $_REQUEST['year'];
			$secretQuestion = $_REQUEST['secretQuestion'];
			$secretAnswer = $_REQUEST['secretAnswer'];
			$verificationCode = $_REQUEST['verificationCode'];


			$query = "INSERT INTO `user` (`name`,`surname`, `username`, `currentyear`, `course`, `email`, `password`, `verificationCode`, `verified`, `secretQuestion`,`secretAnswer`)
			VALUES ('$name','$surname', '$username', '$year ', '$course', '$email', password('$password'), '$verificationCode', 0, '$secretQuestion', '$secretAnswer')";

			$result= mysql_query($query) or die("Query failed with error: ".mysql_error());
			mysql_close($db_link);

			include("send_verification.php");
			RedirectToURL("../regsuccess.html");
		}
	}else
	{
	$error = '';
	display_register($error);
	}
	// Return an error string that is empty if there were no errors.
	// Otherwise it contains an error message.
	function validate()
	{

		$error = '';
		$db_link = db_connect('project');
		$name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
		$surname = isset($_REQUEST['surname']) ? $_REQUEST['surname'] : '';
		$course = isset($_REQUEST['course']) ? $_REQUEST['course'] : '';
		$email = isset($_REQUEST['email'])."@".isset($_REQUEST['emailEx']);
		$username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '';
		$password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';
		$year = isset($_REQUEST['year']) ? $_REQUEST['year'] : '';
		$repeatpassword = isset($_REQUEST['repeatpassword']) ? $_REQUEST['repeatpassword'] : '';
		$secretQuestion = isset($_REQUEST['secretQuestion']) ? $_REQUEST['secretQuestion'] : '';
		$secretAnswer = isset($_REQUEST['secretAnswer']) ? $_REQUEST['secretAnswer'] : '';


		$queryUsername = "SELECT username FROM user WHERE username='$username'";
		$queryEmail = "SELECT email FROM user WHERE email='$email'";
		$permittedEmail = 'hotmail.com';

		$result = mysql_query($queryUsername) or die (mysql_error());
		$numrowsUser = mysql_num_rows($result);
		$result = mysql_query($queryEmail) or die (mysql_error());
		$numrowsEmail = mysql_num_rows($result);
		mysql_close($db_link);

	//	if($numrowsUser == 1)
	//	{
	///		 $error .= "<span class=\"error\">Username already taken</span><br>";
	//	}
		if($numrowsEmail == 1)
		{
			 $error .= "<span class=\"error\">Email already in use</span><br>";
		}
		if($_REQUEST['emailEx'] != $permittedEmail)
		{
			$error .= "<span class=\"error\">Email is invalid (Example: yourname@provider.com)</span><br>";
		}
		if($password==$repeatpassword)
		{
			if(strlen($password)>25||strlen($password)<6)
			{
				$error .= "<span class=\"error\">Password should be between 6 and 25 characters</span><br>";
			}
		}
		else{
			$error .= "<span class=\"error\">Passwords dont match</span><br>";
		}
		$reg_exp = "/^[a-zA-Z'-]/";
		$reg_exp1 = "/^[a-zA-Z0-9]/";
		$reg_exp2 = "/^[0-9]$/";
		$reg_exp3 ="/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/";
		$string = "/^Security Question/";

		if (preg_match($string, $secretQuestion))
		{
		  $error .= "<span class=\"error\">Please choose your security question</span><br>";
		}
		if (!preg_match($reg_exp, $secretAnswer))
		{
		  $error .= "<span class=\"error\">Please choose your security answer</span><br>";
		}
		if (! preg_match($reg_exp, $name))
		{
		  $error .= "<span class=\"error\">Your name is invalid (letters only)</span><br>";
		}
		if (! preg_match($reg_exp, $surname))
		{
		  $error .= "<span class=\"error\">Your surname is invalid (letters only)</span><br>";
		}
		if (! preg_match($reg_exp, $course))
		{
		   $error .= "<span class=\"error\">Your course  is invalid (letters only)</span><br>";
		}
		if (! preg_match($reg_exp, $username))
		{
		   $error .= "<span class=\"error\">Your username is invalid (letters only)</span><br>";
		}
		if (! preg_match($reg_exp2, $year))
		{
		   $error .= "<span class=\"error\">Please choose your year</span><br>";
		}
		if (! preg_match($reg_exp1, $password))
		{
		   $error .= "<span class=\"error\">Please enter your password</span><br>";
		}
		return $error;
}
?>
<?php
    function RedirectToURL($url)
    {
        header("Location: $url");
        exit;
    }
    function verificationCode(){
		//generate random number
		$verificationCode = mt_rand();

	    echo $verificationCode;
}
?>
<?php
	function display_register($error)
	{
	   $self = $_SERVER['PHP_SELF'];
	   $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
	   $surname = isset($_REQUEST['surname']) ? $_REQUEST['surname'] : '';
	   $course = isset($_REQUEST['course']) ? $_REQUEST['course'] : '';
	   $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
	   $emailEx = isset($_REQUEST['emailEx']);
	   $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '';
	   $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';
	   $repeatpassword = isset($_REQUEST['repeatpassword']) ? $_REQUEST['repeatpassword'] : '';
	   $secretQuestion = isset($_REQUEST['secretQuestion']) ? $_REQUEST['secretQuestion'] : '';
	   $secretAnswer = isset($_REQUEST['secretAnswer']) ? $_REQUEST['secretAnswer'] : '';
	   $year = isset($_REQUEST['year']) ? $_REQUEST['year'] : '';
?>
<html>
<head>
	<link rel="stylesheet" href="../css/pwdwidget.css" type="text/css"/>
<script>
function passwordStrength(password)
{
	var desc = new Array();
	desc[0] = "Very Weak";
	desc[1] = "Weak";
	desc[2] = "Better";
	desc[3] = "Medium";
	desc[4] = "Strong";
	desc[5] = "Strongest";

	var score   = 0;

	if(password.match(/\d+/) && password.match(/[a-z]/) && password.length > 6) score++;
	//if password bigger than 6 give 1 point

	if (password.length > 6) score++;

	//if password has both lower and uppercase characters give 1 point
	if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;

	//if password has at least one special caracther give 1 point
	if ( password.match(/[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) )	score++;

	//if password bigger than 12 give another 1 point
	if (password.length > 12) score++;

    //if password has at least one number give 1 point
	 if (password.match(/\d+/)) score++;

	 document.getElementById("passwordDescription").innerHTML = desc[score];
	 document.getElementById("passwordStrength").className = "strength" + score;
}

function setUsername(username)
{
	document.getElementById("username").value = username;
}
</script>
</head>

    <body>
	<p><a href="../index.php">Index</a></p>
		<form method="POST" action="" id="user_registration" name="user_registration">
			<h3>Register</h3>
				<?php
				if ($error){
				   echo "<p>$error</p>\n";
				   }
				?>
			<table>
				<tr>
					<td><strong><label>Name</label></strong><input type="text" class="user_registrationInput" name="name" value="<?php echo $name?>"/></td>
				</tr>
				<tr>
				<tr>
					<td><strong><label>Surname</label></strong><input type="text" class="user_registrationInput" name="surname" value="<?php echo $surname?>"/></td>
				</tr>
				<tr>
					<td><strong><label>Email</label></strong><input type="text" class="user_registrationEmailInput"  name="email" value="<?php echo $email?>" onkeyup="setUsername(this.value)"/>@<input type="text" class="user_registrationEmailInput"  name="emailEx" value="<?php echo $emailEx?>" /></td>
				</tr>
				<tr>
					<td><strong><label>Course</label></strong><input type="text" class="user_registrationInput" name="course" value="<?php echo $course?>"/></td>
				</tr>
				<tr>
					<td><strong><label style="padding-right: 5px;">Year</label></strong>
					<select name = "year" value="<?php echo $year?>">
						<option>Choose Year</option>
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
					</select>
					</td>
				</tr>
				<tr>
					<td><strong><label>Username</label></strong><input type="text" id="username" class="user_registrationInput" name="username"  readonly="true" value="Set by email address"/></td>
				</tr>
				<tr>
					<td><strong><label for="pass">Password</label></strong><input type="password" class="user_registrationInput" name="password" onkeyup="passwordStrength(this.value)"/></td>
				</tr>
				<tr>
					<td style="padding-left: 90px;"><div id="passwordDescription"></div>
					<div id="passwordStrength" class="strength0"></div></td>
				</tr>
				<tr>
					<td><strong><label for="pass2">Repeat Password</label></strong><input type="password" class="user_registrationInput" name="repeatpassword"/></td>
				</tr>

				<tr>
					<td><strong><label style="padding-right: 5px;">Security Question</label></strong>
					<select name = "secretQuestion" value="<?php echo $secretQuestion?>">
						<option>Security Question</option>
						<option>What was the name of your first pet</option>
						<option>What is your favourite food</option>
						<option>What is your mothers maiden name</option>
						<option>What was the color of your first car</option>
						<option>In what city or town was your first job?</option>
					</select>
					</td>
				</tr>
				<tr>
					<td><strong><label>Security Answer</label></strong><input type="text" class="user_registrationInput" name="secretAnswer" value="<?php echo $secretAnswer?>"/></td>
					<input type="hidden"  name="verificationCode" value="<?php verificationCode() ?>">
				</tr>
				<tr>
					<td style="padding-left: 80px;"><input type="submit" name="submit" value="Register"/></td>
				</tr>
			</div>
			</table>
		</form>
    </body>
</html>
<?php
}
?>
<?php ob_flush(); ?>