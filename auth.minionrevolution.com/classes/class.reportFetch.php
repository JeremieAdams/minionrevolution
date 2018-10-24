<?php
	
	include_once ('/home/dickinso/auth.minionrevolution.com/classes/class.tokenCheck.php');
	include_once ('/home/dickinso/auth.minionrevolution.com/classes/class.mailHeaders.php');
	include_once ('/home/dickinso/auth.minionrevolution.com/classes/class.mail.php');
	include_once ('/home/dickinso/auth.minionrevolution.com/classes/class.contacts.php');
	include_once ('/home/dickinso/auth.minionrevolution.com/classes/class.asset.php');
	include_once ('/home/dickinso/auth.minionrevolution.com/classes/class.journal.php');
	include_once ('/home/dickinso/auth.minionrevolution.com/classes/class.transactions.php');
	
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
	private $mailHeaderResponse;
	private $mailResponse;
	private $contactResponse;
	private $assetResponse;
	private $journalResponse;
	private $transactionResponse;
	private $contractResponse;

	/*	Methods		*/

	////***	Constructor
	
	function __construct($inCharID){
	
	$this->setCharID($inCharID);

	$tokenCheck = new SSOtokenCheck($this->character_id);
	$this->setAuthToken($tokenCheck->getAccessToken());
	
	$mailHeaderCall = new ESImailHeaders($this->character_id, $this->authToken);
	$this->mailHeaderResponse = $mailHeaderCall->getResponse();
	$this->mailResponse = $mailHeaderCall->getMailResponse();
/*	for ($i = 0 ; $i < 1 ; $i++){
		var_dump($this->mailResponse[$i]);
	}
/*	var_dump($this->mailResponse);
	echo "<br /><br />";

/*	$contactCall = new ESIcontacts($this->character_id, $this->authToken);
	$this->contactResponse = $contactCall->getResponse();
	var_dump($contactCall);
	echo "<br /><br />";
	
	$assetCall = new ESIasset($this->character_id, $this->authToken);
	$this->assetResponse = $assetCall->getResponse();
	var_dump($assetCall);
	echo "<br /><br />";
	
	$journalCall = new ESIjournal($this->character_id, $this->authToken);
	$this->journalResponse = $journalCall->getResponse();
	var_dump($journalCall);
	echo "<br /><br />";
	
	$transactionsCall = new ESItransactions($this->character_id, $this->authToken);
	$this->transactionResponse = $transactionsCall->getResponse();
	var_dump($transactionsCall);
	echo "<br /><br />";
*/	}
	
	////***	Modifier Functions
	
	////***	Set Functions
	
	private function setCharID($inInteger){
		$this->character_id = $inInteger;
	}
	
	private function setAuthToken($inString){
		$this->authToken = $inString;
	}

	////***	Get Functions
	
	public function getMailHeadersResponse(){
		return $this->mailHeaderResponse;
	}
	
	public function getContactResponse(){
		return $this->contactResponse;
	}

	public function getAssetResponse(){
		return $this->assetResponse;
	}

	public function getJournalResponse(){
		return $this->journalResponse;
	}

	public function getTransactionResponse(){
		return $this->transactionResponse;
	}

	public function getContractResponse(){
		return $this->contractResponse;
	}
}

?>	