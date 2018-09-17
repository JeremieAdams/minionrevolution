<?php

/*
	Class:		.
	Author:		Jeremie M Adams
	Project:	minionrevolution.com
	Date: 		9/8/2018
	Status:		DEV - 
	T B C :		N/A
*/

class  {

	/*	Attributes	*/

	/*	Methods		*/

	////***	Constructor
	
	function __construct(){
	
	}
	
	////***	Modifier Functions
	
	////***	Set Functions

	////***	Get Functions

}

?>



	
	private function fetchToken () {
		require './esqueele/connect.php';
		$sqlStatement = "SELECT `auth_Token_AccessToken`, `auth_Token_RefreshToken`, `auth_Token_DateTime` FROM `auth_Token` WHERE `auth_Token_CharacterID` = ".$this->character_id . " ORDER BY `auth_Token_ID` DESC LIMIT 1";
		$result = $connection->query($sqlStatement);
		$rowResults = $result->fetch_assoc();
		
		$this->tokenTime = new DateTime($rowResults["auth_Token_DateTime"]);
		$now = new DateTime();
		$interval = $now->diff($this->tokenTime);
		$minBetween = (($interval->days * 1440) + ($interval->h * 60) + $interval->i);
//		var_dump($this->tokenTime);
//		var_dump($now);
		echo $minBetween;
		
		if ($minBetween < 17) {
			$this->token = $rowResults["auth_Token_AccessToken"];
		} else {
			$tokenRefresh = new tokenRefresh($rowResults["auth_Token_RefreshToken"]);
			$this->token = $tokenRefresh->getAccessToken();
		}
	}