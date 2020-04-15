<?php

include('../db/connectionI.php');
if(isset($_POST['admin']))
{
	// username and password sent from form 
	$myusername=$_POST['UserName']; 
	$mypassword=$_POST['Password']; 
	if($myusername=="admin" and $mypassword="admin")
	{
		session_start();
		$_SESSION['type']="admin";
		header("location:../dashboard/dashboard.php");
	}
	else
	{
	header("location:login.php?a=error");
	}
}
?>
 
 



