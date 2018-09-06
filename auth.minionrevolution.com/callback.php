<?php

	$page = "callback.php";
	
	require '../public_html/minionrevolution.com/esqueele/connect.php';
	
//	$codeReturn = ($_GET["code"]);
	
	if(isset($_GET["code"])){
		$codeReturn = ($_GET["code"]);
		$url = 'https://login.eveonline.com/oauth/token HTTP/1.1';
		$clientID = '5d842215afea43958e1b7e24ebef5d59';
		$clientSecret = 'QigNtmznSL70QIMB75tL55msO8GcAoMEDuXFywLQ';
		$baseEncodeClient = 'Basic ' . base64_encode($clientID . ":" . $clientSecret);
		$data = http_build_query(array('grant_type' => 'authorization_code', 'code' => $codeReturn));

		$options = array(
			'http' => array(
				'header'  => "Authorization: " . $baseEncodeClient . "\r\n
								Content-Type: application/x-www-form-urlencoded\r\n
								Host: login.eveonline.com",
				'method'  => 'POST',
				'content' => $data
			)
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
//		if ($result === FALSE) { }

		var_dump($result);

	} else {
		$message = "Failure on submmission to EVE ESI SSO";
	}
?>

<html>
	<br />
	<?php echo $codeReturn ?><br />
	
	<?php echo $baseEncodeClient ?><br />
	
	<?php foreach($options['http'] as $result) {
		echo $result, '<br />';
	} ?><br />
	
	<?php echo $data ?><br />

</html>