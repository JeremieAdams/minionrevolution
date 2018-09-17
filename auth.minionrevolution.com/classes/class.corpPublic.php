<?php

/*
	Class:		.
	Author:		Jeremie M Adams
	Project:	minionrevolution.com
	Date: 		9/8/2018
	Status:		DEV - 
	T B C :		N/A
*/

class ESIcorpPublic {

	/*	Attributes	*/
	
	private $url = "";
	private $corporation_id;
	private $alliance_id;
	private $ceo_id;
	private $date_founded;
	private $description;
	private $home_station_id;
	private $member_count;
	private $name;
	private $shares;
	private $tax_rate;
	private $ticker;
	private $corp_url;
	private $response;

	/*	Methods		*/
	
	private function rowCheck(){
		require './esqueele/connect.php';

		$sqlStatement = "SELECT * FROM `ESI_CharPublic` WHERE `ESI_CharPublic_ID` = ".$this->character_id;
		$result = $connection->query($sqlStatement);
		
		if ($result->num_rows) {
			$sqlInsert = $connection->prepare("UPDATE `dickinso_mini`.`ESI_CharPublic` SET `ESI_CharPublic_Alliance_ID` = ?, `ESI_CharPublic_Ancestry_ID` = ?, `ESI_CharPublic_Birthday` = ?, `ESI_CharPublic_Bloodline_ID` = ?, `ESI_CharPublic_Corp_ID` = ?, `ESI_CharPublic_Description` = ?, `ESI_CharPublic_Gender` = ?, `ESI_CharPublic_Name` = ?, `ESI_CharPublic_Race_ID` = ?, `ESI_CharPublic_Security_Status` = ? WHERE ESI_CharPublic_ID = ?");
			$sqlInsert->bind_param('iiisiisssid', $this->character_id, $this->alliance_id, $this->ancestry_id, $this->birthday, $this->bloodline_id, $this->corporation_id, $this->description, $this->gender, $this->name, $this->race_id, $this->security_status);
		} else {
			$sqlInsert = $connection->prepare("INSERT INTO `dickinso_mini`.`ESI_CharPublic` (`ESI_CharPublic_ID`, `ESI_CharPublic_Alliance_ID`, `ESI_CharPublic_Ancestry_ID`, `ESI_CharPublic_Birthday`, `ESI_CharPublic_Bloodline_ID`, `ESI_CharPublic_Corp_ID`, `ESI_CharPublic_Description`, `ESI_CharPublic_Gender`, `ESI_CharPublic_Name`, `ESI_CharPublic_Race_ID`, `ESI_CharPublic_Security_Status`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");

			$sqlInsert->bind_param('iiisiisssid', $this->character_id, $this->alliance_id, $this->ancestry_id, $this->birthday, $this->bloodline_id, $this->corporation_id, $this->description, $this->gender, $this->name, $this->race_id, $this->security_status);

			if ($sqlInsert->execute()) {
				echo "New record created successfully<br />";
			} else {
				echo "<br />Error in SQL Injection<br />";
			}
		}
	}

	////***	Constructor
	
	function __construct($inCorpID){
		$this->corporation_id = $inCorpID;
		$this->setURL($inCorpID);
		$esiCall = new httpGetCall($this->url);
		$this->response = $esiCall->getReponse();
		$this->setCorpDetails();
	}
	
	////***	Modifier Functions
	
	////***	Set Functions
		
	private function setURL($inCorpID) {
		$this->url = "https://esi.evetech.net/latest/corporations/".$inCorpID."/?datasource=tranquility";
		return;
	}
	
	private function setCorpDetails(){
		$this->alliance_id = $this->response->alliance_id;
		$this->ceo_id = $this->response->ceo_id;
		$this->date_founded = $this->response->date_founded;
		$this->description = $this->response->description;
		$this->home_station_id = $this->response->home_station_id;
		$this->member_count = $this->response->member_count;
		$this->name = $this->response->name;
		$this->shares = $this->response->shares;
		$this->tax_rate = $this->response->tax_rate;
		$this->ticker = $this->response->ticker;
		$this->corp_url = $this->response->url;
		return;
	}

	////***	Get Functions

}

?>