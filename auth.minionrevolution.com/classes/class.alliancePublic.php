<?php

	include_once ('/home/dickinso/auth.minionrevolution.com/classes/class.httpGetCall.php');
	
/*
	Class:		.
	Author:		Jeremie M Adams
	Project:	minionrevolution.com
	Date: 		9/8/2018
	Status:		DEV - 
	T B C :		N/A
*/

class ESIalliancePublic {

	/*	Attributes	*/
	
	private $url = "";
	private $alliance_id;
	private $creator_corporation_id;
	private $creator_id;
	private $date_founded;
	private $executor_corporation_id;
	private $name;
	private $ticker;
	private $response;

	/*	Methods		*/
	
	private function rowCheck(){
		require '/home/dickinso/auth.minionrevolution.com/esqueele/connect.php';

		$sqlStatement = "SELECT * FROM `ESI_AlliancePublic` WHERE `ESI_AlliancePublic_ID` = ".$this->alliance_id;
		$result = $connection->query($sqlStatement);
		
		if ($result->num_rows != 0) {
			$sqlInsert = $connection->prepare("UPDATE `ESI_AlliancePublic` SET  `ESI_AlliancePublic_CreatorCorpID` = ?, `ESI_AlliancePublic_CreatorID` = ?, `ESI_AlliancePublic_DateFounded` = ?, `ESI_AlliancePublic_ExecutorCorpID` = ?, `ESI_AlliancePublic_Name` = ?, `ESI_AlliancePublic_Ticker` = ? WHERE `ESI_AlliancePublic_ID` = ?");
			$sqlInsert->bind_param('iisissi', $this->creator_corporation_id, $this->creator_id, $this->date_founded, $this->executor_corporation_id, $this->name, $this->ticker, $this->alliance_id);
						
			if ($sqlInsert->execute()) {
				echo $this->name . ": Record updated successfully<br />";
			} else {
				echo "<br />Update Error in SQL Injection - Alliance Update<br />" . var_dump($sqlInsert);
			}
			
		} else {
			$sqlInsert = $connection->prepare("INSERT INTO `ESI_AlliancePublic` (`ESI_AlliancePublic_ID`, `ESI_AlliancePublic_CreatorCorpID`, `ESI_AlliancePublic_CreatorID`, `ESI_AlliancePublic_DateFounded`, `ESI_AlliancePublic_ExecutorCorpID`, `ESI_AlliancePublic_Name`, `ESI_AlliancePublic_Ticker`) VALUES (?, ?, ?, ?, ?, ?, ?)");

			$sqlInsert->bind_param('iiisiss', $this->alliance_id, $this->creator_corporation_id, $this->creator_id, $this->date_founded, $this->executor_corporation_id, $this->name, $this->ticker);

			if ($sqlInsert->execute()) {
				echo $this->name . ": New record created successfully<br />";
			} else {
				echo "<br />Error in SQL Injection - Alliance Inject<br />" . var_dump($sqlInsert);
			}
		}
	}

	////***	Constructor
	
	function __construct($inAllianceID){
		$this->alliance_id = $inAllianceID;
		$this->setURL($inAllianceID);
		$esiCall = new httpGetCall($this->url);
		$this->response = $esiCall->getResponse();
		$this->setAllianceDetails();
		$this->rowCheck();
		$this->
		return;
	}
	
	////***	Modifier Functions
	
	////***	Set Functions
	
	private function setURL($inAllianceID) {
		$this->url = "https://esi.evetech.net/latest/alliances/".$inAllianceID."/?datasource=tranquility";
		return;
	}
	
	private function setAllianceDetails(){
		$this->creator_corporation_id = $this->response->creator_corporation_id;
		$this->creator_id = $this->response->creator_id;
		$this->date_founded = $this->response->date_founded;
		$this->executor_corporation_id = $this->response->executor_corporation_id;
		$this->name = $this->response->name;
		$this->ticker = $this->response->ticker;
		return;
	}

	////***	Get Functions

}

?>