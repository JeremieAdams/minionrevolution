<?php

	session_start();
	
	$page = "admin/report.php";
	
	include_once ('../classes/class.reportFetch.php');
	
	if(isset($_GET["charID"])){
		$buildReport = new ESIreportFetch($_GET["charID"]);
	} else {
		echo "No Character ID used. ";
	}
	
?>