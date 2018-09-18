<?php
	
	include_once ('../class.httpGetCall.php');
	require ('../esqueele/connect.php');
	
	$urlHead = "https://esi.evetech.net/latest/universe/constellations/";
	$urlTail = "?datasource=tranquility&language=en-us";
	
	$itemCall = new httpGetCall($urlHead.$urlTail);
	$response = $itemCall->getResponse();
	foreach($response as $value){
		$itemCall2 = new httpGetCall($urlHead.$value."/".$urlTail);
		$response2 = $itemCall2->getResponse();
		echo "Const No: ". $value . " Name: " . $response2->name . " ";
		
		$sqlStatement = "SELECT * FROM `ESI_Const` WHERE `ESI_Const_ID` = ". $value;
		$result = $connection->query($sqlStatement);
		
		if ($result->num_rows != 0) {
			$sqlInsert = $connection->prepare("UPDATE `ESI_Const` SET `ESI_Const_Name` = ?, `ESI_Const_Position` = ?, `ESI_Const_RegionID` = ?, ESI_Const_Systems = ? WHERE ESI_Const_ID = ?");
			$sqlInsert->bind_param('ssisi', $response2->name, $response2->position, $response2->region_id, $response->systems, $value);
				
			if ($sqlInsert->execute()) {
				echo "Record updated successfully<br />";
			} else {
				echo "<br />Update Error in SQL Injection<br />";
			}
		
		} else {
			$sqlInsert = $connection->prepare("INSERT INTO `ESI_Const` (`ESI_Const_ID`, `ESI_Const_Name`, `ESI_Const_Position`, `ESI_Const_RegionID`, `ESI_Const_Systems`) VALUES (?,?,?,?)");
			$sqlInsert->bind_param('issis', $value, $response2->name, $response2->position, $response2->region_id, $response->systems,);

			if ($sqlInsert->execute()) {
				echo "New record created successfully<br />";
			} else {
				echo "<br />Error in SQL Injection<br />";
			}
		}
	}
?>