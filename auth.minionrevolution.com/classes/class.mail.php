<?php
	
	include_once ('class.httpGetCall.php');

/*
	Class:		.
	Author:		Jeremie M Adams
	Project:	minionrevolution.com
	Date: 		9/8/2018
	Status:		DEV - 
	T B C :		N/A
	Example:	https://esi.evetech.net/latest/characters/94874035/mail/372677949/?datasource=tranquility&token=u9G6E0y3COr5rtL6WV_Ef_yz5V-HUpoqB7p4P59zyQRkPSlWz1_6tsfR6qWgbEchpjSWaBAUzNRjpl1V5RfGGg2
*/

class ESImail {

	/*	Attributes	*/
	
	private $url;
	private $response;

	/*	Methods		*/
	
	////***	Constructor
	
	function __construct($inMailID, $inCharID, $inToken){
		$this->setURL ($inMailID, $inCharID, $inToken);
		$esiCall = new httpGetCall($this->url);
		$this->response = $esiCall->getReponse();
	}
	
	////***	Modifier Functions
	
	////***	Set Functions
	
	private function setURL ($inInteger, $inInteger2, $inString){
		$this->url = "https://esi.evetech.net/latest/characters/" . $inInteger2 . "/mail/" . $inInteger . "?datasource=tranquility&token=" . $inString;
		return;
	}

	////***	Get Functions
	
	public function getResponse(){
		return $this->response;
	}

}

?>