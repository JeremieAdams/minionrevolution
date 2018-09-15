<?php

/*
	Class:		.
	Author:		Jeremie M Adams
	Project:	minionrevolution.com
	Date: 		9/8/2018
	Status:		DEV - 
	T B C :		N/A
*/

class  httpGetCall{

	/*	Attributes	*/

	private $urlHead = "https://esi.evetech.net/latest/";
	private $urlTail = "/?datasource=tranquility&language=en-us";
	private $url;
	private $response;
		
	/*	Methods		*/
	
	private function cURLRequest() {
		$ch = curl_init();
		curl_setopt_array($ch, array(
		  CURLOPT_URL => $this->url,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
			"content-type: application/json"
		  ),
		  CURLOPT_RETURNTRANSFER => true
		));
		$this->response = json_decode(curl_exec($ch));
		return;
	}

	////***	Constructor
	
	function __construct($inRoute){
		$this->setRoute($inRoute);
		$this->cURLRequest();
	}
	
	////***	Modifier Functions
	
	////***	Set Functions

	private function setRoute($inRoute){
		$this->url = $this->urlHead.$inRoute.$this->urlTail;
		return;
	}
	
	////***	Get Functions
	
	public function getReponse(){
		return $this->response;
	}
}

?>