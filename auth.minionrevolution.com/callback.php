<?php

	$page = "callback.php";
	$message = "";
	
	require '../public_html/minionrevolution.com/esqueele/connect.php';
	include_once ('classes/class.ssoAuth.php');
	include_once ('classes/class.getCharID.php');
	include_once ('classes/class.charPublic.php');
	
	if(isset($_GET["code"])){
		$codeReturn = ($_GET["code"]);
		$ssoAuth = new ssoAuth($codeReturn);
		var_dump($ssoAuth);
		echo "<br /><br />";
		$registerChar = new ESIcharPublic($ssoAuth->getCharID());
		
	} else {
		$message = "Failure on submmission to EVE ESI SSO";
	}
	
	echo $message;
?>

