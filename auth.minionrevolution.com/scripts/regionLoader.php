<?php
	
	include_once ('../class.httpGetCall.php');
	require ('../esqueele/connect.php');
	
	$urlHead = "https://esi.evetech.net/latest/universe/regions/";
	$urlTail = "?datasource=tranquility&language=en-us";
	
	$itemCall = new httpGetCall($urlHead.$urlTail);
	$response = $itemCall->getResponse();
	foreach($response as $value){
		$itemCall2 = new httpGetCall($urlHead.$value."/".$urlTail);
		$response2 = $itemCall2->getResponse();
		echo "Region No: ". $value . " Name: " . $response2->name . " ";
		
		$sqlStatement = "SELECT * FROM `ESI_Region` WHERE `ESI_Region_ID` = ". $value;
		$result = $connection->query($sqlStatement);
		
		if ($result->num_rows != 0) {
			$sqlInsert = $connection->prepare("UPDATE `ESI_Region` SET `ESI_Region_Constellations` = ?, `ESI_Region_Description` = ?, `ESI_Region_Name` = ? WHERE ESI_Region_ID = ?");
			$sqlInsert->bind_param('sssi', $response2->constellations, $response2->description, $response2->name, $value);
				
			if ($sqlInsert->execute()) {
				echo "Record updated successfully<br />";
			} else {
				echo "<br />Update Error in SQL Injection<br />";
			}
		
		} else {
			$sqlInsert = $connection->prepare("INSERT INTO `ESI_Region` (`ESI_Region_ID`, `ESI_Region_Constellations`, `ESI_Region_Description`, `ESI_Region_Name`) VALUES (?,?,?,?)");
			$sqlInsert->bind_param('isss', $value, $response2->constellations, $response2->description, $response2->name);

			if ($sqlInsert->execute()) {
				echo "New record created successfully<br />";
			} else {
				echo "<br />Error in SQL Injection<br />";
			}
		}
	}
?>