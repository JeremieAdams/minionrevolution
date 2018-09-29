<?php
	
	include_once ('class.httpGetCall.php');
	include_once ('class.charPublic.php');
	
/*
	Class:		.
	Author:		Jeremie M Adams
	Project:	minionrevolution.com
	Date: 		9/8/2018
	Status:		DEV - 
	T B C :		N/A
*/

class charDetails {

	/*	Attributes	*/
	
	private $characterID;
	private $row;
	

	/*	Methods		*/
	
	private function findChar(){
		require './esqueele/connect.php';
		$sqlStatement = "SELECT * FROM `ESI_CharPublic` LEFT OUTER JOIN `ESI_CorpPublic` ON `ESI_CharPublic`.`ESI_CharPublic_Corp_ID` = `ESI_CorpPublic`.`ESI_CorpPublic_CorpID` LEFT OUTER JOIN `ESI_AlliancePublic` ON `ESI_CorpPublic`.`ESI_CorpPublic_AllianceID` = `ESI_AlliancePublic`.`ESI_AlliancePublic_ID` WHERE `ESI_CharPublic_ID` = " . $this->characterID;
		$result = $connection->query($sqlStatement);
		
		if ($result->num_rows != 0) {
			$this->row = $result->fetch_assoc();
		} else {
			$testing = new ESIcharPublic($this->characterID);
			$sqlStatementRecheck = "SELECT * FROM `ESI_CharPublic` LEFT OUTER JOIN `ESI_CorpPublic` ON `ESI_CharPublic`.`ESI_CharPublic_Corp_ID` = `ESI_CorpPublic`.`ESI_CorpPublic_CorpID` LEFT OUTER JOIN `ESI_AlliancePublic` ON `ESI_CorpPublic`.`ESI_CorpPublic_AllianceID` = `ESI_AlliancePublic`.`ESI_AlliancePublic_ID` WHERE `ESI_CharPublic_ID` = " . $this->characterID;
			$resultRecheck = $connection->query($sqlStatementRecheck);
			if ($resultRecheck->num_rows != 0) {
				$this->row = $resultRecheck->fetch_assoc();
			} else {
				echo "Unable to load character data.";
			}
		}
	}

	////***	Constructor
	
	function __construct($inCharID){
		$this->characterID = $inCharID;
		$this->findChar();
		var_dump($this->row);
	}
	
	////***	Modifier Functions
	
	////***	Set Functions

	////***	Get Functions

}

?>	