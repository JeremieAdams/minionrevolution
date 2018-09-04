<?php

/*
	Class:		Class contains the page load information for when the application is used by the in game browser.
				This will store in formation that is useful for internal purposes.
	Author:		Jeremie M Adams
	Project:	ISKino.com
	Date: 		1/7/2015
	Status:		Tested - Working
	T B C :		N/A
*/

class PageLog {

	/*	Attributes	*/
	
	private $pageLogID;
	private $pageLogIP;
	private $pageLogPage;
	private $pageLogDate;
	private $pageLogKey;
	private $pageLogUser;
	
	/*	Methods		*/

	function Register() {
		require 'esqueele/connect.php';
		if (!($insert = $connection->prepare('INSERT INTO pagelog (pagelog_ip, pagelog_page, pagelog_key, pagelog_user) VALUES ( ?, ?, ?, ?)'))) {
			echo "Prepare Failed: (" . $connection->errno . ") " . $connection->error;
			}

		if (!$insert->bind_param('ssss', $this->pageLogIP, $this->pageLogPage, $this->pageLogKey, $this->pageLogUser)) {
			echo "Bind Failed: (" . $connection->errno . ") " . $connection->error;
		}

		if (!$insert->execute()) {
				echo "Execute Failed: (" . $connection->errno . ") " . $connection->error;
		}
		$insert->close();
		$connection->close();
	}
	
	////***	Constructor

	function __construct($InPage)
	{
		$this->pageLogID = "";
		$this->pageLogIP = $_SERVER['REMOTE_ADDR'];
		$this->pageLogPage = $InPage;
		$this->pageLogDate = "";
		$this->pageLogKey = $_SESSION['sessionKey'];
		$this->pageLogUser = $_SESSION['userName'];
		$this->Register();
	}

	////***	Modifier Functions
	
	////***	Set Functions

	////***	Get Functions
	
}//Close Class function
?>