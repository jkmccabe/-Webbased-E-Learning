<html>
<head><title>PHP Mail Sender</title></head>
<body>
<?php

$FirstName = $_REQUEST['fullname'];
$userName = $_REQUEST['username'];
$Email = $_REQUEST['email']."@".$_REQUEST['emailEx'];
$verificationCode = $_REQUEST['verificationCode'];

$subject = "Email Verification";
$filePath = $_SERVER['HTTP_HOST'].''.str_replace("register.php","", $_SERVER["REQUEST_URI"]);

$Details = 'Hello '.$FirstName .', '.
'Please click this link to verify your account:  '.$filePath.'/verifyEmail.php?verificationCode=' . $verificationCode . '&username=' . $userName . ' \n\r'.
'Alternatively you may enter the following code upon login: '.$verificationCode;


//From
$headers = 'From: postmaster@localhost' . "\r\n" .
    'Reply-To: postmaster@localhost' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

// Mail of sender
$mail_from="postmaster@localhost";

// Enter your email address
$to = $Email;

$send_contact=mail($to,$subject,$Details,$headers);

// Check, if message sent to your email
// display message "We've recived your information"
if($send_contact){
echo "We've recived your contact information at";
}
else {
echo "ERROR";
}


?>

</body>
</html>