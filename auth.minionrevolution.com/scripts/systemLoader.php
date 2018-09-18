<?php
	
	include_once ('../class.httpGetCall.php');
	require ('../esqueele/connect.php');
	
	$urlHead = "https://esi.evetech.net/latest/universe/systems/";
	$urlTail = "?datasource=tranquility&language=en-us";
	
	$itemCall = new httpGetCall($urlHead.$urlTail);
	$response = $itemCall->getResponse();
	foreach($response as $value){
		$itemCall2 = new httpGetCall($urlHead.$value."/".$urlTail);
		$response2 = $itemCall2->getResponse();
		echo "System No: ". $value . " Name: " . $response2->name . " ";
		
		$sqlStatement = "SELECT * FROM `ESI_System` WHERE `ESI_System_ID` = ". $value;
		$result = $connection->query($sqlStatement);
		
		if ($result->num_rows != 0) {
			$sqlInsert = $connection->prepare("UPDATE `ESI_System` SET `ESI_System_ConstID` = ?, `ESI_System_Name` = ?, `ESI_System_SecurityStatus` = ? WHERE ESI_System_ID = ?");
			$sqlInsert->bind_param('isdi', $response2->constellation_id, $response2->name, $response->security_status, $value);
				
			if ($sqlInsert->execute()) {
				echo "Record updated successfully<br />";
			} else {
				echo "<br />Update Error in SQL Injection<br />";
			}
		
		} else {
			$sqlInsert = $connection->prepare("INSERT INTO `ESI_System` (`ESI_System_ID`, `ESI_System_ConstID`, `ESI_System_Name`, `ESI_System_SecurityStatus`) VALUES (?,?,?,?)");
			$sqlInsert->bind_param('iisd', $value, $response2->constellation_id, $response2->name, $response2->security_status);

			if ($sqlInsert->execute()) {
				echo "New record created successfully<br />";
			} else {
				echo "<br />Error in SQL Injection<br />";
			}
		}
	}
?>