<?php

	$page = "callback.php";
	
	require '../public_html/minionrevolution.com/esqueele/connect.php';
	
//	$codeReturn = ($_GET["code"]);
	
	if(isset($_GET["code"])){
		$codeReturn = ($_GET["code"]);
		$url = 'https://login.eveonline.com/oauth/token';
/*		
		$sql = "SELECT * FROM `auth_AppConfig` LIMIT 1";
		$resultSql = $connection->query($sql);
		$clientData = $resultSql->fetch_assoc();
		$connection->close();
		
		$clientID = $clientData["auth_AppConfig_clientID"];
		echo $clientID."<br />";
		$clientSecret = $clientData["auth_AppConfig_clientSecret"];
		echo $clientSecret."<br />";
*/		
		$clientId = "5d842215afea43958e1b7e24ebef5d59";
		$clientSecret = "QigNtmznSL70QIMB75tL55msO8GcAoMEDuXFywLQ";
		
		$ch = curl_init();
		
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

		$response = json_decode(curl_exec($ch));
		$err = curl_error($ch);
		
		echo $response->{'access_token'}."<br />";
		echo $response->{'refresh_token'};
		
	} else {
		$message = "Failure on submmission to EVE ESI SSO";
	}
?>