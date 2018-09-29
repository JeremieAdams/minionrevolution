<?php

	include_once ('class.httpGetCall.php');
	include_once ('class.corpPublic.php');

/*
	Class:		.
	Author:		Jeremie M Adams
	Project:	minionrevolution.com
	Date: 		9/8/2018
	Status:		DEV - 
	T B C :		N/A
*/

class ESIcharPublic {

	/*	Attributes	*/
	
	private $url = "";
	private $character_id;
	private $alliance_id;
	private $ancestry_id;
	private $birthday;
	private $bloodline_id;
	private $corporation_id;
	private $description;
	private $gender;
	private $name;
	private $race_id;
	private $security_status;
	private $response;

	/*	Methods		*/
	
	private function rowCheck(){
		require './esqueele/connect.php';

		$sqlStatement = "SELECT * FROM `ESI_CharPublic` WHERE `ESI_CharPublic_ID` = ".$this->character_id;
		$result = $connection->query($sqlStatement);
		
		if ($result->num_rows != 0) {
			$sqlInsert = $connection->prepare("UPDATE `dickinso_mini`.`ESI_CharPublic` SET `ESI_CharPublic_Alliance_ID` = ?, `ESI_CharPublic_Ancestry_ID` = ?, `ESI_CharPublic_Birthday` = ?, `ESI_CharPublic_Bloodline_ID` = ?, `ESI_CharPublic_Corp_ID` = ?, `ESI_CharPublic_Description` = ?, `ESI_CharPublic_Gender` = ?, `ESI_CharPublic_Name` = ?, `ESI_CharPublic_Race_ID` = ?, `ESI_CharPublic_Security_Status` = ? WHERE ESI_CharPublic_ID = ?");
			$sqlInsert->bind_param('iiisiisssid', $this->character_id, $this->alliance_id, $this->ancestry_id, $this->birthday, $this->bloodline_id, $this->corporation_id, $this->description, $this->gender, $this->name, $this->race_id, $this->security_status);
			
			if ($sqlInsert->execute()) {
				echo $this->name . ": Record updated successfully<br />";
			} else {
				echo "<br />Update Error in SQL Injection<br />";
			}
			
		} else {
			$sqlInsert = $connection->prepare("INSERT INTO `dickinso_mini`.`ESI_CharPublic` (`ESI_CharPublic_ID`, `ESI_CharPublic_Alliance_ID`, `ESI_CharPublic_Ancestry_ID`, `ESI_CharPublic_Birthday`, `ESI_CharPublic_Bloodline_ID`, `ESI_CharPublic_Corp_ID`, `ESI_CharPublic_Description`, `ESI_CharPublic_Gender`, `ESI_CharPublic_Name`, `ESI_CharPublic_Race_ID`, `ESI_CharPublic_Security_Status`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");

			$sqlInsert->bind_param('iiisiisssid', $this->character_id, $this->alliance_id, $this->ancestry_id, $this->birthday, $this->bloodline_id, $this->corporation_id, $this->description, $this->gender, $this->name, $this->race_id, $this->security_status);

			if ($sqlInsert->execute()) {
				echo $this->name . ": New record created successfully<br />";
			} else {
				echo "<br />Error in SQL Injection <br />" . var_dump($sqlInsert);
			}
		}
	}
	
	private function corpCheck(){
		require './esqueele/connect.php';

		$sqlStatement = "SELECT * FROM `ESI_CorpPublic` WHERE `ESI_CorpPublic_CorpID` = ".$this->corporation_id;
		$result = $connection->query($sqlStatement);
		
		if ($result->num_rows == 0) {
			$corpFire = new ESIcorpPublic($this->corporation_id);
		}
		return;
	}

	////***	Constructor
	
	function __construct($inCharID){
		$this->character_id = $inCharID;
		$this->setURL($inCharID);
		$esiCall = new httpGetCall($this->url);
		$this->response = $esiCall->getResponse();
		$this->setCharDetails();
		$this->rowCheck();
		$this->corpCheck();
		return;
	}
	
	////***	Modifier Functions
	
	////***	Set Functions
	
	private function setURL($inCharID) {
		$this->url = "https://esi.evetech.net/latest/characters/".$inCharID."/?datasource=tranquility";
		return;
	}
	
	private function setCharDetails(){
		$this->alliance_id = $this->response->alliance_id;
		$this->ancestry_id = $this->response->ancestry_id;
		$this->birthday = $this->response->birthday;
		$this->bloodline_id = $this->response->bloodline_id;
		$this->corporation_id = $this->response->corporation_id;
		$this->description = $this->response->description;
		$this->gender = $this->response->gender;
		$this->name = $this->response->name;
		$this->race_id = $this->response->race_id;
		$this->security_status = $this->response->security_status;
		return;
	}
	
	////***	Get Functions

}

?>