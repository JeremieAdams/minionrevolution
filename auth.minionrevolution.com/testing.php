<?php

	require '../public_html/minionrevolution.com/esqueele/connect.php';
	
	include_once ('classes/class.httpGetCall.php');
	include_once ('classes/class.token.php');
	include_once ('classes/class.getCharID.php');
	
/*	$systemRoute = "universe/systems";
	$systemInfoRoute = "universe/systems/";
	$mailRoute = "https://esi.evetech.net/latest/characters/94874035/mail/?datasource=tranquility&token=";
*/
	$refresh_token = 'lYMwbgLO6sjoF4TDsSAyCPw7ZqHX7hHKZMG1zZyUIdMRsKHGNVwtqNgWjISMkuLDq-6gzxTCdDjzVpUgjT1AiP5Y6z3VW9TQDoDLe7Lon3CrpXyf8_Q1q79Qdq_vIEVxQ--ZN-RVyTBTCdX8a1u1NRUoD25g_7zrvOmWRv93NCv9SL-IcFdS7bAVZzGkloajBv4jlz_ick1PONkJrdamHwMbLT66yFmnS-zpBzrmBVM1';
	
	$makeCall = new tokenRefresh($refresh_token);
	$accessToken = new getCharID($makeCall->getAccessToken());
	
	var_dump($makeCall);
	echo "<br /><br />";
	var_dump($accessToken);
	echo "<br /><br />";
	echo $accessToken->getCharName();
	
/*	$makeMailCall = new httpAuthGetCall($mailRoute,$makeCall->getAccessToken());	
	
	$makeCall = new httpGetCall($systemRoute);
	
	$i = 0;
	
	foreach($makeCall->getReponse() as $item){
		if ($i < 10) {
			$systemEndRoute = $systemInfoRoute.$item;
			$systemInfoCall = new httpGetCall($systemEndRoute);
			$syetemResponse = $systemInfoCall->getReponse();
			echo $syetemResponse->name."<br/>";
			//var_dump($systemInfoCall->getReponse());
		}
		$i++;
	}*/
	
	
//	echo "<br />".gmdate("Y-m-d")."T".gmdate("H:i:s").".000Z";

?>