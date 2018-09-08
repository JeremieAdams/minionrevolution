<?php

	$page = "callback.php";
	
	require '../public_html/minionrevolution.com/esqueele/connect.php';
	
//	$codeReturn = ($_GET["code"]);
	
	if(isset($_GET["code"])){
		$codeReturn = ($_GET["code"]);
		$url = 'https://login.eveonline.com/oauth/token';
		
		$sql = "SELECT * FROM `auth_AppConfig` LIMIT 1";
		$resultSql = $connection->query($sql);
		$clientData = $resultSql->fetch_assoc();
		$connection->close();
		
		$clientID = $clientData["auth_AppConfig_clientID"];
		$clientSecret = $clientData["auth_AppConfig_clientSecret"];
		$baseEncodeClient = base64_encode($clientID.":".$clientSecret);
		$headers = "authorization: ".$baseEncodeClient."\r\ncontent-type: application/x-www-form-urlencoded\r\nhost: login.eveonline.com";
		$fields = http_build_query(array('grant_type' => 'authorization_code', 'code' => $codeReturn));

		$ch = curl_init();
		
		curl_setopt_array($ch, array(
		  CURLOPT_URL => "https://login.eveonline.com/oauth/token",
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "grant_type=authorization_code&code=".$codeReturn,
		  CURLOPT_HTTPHEADER => array(
			"authorization: Basic " . base64_encode($clientId . ":" . $clientSecret),
			"content-type: application/x-www-form-urlencoded"
		  ),
		));

		$response = curl_exec($ch);
		$err = curl_error($ch);

		var_dump($response);
		
		echo "<br /><br />";
		
		var_dump($ch);

		
	} else {
		$message = "Failure on submmission to EVE ESI SSO";
	}
?>