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


class PageLoad {

	/*	Attributes	*/
	
	private $evepage;
	private $evetrusted;
	private $eveip;
	private $evename;
	private $evecharid;
	private $evecorpname;
	private $evecorpid;
	private $evealliancename;
	private $eveallianceid;
	private $everegionname;
	private $eveconstellationname;
	private $evesolarname;
	private $evestationname;
	private $evestationid;
	private $evecorprole;
	private $evesolarid;
	private $evefactionid;
	private $eveshipid;
	private $eveshipname;
	private $eveshiptypeid;
	private $eveshiptypename;
	
	/*	Methods		*/

	function Register() {
		require 'esqueele/connect.php';
		if (!($insert = $connection->prepare('INSERT INTO headerlog (headerlog_page, headerlog_trusted, headerlog_ip, headerlog_charName, headerlog_charID, headerlog_corpName, headerlog_corpID, headerlog_alliName, headerlog_alliID, headerlog_regName, headerlog_consName, headerlog_solarName, headerlog_stationName, headerlog_stationID, headerlog_corpRole, headerlog_solarID, headerlog_factionID, headerlog_shipID, headerlog_shipName, headerlog_shipTypeID, headerlog_shipTypeName) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'))) {
			echo "Prepare Failed: (" . $connection->errno . ") " . $connection->error;
			}

		if (!$insert->bind_param('sssssssssssssssssssss', $this->evepage, $this->evetrusted, $this->eveip, $this->evename, $this->evecharid, $this->evecorpname, $this->evecorpid, $this->evealliancename, $this->eveallianceid, $this->everegionname, $this->eveconstellationname, $this->evesolarname, $this->evestationname, $this->evestationid, $this->evecorprole, $this->evesolarid, $this->evefactionid, $this->eveshipid, $this->eveshipname, $this->eveshiptypeid, $this->eveshiptypename)) {
			echo "Bind Failed: (" . $connection->errno . ") " . $connection->error;
		}

		if (!$insert->execute()) {
				echo "Execute Failed: (" . $connection->errno . ") " . $connection->error;
		}
		$insert->close();
		$connection->close();
	}

	////***	Constructor

	function __construct($inPage)
	{
		$this->evepage = $inPage;
		$this->evetrusted = $_SERVER["HTTP_EVE_TRUSTED"];
		$this->eveip = $_SERVER['REMOTE_ADDR'];
		$this->evename = $_SERVER["HTTP_EVE_CHARNAME"];
		$this->evecharid = $_SERVER["HTTP_EVE_CHARID"];
		$this->evecorpname = $_SERVER["HTTP_EVE_CORPNAME"];
		$this->evecorpid = $_SERVER["HTTP_EVE_CORPID"];
		$this->evealliancename = $_SERVER["HTTP_EVE_ALLIANCENAME"];
		$this->eveallianceid = $_SERVER["HTTP_EVE_ALLIANCEID"];
		$this->everegionname = $_SERVER["HTTP_EVE_REGIONNAME"];
		$this->eveconstellationname = $_SERVER["HTTP_EVE_CONSTELLATIONNAME"];
		$this->evesolarname = $_SERVER["HTTP_EVE_SOLARSYSTEMNAME"];
		$this->evestationname = $_SERVER["HTTP_EVE_STATIONNAME"];
		$this->evestationid = $_SERVER["HTTP_EVE_STATIONID"];
		$this->evecorprole = $_SERVER["HTTP_EVE_CORPROLE"];
		$this->evesolarid = $_SERVER["HTTP_EVE_SOLARSYSTEMID"];
		$this->evefactionid = $_SERVER["HTTP_EVE_WARFACTIONID"];
		$this->eveshipid = $_SERVER["HTTP_EVE_SHIPID"];
		$this->eveshipname = $_SERVER["HTTP_EVE_SHIPNAME"];
		$this->eveshiptypeid = $_SERVER["HTTP_EVE_SHIPTYPEID"];
		$this->eveshiptypename = $_SERVER["HTTP_EVE_SHIPTYPENAME"];
		$this->Register();
	}

	////***	Modifier Functions

	////***	Set Functions

	////***	Get Functions

	function GetPage() {
		return $this->evepage;
	}
	
}//Close Class function
?>