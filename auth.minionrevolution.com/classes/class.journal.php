<?php

/*
	Class:		.
	Author:		Jeremie M Adams
	Project:	minionrevolution.com
	Date: 		9/8/2018
	Status:		DEV - 
	T B C :		N/A
	Example:	https://esi.evetech.net/latest/characters/94874035/wallet/journal/?datasource=tranquility&page=1&token=vKzNw04btsBTmRDfkQ_uQ2O-gN9G69fZjlzhSomE7yQaam7aBea7hRm_sMkvUpFFdQpoUdIOK_PCRwrWLvPnIA2
*/

class ESIjournal {

	/*	Attributes	*/
	
	private $url;
	private $response;
	private $characterID;
	private $tranIDS;

	/*	Methods		*/
	
	private function fetchJournalIDs(){
		require '/home/dickinso/auth.minionrevolution.com/esqueele/connect.php';
		$sqlStatement = "SELECT `ESI_Journal_JournalID` FROM `ESI_Journal` WHERE `ESI_Journal_CharID` = ".$this->characterID;
		$result = $connection->query($sqlStatement);
	}

	////***	Constructor
	
	function __construct($inCharID, $inToken){
		$this->setURL ($inCharID, $inToken);
		$this->setChar ($inCharID);
		$esiCall = new httpGetCall($this->url);
		$this->response = $esiCall->getResponse();
	}
	
	////***	Modifier Functions
	
	////***	Set Functions
	
	private function setURL ($inInteger, $inString){
		$this->url = "https://esi.evetech.net/latest/characters/" . $inInteger . "/wallet/journal/?datasource=tranquility&token=" . $inString;
		return;
	}
	
	private function setChar ($inChar){
		$this->characterID = $inChar;
		return;
	}

	////***	Get Functions

	public function getResponse(){
		return $this->response;
	}
}

?>