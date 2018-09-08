<?php

	$page = "callback.php";
	$message = "";
	
	require '../public_html/minionrevolution.com/esqueele/connect.php';
	include_once ('classes/class.ssoAuth.php');
	
//	$codeReturn = ($_GET["code"]);
	
	if(isset($_GET["code"])){
		$codeReturn = ($_GET["code"]);
		
		$ssoAuth = new ssoAuth($codeReturn);

		
	} else {
		$message = "Failure on submmission to EVE ESI SSO";
	}
	
	echo $message;
?>

