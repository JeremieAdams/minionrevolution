<?php

	include_once ('class.httpGetCall.php');
	include_once ('class.token.php');

/*
	Class:		.
	Author:		Jeremie M Adams
	Project:	minionrevolution.com
	Date: 		9/8/2018
	Status:		DEV - 
	T B C :		N/A
*/

class SSOtokenCheck {

	/*	Attributes	*/
	
	private $url;
	private $character_ID;
	private $accessToken;
	private $refreshToken;
	private $response;

	/*	Methods		*/
	
	private function expiryCheck(){
		if ($this->character_ID != $this->response->CharacterID){
			echo "Token expired: <br />";
			var_dump($this);
			$tokenCall = new tokenRefresh($this->refreshToken);
			$this->accessToken = $tokenCall->getAccessToken();
		}
		return;
	}

	////***	Constructor
	
	function __construct($inCharID){
		$this->character_ID = $inCharID;
		$this->setAccessToken();
		$esiCall = new httpGetCall($this->url);
		$this->response = $esiCall->getReponse();
		$this->expiryCheck();
		return;
	}
	
	////***	Modifier Functions
	
	////***	Set Functions
	
	private function setAccessToken(){
		require './esqueele/connect.php';
		$tokenCheck = "SELECT * FROM `auth_Token` WHERE `auth_Token_CharacterID` = " . $this->character_ID . " ORDER BY `auth_Token_ID` DESC LIMIT 1";
		$result = $connection->query($tokenCheck);
		$rowResults = $result->fetch_assoc();
		$this->accessToken = $rowResults["auth_Token_AccessToken"];
		$this->refreshToken = $rowResults["auth_Token_RefreshToken"];
		$this->setURL();
		return;
	}
	
	private function setURL(){
		$this->url = "https://esi.evetech.net/verify/?datasource=tranquility&token=" . $this->accessToken;
		return;
	}

	////***	Get Functions
	
	public function getAccessToken(){
		return $this->accessToken;
	}

}

?>