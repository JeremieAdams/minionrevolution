<?php

/*
	Class:		.
	Author:		Jeremie M Adams
	Project:	minionrevolution.com
	Date: 		9/8/2018
	Status:		DEV - 
	T B C :		N/A
*/

class  getCharID {

	/*	Attributes	*/

	private $charUrlHead = "https://esi.evetech.net/verify/?datasource=tranquility&token=";
	private $charUrl = "";
	private $accessToken;
	private $characterID;
	private $characterName;
	private $characterExipiresOn;
	private $characterScopes;
	private $characterTokenType;
	private $characterOwnerHash;
	
	/*	Methods		*/
	
	private function cURLCharRequest() {
		$ch = curl_init();
		curl_setopt_array($ch, array(
		  CURLOPT_URL => $this->charUrl,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
			"content-type: application/json"
		  ),
		  CURLOPT_RETURNTRANSFER => true
		));
		$this->setCharacter(json_decode(curl_exec($ch)));
		return;
	}

	////***	Constructor
	
	function __construct($inString){
		$this->setCharacterRoute($inString);
		$this->cURLCharRequest();
		return;
	}
	
	////***	Modifier Functions
	
	////***	Set Functions
	
	private function setCharacter($charResponse) {
		$this->characterID = $charResponse->CharacterID;
		$this->characterName = $charResponse->CharacterName;
		$this->characterExipiresOn = $charResponse->ExpiresOn;
		$this->characterScopes = $charResponse->Scopes;
		$this->characterTokenType = $charResponse->TokenType;
		$this->characterOwnerHash = $charResponse->CharacterOwnerHash;
		return;
	}
	
	private function setCharacterRoute ($inString){
		$this->charUrl = $this->charUrlHead.$inString;
		return;
	}

	////***	Get Functions
	
	public function getCharID(){
		return $this->characterID;
	}
	
	public function getCharName(){
		return $this->characterName;
	}

}

?>