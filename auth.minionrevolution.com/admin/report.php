<?php

	session_start();
	
	$page = "admin/report.php";
	
	include_once ('/home/dickinso/auth.minionrevolution.com/classes/class.reportFetch.php');
	
	if(isset($_GET["charID"])){
		$buildReport = new ESIreportFetch($_GET["charID"]);
	} else {
		echo "No Character ID used. ";
	}
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<link rel="stylesheet" type="text/css" href="css/layout.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="icon" type="image/png" href="../images/favicon.png" />
	<head>
	</head>
	<body>
	

		
	</body>
</html>