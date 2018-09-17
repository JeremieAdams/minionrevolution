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

	/*	Methods		*/

	////***	Constructor
	
	function __construct($inCharID, $inToken){
		$this->setURL ($inCharID, $inToken);
		$esiCall = new httpGetCall($this->url);
		$this->response = $esiCall->getReponse();
	}
	
	////***	Modifier Functions
	
	////***	Set Functions
	
	private function setURL ($inInteger, $inString){
		$this->url = "https://esi.evetech.net/latest/characters/" . $inInteger . "/wallet/journal/?datasource=tranquility&token=" . $inString;
		return;
	}

	////***	Get Functions

	public function getResponse(){
		return $this->response;
	}
}

?>