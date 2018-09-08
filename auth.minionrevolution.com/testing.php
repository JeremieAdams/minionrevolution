<?php

	require '../public_html/minionrevolution.com/esqueele/connect.php';
	
/*	$sql = "SELECT * FROM `auth_AppConfig` LIMIT 1";
		$resultSql = $connection->query($sql);
		$clientData = $resultSql->fetch_assoc();
		$connection->close();
		
	$clientID = $clientData["auth_AppConfig_clientID"];
	$clientSecret = $clientData["auth_AppConfig_clientSecret"];
*/
	$clientID2 = "5d842215afea43958e1b7e24ebef5d59";
	$clientSecret2 = "QigNtmznSL70QIMB75tL55msO8GcAoMEDuXFywLQ";
	
	echo "client 1 ".$clientID."<br />";
	echo "client 2 ".$clientID2."<br />";
	echo $clientSecret."<br />";
	echo $clientSecret2;
	
?>