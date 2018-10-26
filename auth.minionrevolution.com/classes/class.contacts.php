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
	private $characterID;
	private $response;

	/*	Methods		*/
	
	private function loadContacts(){
		foreach ($this->response as $item){
			require '/home/dickinso/auth.minionrevolution.com/esqueele/connect.php';
			$sqlStatement = "SELECT * FROM `ESI_Contacts` WHERE `ESI_Contacts_CharID` = ".$this->characterID." AND `ESI_Contacts_ContactID` = ".$item->contact_id;
			$result = $connection->query($sqlStatement);
			if (!isset($item->is_watched)){
				$item->is_watched = False;
			}
			if (!isset($item->is_blocked)){
				$item->is_blocked = False;
			}
			if ($result->num_rows != 0) {
				echo "Contact exists in the database.<br />";
				$sqlInsert = $connection->prepare("UPDATE `dickinso_mini`.`ESI_Contacts` SET `ESI_Contacts_IsBlocked` = ?, `ESI_Contacts_IsWatched` = ?, `ESI_Contacts_Standing` = ?");
				$sqlInsert->bind_param('iid', $item->is_watched, $item->is_blocked, $item->standing);
				if ($sqlInsert->execute()) {
					echo $this->characterID . " and " . $item->contact_id . ": Record updated successfully<br />";
				} else {
					echo "<br />Update Error in SQL Injection - Contact Update<br />" . var_dump($sqlInsert);
				}
			} else {
				$sqlInsert = $connection->prepare("INSERT INTO `dickinso_mini`.`ESI_Contacts` (`ESI_Contacts_CharID`, `ESI_Contacts_ContactID`, `ESI_Contacts_ContactType`, `ESI_Contacts_IsBlocked`, `ESI_Contacts_IsWatched`, `ESI_Contacts_Standing`) VALUES (?,?,?,?,?,?)");
				$sqlInsert->bind_param('iisiid', $this->characterID, $item->contact_id, $item-> contact_type, $item->is_watched, $item->is_blocked, $item->standing);
				if ($sqlInsert->execute()) {
					echo $this->characterID . " and " . $item->contact_id . ": Record updated successfully<br />";
				} else {
					echo "<br />Update Error in SQL Injection - Contact Insert<br />" . var_dump($sqlInsert);
				}
			}
		}
	}
	
	private function 

	////***	Constructor
	
	function __construct($inCharID, $inToken){
		$this->setURL ($inCharID, $inToken);
		$this->setCharacterID($inCharID);
		$esiCall = new httpGetCall($this->url);
		$this->response = $esiCall->getResponse();
		$this->loadContacts();
	}
	
	////***	Modifier Functions
	
	////***	Set Functions
	
	private function setURL ($inInteger, $inString){
		$this->url = "https://esi.evetech.net/latest/characters/" . $inInteger . "/contacts/?datasource=tranquility&token=" . $inString;
		return;
	}
	
	private function setCharacterID($inInt){
		$this->characterID = $inInt;
		return;
	}

	////***	Get Functions

	public function getResponse(){
		return $this->response;
	}
}

?>