<?php

if($_SESSION['username'])
{
	RedirectToURL('include/member.php');
}
else
{
	RedirectToURL('include/login.php');
}



function RedirectToURL($url)
{
	header("Location: $url");
	exit;
}
