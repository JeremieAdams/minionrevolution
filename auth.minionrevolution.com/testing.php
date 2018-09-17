<?php
	
	include_once ('classes/class.tokenCheck.php');
	include_once ('classes/class.mailHeaders.php');
	include_once ('classes/class.mail.php');
	include_once ('classes/class.contacts.php');
	include_once ('classes/class.asset.php');
	include_once ('classes/class.journal.php');
	include_once ('classes/class.transactions.php');
	
	$charID = 94874035;

	$tokenCheck = new SSOtokenCheck($charID);
	var_dump($tokenCheck);
	$authToken = $tokenCheck->getAccessToken();
	echo "<br />authToken: " . $authToken . "<br />";
	
	$mailHeaderCall = new ESImailHeaders($charID, $authToken);
	var_dump($mailHeaderCall);
	echo "<br />";

	$contactCall = new ESIcontacts($charID, $authToken);
	var_dump($contactCall);
	echo "<br />";
	
	$assetCall = new ESIasset($charID, $authToken);
	var_dump($assetCall);
	echo "<br />";
	
	$journalCall = new ESIjournal($charID, $authToken);
	var_dump($journalCall);
	echo "<br />";
	
	$transactionsCall = new ESItransactions($charID, $authToken);
	var_dump($transactionsCall);
	echo "<br />";

?>