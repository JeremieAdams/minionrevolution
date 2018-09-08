<?php
/*
	require '../public_html/minionrevolution.com/esqueele/connect.php';
	
	$sql = "SELECT * FROM `auth_AppConfig` LIMIT 1";
		$resultSql = $connection->query($sql);
		$clientData = $resultSql->fetch_assoc();
		$connection->close();
		
	$clientID = $clientData["auth_AppConfig_clientID"];
	$clientSecret = $clientData["auth_AppConfig_clientSecret"];
*/	
	

	$ch = curl_init();
	$clientId = "5d842215afea43958e1b7e24ebef5d59";
	$clientSecret = "QigNtmznSL70QIMB75tL55msO8GcAoMEDuXFywLQ";
	$code = "DwszI_rt6M25VRyk44rTzrso7d-dCR0upDN85K8Qeb7fSGjg4tLRdLAb9QIwn1Vg0";
	$codeReturn = ($_GET["code"]);

	curl_setopt_array($ch, array(
	  CURLOPT_URL => "https://login.eveonline.com/oauth/token",
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "grant_type=authorization_code&code=".$codeReturn,
	  CURLOPT_HTTPHEADER => array(
		"authorization: Basic " . base64_encode($clientId . ":" . $clientSecret),
		"content-type: application/x-www-form-urlencoded"
	  ),
	  CURLOPT_RETURNTRANSFER => true
	));

	$response = curl_exec($ch);

	echo $response;

?>