<?php

	$page = "callback.php";
	
	require '../public_html/minionrevolution.com/esqueele/connect.php';
	
//	$codeReturn = ($_GET["code"]);
	
	if(isset($_GET["code"])){
		$codeReturn = ($_GET["code"]);
		$url = 'https://login.eveonline.com/oauth/token HTTP/1.1';
		
		$sql = "SELECT * FROM `auth_AppConfig` LIMIT 1";
		$resultSql = $connection->query($sql);
		$clientData = $resultSql->fetch_assoc();
		$connection->close();
		
		$clientID = $clientData["auth_AppConfig_clientID"];
		$clientSecret = $clientData["auth_AppConfig_clientSecret"];
		$baseEncodeClient = 'Basic '.base64_encode($clientID.":".$clientSecret);
		$headers = "Authorization: ".$baseEncodeClient."\r\nContent-Type: application/x-www-form-urlencoded\r\nHost: login.eveonline.com";
		$fields = http_build_query(array('grant_type' => 'authorization_code', 'code' => $codeReturn));

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, $headers);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$result = curl_exec($ch);

		var_dump(json_decode($result));

	} else {
		$message = "Failure on submmission to EVE ESI SSO";
	}
?>