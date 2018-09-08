<?php

/*
	Class:		.
	Author:		Jeremie M Adams
	Project:	minionrevolution.com
	Date: 		9/8/2018
	Status:		DEV - 
	T B C :		N/A
*/

class ssoAuth {
	
	/*	Attributes	*/
	
	private $url = 'https://login.eveonline.com/oauth/token';
	private $clientId = "5d842215afea43958e1b7e24ebef5d59";
	private $clientSecret = "QigNtmznSL70QIMB75tL55msO8GcAoMEDuXFywLQ";
	private $codeReturn = "";
	
	/*	Methods		*/
	
	function cURLRequest() {
		$ch = curl_init();
		
		curl_setopt_array($ch, array(
		  CURLOPT_URL => $this->url,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "grant_type=authorization_code&code=".$this->codeReturn,
		  CURLOPT_HTTPHEADER => array(
			"authorization: Basic " . base64_encode($this->clientId . ":" . $this->clientSecret),
			"content-type: application/x-www-form-urlencoded"
		  ),
		  CURLOPT_RETURNTRANSFER => true
		));

		$response = json_decode(curl_exec($ch));
		
		echo $response->{'access_token'}."<br />";
		echo $response->{'refresh_token'}."<br />";
		echo $response->{'token_type'}."<br />";
		echo $response->{'expires_in'};
	}
	
	////***	Constructor
	
	function __construct($InCode)
	{
		$this->codeReturn = $InCode;
		$this->cURLRequest();
	}
	
	////***	Modifier Functions
	
	////***	Set Functions

	////***	Get Functions

}

?>