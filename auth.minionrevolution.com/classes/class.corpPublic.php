<?php

	include_once ('/home/dickinso/auth.minionrevolution.com/classes/class.httpGetCall.php');
	include_once ('/home/dickinso/auth.minionrevolution.com/classes/class.alliancePublic.php');
	
/*
	Class:		.com/admin
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
		require '/home/dickinso/auth.minionrevolution.com/esqueele/connect.php';

		$sqlStatement = "SELECT * FROM `ESI_CorpPublic` WHERE `ESI_CorpPublic_CorpID` = ".$this->corporation_id;
		$result = $connection->query($sqlStatement);
		
		if ($result->num_rows != 0) {
			$sqlInsert = $connection->prepare("UPDATE `ESI_CorpPublic` SET `ESI_CorpPublic_AllianceID` = ?, `ESI_CorpPublic_CEOID` = ?, `ESI_CorpPublic_DateFounded` = ?, `ESI_CorpPublic_Description` = ?, `ESI_CorpPublic_HomeStationID` = ?, `ESI_CorpPublic_MemberCount` = ?, `ESI_CorpPublic_Name` = ?, `ESI_CorpPublic_Shares` = ?, `ESI_CorpPublic_TaxRate` = ?, `ESI_CorpPublic_Ticker` = ?, `ESI_CorpPublic_CorpURL` = ? WHERE ESI_CorpPublic_CorpID = ?");
			$sqlInsert->bind_param('iissiisidssi', $this->alliance_id, $this->ceo_id, $this->date_founded, $this->description, $this->home_station_id, $this->member_count, $this->name, $this->shares, $this->tax_rate, $this->ticker, $this->corp_url, $this->corporation_id);
						
			if ($sqlInsert->execute()) {
				echo $this->name . ": Record updated successfully<br />";
			} else {
				echo "<br />Update Error in SQL Injection - Corp Update<br />" . var_dump($sqlInsert);
			}
			
		} else {
			$sqlInsert = $connection->prepare("INSERT INTO `ESI_CorpPublic` (`ESI_CorpPublic_CorpID`, `ESI_CorpPublic_AllianceID`, `ESI_CorpPublic_CEOID`, `ESI_CorpPublic_DateFounded`, `ESI_CorpPublic_Description`, `ESI_CorpPublic_HomeStationID`, `ESI_CorpPublic_MemberCount`, `ESI_CorpPublic_Name`, `ESI_CorpPublic_Shares`, `ESI_CorpPublic_TaxRate`, `ESI_CorpPublic_Ticker`, `ESI_CorpPublic_CorpURL`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

			$sqlInsert->bind_param('iiissiisidss', $this->corporation_id, $this->alliance_id, $this->ceo_id, $this->date_founded, $this->description, $this->home_station_id, $this->member_count, $this->name, $this->shares, $this->tax_rate, $this->ticker, $this->corp_url);

			if ($sqlInsert->execute()) {
				echo $this->name . ": New record created successfully<br />";
			} else {
				echo "<br />Error in SQL Injection - Corp Insert<br />" . var_dump($sqlInsert);
			}
		}
	}
	
	private function allianceCheck(){
		require '/home/dickinso/auth.minionrevolution.com/esqueele/connect.php';

		$sqlStatement = "SELECT * FROM `ESI_AlliancePublic` WHERE `ESI_AlliancePublic_ID` = ".$this->alliance_id;
		$result = $connection->query($sqlStatement);
		
		if ($result->num_rows == 0) {
			$allianceFire = new ESIalliancePublic($this->alliance_id);
		}
		return;
	}

	////***	Constructor
	
	function __construct($inCorpID){
		$this->corporation_id = $inCorpID;
		$this->setURL($inCorpID);
		$esiCall = new httpGetCall($this->url);
		$this->response = $esiCall->getResponse();
		$this->setCorpDetails();
		$this->rowCheck();
		if (isset($this->alliance_id)){
			$this->allianceCheck();
		};
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