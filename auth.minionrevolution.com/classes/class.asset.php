<?php
	
	include_once ('class.httpGetCall.php');

/*
	Class:		.
	Author:		Jeremie M Adams
	Project:	minionrevolution.com
	Date: 		9/8/2018
	Status:		DEV - 
	T B C :		N/A
	Example:	https://esi.evetech.net/latest/characters/94874035/assets/?datasource=tranquility&page=1&token=3ePLxg8WHe1gMmaBaSE8UgmyZ2n_Y5H1Ua0PlW-GnYvdtL90N5l4W2DJrsP9D0uQOw5uNJFEZL3IGPH8BtG2SA2
*/

class ESIasset {

	/*	Attributes	*/

	private $url;
	private $response;
	private $characterID;
	
	/*	Methods		*/
	
	private function dropRecords($charID){
		require '/home/dickinso/auth.minionrevolution.com/esqueele/connect.php';
		$sqlStatement = "DELETE FROM `ESI_Assets` WHERE `ESI_Assets_CharID` = ".$charID;
		$result = $connection->query($sqlStatement);
		$this->insertRecords();
		return;
	}
	
	private function insertRecords(){
		require '/home/dickinso/auth.minionrevolution.com/esqueele/connect.php';
		foreach($this->response as $item){
			$sqlInsert = $connection->prepare("INSERT INTO `dickinso_mini`.`ESI_Assets`(`ESI_Assets_CharID`, `ESI_Assets_Singleton`, `ESI_Assets_LocationFlag`, `ESI_Assets_LocationID`, `ESI_Assets_LocationType`, `ESI_Assets_Quantity`, `ESI_Assets_TypeID`, `ESI_Assets_ItemID`) VALUES (?,?,?,?,?,?,?,?)");
			$sqlInsert->bind_param('iisisiii', $this->characterID, $item->is_singleton, $item->location_flag, $item->location_id, $item->location_type, $item->quantity, $item->type_id, $item->item_id);
			if ($sqlInsert->execute()) {
				echo "Asset: " . $item->item_id . ": New record created successfully<br />";
			} else {
				echo "<br />Error in SQL Injection - Asset Insert<br />" . var_dump($sqlInsert);
			}
		}
	}

	////***	Constructor
	
	function __construct($inCharID, $inToken){
		$this->setURL($inCharID, $inToken);
		$this->setCharID($inCharID);
		$esiCall = new httpGetCall($this->url);
		$this->response = $esiCall->getResponse();
		$this->dropRecords($inCharID);
	}
	
	////***	Modifier Functions
	
	////***	Set Functions
	
	private function setURL ($inInteger, $inString){
		$this->url = "https://esi.evetech.net/latest/characters/" . $inInteger . "/assets/?datasource=tranquility&token=" . $inString;
		return;
	}
	
	private function setCharID ($inInteger){
		$this->characterID = $inInteger;
		return;
	}

	////***	Get Functions

	public function getResponse(){
		return $this->response;
	}
}

?>