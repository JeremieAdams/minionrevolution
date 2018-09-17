<?php

	include_once ('class.getCharID.php');

/*
	Class:		.
	Author:		Jeremie M Adams
	Project:	minionrevolution.com
	Date: 		9/8/2018
	Status:		DEV - 
	T B C :		N/A
*/

class  tokenRefresh{

	/*	Attributes	*/
	
	private $url = 'https://login.eveonline.com/oauth/token';
	private $clientId = "5d842215afea43958e1b7e24ebef5d59";
	private $clientSecret = "QigNtmznSL70QIMB75tL55msO8GcAoMEDuXFywLQ";
	private $refreshToken;
	private $response;
	private $responseAccessToken;
	private $responseTokenType;
	private $responseExpiresIn;
	private $responseRefreshToken;
	private $currentDT;
		
	/*	Methods		*/

	private function cURLRequest() {
		$ch = curl_init();
		
		curl_setopt_array($ch, array(
		  CURLOPT_URL => $this->url,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "grant_type=refresh_token&refresh_token=".$this->refreshToken,
		  CURLOPT_HTTPHEADER => array(
			"authorization: Basic " . base64_encode($this->clientId . ":" . $this->clientSecret),
			"content-type: application/x-www-form-urlencoded"
		  ),
		  CURLOPT_RETURNTRANSFER => true
		));
		$this->setResponse(json_decode(curl_exec($ch)));
		return;
	}
	
	private function prepareSQL() {
		require './esqueele/connect.php';
		$now = new DateTime();
		$this->currentDT = $now->date;
		$sqlInsert = $connection->prepare("INSERT INTO `auth_Token` (`auth_Token_ID`, `auth_Token_CharacterID`, `auth_Token_AccessToken`, `auth_Token_RefreshToken`, `auth_Token_TokenType`, `auth_Token_DateTime`) VALUES (NULL, ?, ?, ?, ?, CURRENT_TIMESTAMP)");
		$sqlInsert->bind_param("isss", $this->charID, $this->responseAccessToken, $this->responseRefreshToken, $this->responseTokenType);
		
		if ($sqlInsert->execute()) {
			$last_id = $connection->insert_id;
			echo "New record created successfully : " . $last_id . "<br />";
		} else {
			echo "Error in SQL Injection";
		}
	}
	
	////***	Constructor
	
	function __construct($inString){
		$this->setRefreshToken($inString);
		$this->cURLRequest();
		$charIDCall = new getCharID($this->responseAccessToken);
		$this->setCharID($charIDCall->getCharID());
		$this->prepareSQL();
		return;
	}
	
	////***	Modifier Functions
	
	////***	Set Functions
	
	private function setRefreshToken($inString){
		$this->refreshToken = $inString;
	}

	private function setResponse($authResponse){
		$this->response = $authResponse;
		$this->responseAccessToken = $authResponse->access_token;
		$this->responseTokenType = $authResponse->token_type;
		$this->responseExpiresIn = $authResponse->expires_in;
		$this->responseRefreshToken = $authResponse->refresh_token;
		return;
	}
	
	private function setCharID($inInt) {
		$this->charID = $inInt;
		return;
	}
	
	////***	Get Functions
	
	public function getAccessToken(){
		return $this->responseAccessToken;
	}
}

?>