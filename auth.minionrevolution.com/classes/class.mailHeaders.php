<?php

	include_once ('/home/dickinso/auth.minionrevolution.com/classes/class.httpGetCall.php');
	include_once ('/home/dickinso/auth.minionrevolution.com/classes/class.fetchChar.php');
	
/*
	Class:		.
	Author:		Jeremie M Adams
	Project:	minionrevolution.com
	Date: 		9/8/2018
	Status:		DEV - 
	T B C :		N/A
*/

class ESImailHeaders {

	/*	Attributes	*/
	
	private $url;
	private $response;
	private $characterID;
	private $token;
	private $mailResponse = [];

	/*	Methods		*/
	
	private function fetchMails(){
		foreach ($this->response as $item){
			require '/home/dickinso/auth.minionrevolution.com/esqueele/connect.php';
			$sqlStatement = "SELECT * FROM `ESI_CharacterMails` WHERE `ESI_CharacterMails_MailID` = ".$item->mail_id;
			$result = $connection->query($sqlStatement);
			if ($result->num_rows != 0) {
				echo "Mail exists in the database.<br />";
			} else {
				$esiMailCall = new httpGetCall("https://esi.evetech.net/latest/characters/" . $this->characterID . "/mail/". $item->mail_id ."/?datasource=tranquility&token=" . $this->token);
				$mail = $esiMailCall->getResponse();
				$this->LoadMail($item->mail_id, $mail);
				array_push($this->mailResponse, $mail);
			}
		}
		return;
	}
	
	private function LoadMail($inMailID, $mailObject){
		require '/home/dickinso/auth.minionrevolution.com/esqueele/connect.php';
		
		$bodyAdjust  = strip_tags($mailObject->body);
		
		foreach ($mailObject->recipients as $item) {
			$sqlStatement = "SELECT * FROM `ESI_MailRelation` WHERE `ESI_MailRelation_MailID` = ".$inMailID." AND `ESI_MailRelation_RecipientID` = ".$item->recipient_id;
			$result = $connection->query($sqlStatement);
			if ($result->num_rows != 0) {
				echo "Mail relation exists in the database.<br />";
			} else {
				$sqlInsert = $connection->prepare("INSERT INTO `dickinso_mini`.`ESI_MailRelation` (`ESI_MailRelation_MailID`, `ESI_MailRelation_RecipientID`, `ESI_MailRelation_RecipientType`) VALUES (?,?,?)");
				
				$sqlInsert->bind_param('iis', $inMailID, $item->recipient_id, $item->recipient_type);
				if ($sqlInsert->execute()) {
					echo "Mail Relation: " . $inMailID . ": New record created successfully<br />";
					$fetchChar = new charDetails($mailObject->from);
				} else {
					echo "<br />Error in SQL Injection <br />" . var_dump($sqlInsert);
				}
			}
		}
		
		$sqlInsert = $connection->prepare("INSERT INTO `dickinso_mini`.`ESI_CharacterMails` (`ESI_CharacterMails_MailID`, `ESI_CharacterMails_FromID`, `ESI_CharacterMails_Subject`, `ESI_CharacterMails_Timestamp`, `ESI_CharacterMails_Body`, `ESI_CharacterMails_CharID`) VALUES (?,?,?,?,?,?)");

		$sqlInsert->bind_param('iisssi', $inMailID, $mailObject->from, $mailObject->subject, $mailObject->timestamp, $bodyAdjust, $this->characterID);

		if ($sqlInsert->execute()) {
			echo "Mail: " . $inMailID . ": New record created successfully<br />";
			$fetchChar = new charDetails($mailObject->from);
		} else {
			echo "<br />Error in SQL Injection <br />" . var_dump($sqlInsert);
		}
		return;
	}

	////***	Constructor
	
	function __construct($inCharID, $inToken){
		$this->characterID = $inCharID;
		$this->token = $inToken;
		$this->setURL ($inCharID, $inToken);
		$esiCall = new httpGetCall($this->url);
		$this->response = $esiCall->getResponse();
		$this->fetchMails();
	}
	
	////***	Modifier Functions
	
	////***	Set Functions
	
	private function setURL ($inInteger, $inString){
		$this->url = "https://esi.evetech.net/latest/characters/" . $inInteger . "/mail/?datasource=tranquility&token=" . $inString;
		return;
	}

	////***	Get Functions

	public function getResponse(){
		return $this->response;
	}
	
	public function getMailResponse(){
		return $this->mailResponse;
	}
}

?>