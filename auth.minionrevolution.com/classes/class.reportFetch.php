<?php
	
	include_once ('../classes/class.tokenCheck.php');
	include_once ('../classes/class.mailHeaders.php');
	include_once ('../classes/class.mail.php');
	include_once ('../classes/class.contacts.php');
	include_once ('../classes/class.asset.php');
	include_once ('../classes/class.journal.php');
	include_once ('../classes/class.transactions.php');
	
/*
	Class:		.
	Author:		Jeremie M Adams
	Project:	minionrevolution.com
	Date: 		9/8/2018
	Status:		DEV - 
	T B C :		N/A
*/

class ESIreportFetch {

	/*	Attributes	*/
	
	private $character_id;
	private $authToken;

	/*	Methods		*/

	////***	Constructor
	
	function __construct($inCharID){
	
	$this->setCharID($inCharID);

	$tokenCheck = new SSOtokenCheck($this->character_id);
	$this->setAuthToken($tokenCheck->getAccessToken());
	
	$mailHeaderCall = new ESImailHeaders($this->character_id, $this->authToken);
	var_dump($mailHeaderCall);
	echo "<br /><br />";

	$contactCall = new ESIcontacts($this->character_id, $this->authToken);
	var_dump($contactCall);
	echo "<br /><br />";
	
	$assetCall = new ESIasset($this->character_id, $this->authToken);
	var_dump($assetCall);
	echo "<br /><br />";
	
	$journalCall = new ESIjournal($this->character_id, $this->authToken);
	var_dump($journalCall);
	echo "<br /><br />";
	
	$transactionsCall = new ESItransactions($this->character_id, $this->authToken);
	var_dump($transactionsCall);
	echo "<br /><br />";
	}
	
	////***	Modifier Functions
	
	////***	Set Functions
	
	private function setCharID($inInteger){
		$this->character_id = $inInteger;
	}
	
	private function setAuthToken($inString){
		$this->authToken = $inString;
	}

	////***	Get Functions

}

?>	