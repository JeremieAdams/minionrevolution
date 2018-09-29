<?php

/*
	Class:		.
	Author:		Jeremie M Adams
	Project:	minionrevolution.com
	Date: 		9/8/2018
	Status:		DEV - 
	T B C :		N/A
	Example:	https://esi.evetech.net/latest/characters/94874035/contacts/?datasource=tranquility&page=1&token=3ePLxg8WHe1gMmaBaSE8UgmyZ2n_Y5H1Ua0PlW-GnYvdtL90N5l4W2DJrsP9D0uQOw5uNJFEZL3IGPH8BtG2SA2
*/

class ESIcontacts {

	/*	Attributes	*/
	
	private $url;
	private $response;

	/*	Methods		*/

	////***	Constructor
	
	function __construct($inCharID, $inToken){
		$this->setURL ($inCharID, $inToken);
		$esiCall = new httpGetCall($this->url);
		$this->response = $esiCall->getResponse();
	}
	
	////***	Modifier Functions
	
	////***	Set Functions
	
	private function setURL ($inInteger, $inString){
		$this->url = "https://esi.evetech.net/latest/characters/" . $inInteger . "/contacts/?datasource=tranquility&token=" . $inString;
		return;
	}

	////***	Get Functions

	public function getResponse(){
		return $this->response;
	}
}

?>