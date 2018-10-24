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
	Example:	https://esi.evetech.net/latest/characters/94874035/mail/372677949/?datasource=tranquility&token=u9G6E0y3COr5rtL6WV_Ef_yz5V-HUpoqB7p4P59zyQRkPSlWz1_6tsfR6qWgbEchpjSWaBAUzNRjpl1V5RfGGg2
*/

class ESImail {

	/*	Attributes	*/
	
	private $url;
	private $response;

	/*	Methods		*/
	
	private function LoadMail($inMailID){
		require '/home/dickinso/auth.minionrevolution.com/esqueele/connect.php';
		$sqlStatement = "SELECT * FROM `ESI_CharacterMails` WHERE `ESI_CharacterMails_MailID` = ".$inMailID;
		$result = $connection->query($sqlStatement);
		
		if ($result->num_rows != 0) {
			echo "Mail exists in the database.<br />";
		} else {
			$sqlInsert = $connection->prepare("INSERT INTO `dickinso_mini`.`ESI_CharacterMails` (`ESI_CharacterMails_MailID`, `ESI_CharacterMails_FromID`, `ESI_CharacterMails_Subject`, `ESI_CharacterMails_Timestamp`, `ESI_CharacterMails_Body`) VALUES (?,?,?,?,?)");

			$sqlInsert->bind_param('iisss', $inMailID, $this->response->from, $this->response->subject, $this->response->timestamp, strip_tags($this->response->body));

			if ($sqlInsert->execute()) {
				echo "Mail: " . $inMailID . ": New record created successfully<br />";
			} else {
				echo "<br />Error in SQL Injection <br />" . var_dump($sqlInsert);
			}
		}
	}
	
	////***	Constructor
	
	function __construct($inMailID, $inCharID, $inToken){
		$this->setURL ($inMailID, $inCharID, $inToken);
		$esiCall = new httpGetCall($this->url);
		$this->response = $esiCall->getResponse();
		$this->LoadMail($inMailID);
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