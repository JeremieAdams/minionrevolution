<?php

	include_once ('class.httpGetCall.php');

/*
	Class:		.
	Author:		Jeremie M Adams
	Project:	minionrevolution.com
	Date: 		9/8/2018
	Status:		DEV - 
	T B C :		N/A
*/

class ESImailHeaders {

	/*	Attributes	*/
	
	private $url;
	private $response;
	private $characterID;
	private $token;
	private $mailResponse = [];

	/*	Methods		*/
	
	private function fetchMails(){
		foreach ($this->response as $item){
			$esiMailCall = new httpGetCall("https://esi.evetech.net/latest/characters/" . $this->characterID . "/mail/". $item->mail_id ."/?datasource=tranquility&token=" . $this->token);
			array_push($this->mailResponse, $esiMailCall->getResponse());
		}
	}

	////***	Constructor
	
	function __construct($inCharID, $inToken){
		$this->characterID = $inCharID;
		$this->token = $inToken;
		$this->setURL ($inCharID, $inToken);
		$esiCall = new httpGetCall($this->url);
		$this->response = $esiCall->getResponse();
		$this->fetchMails();
	}
	
	////***	Modifier Functions
	
	////***	Set Functions
	
	private function setURL ($inInteger, $inString){
		$this->url = "https://esi.evetech.net/latest/characters/" . $inInteger . "/mail/?datasource=tranquility&token=" . $inString;
		return;
	}

	////***	Get Functions

	public function getResponse(){
		return $this->response;
	}
	
	public function getMailResponse(){
		return $this->mailResponse;
	}
}

?>