<?php
	
	include_once ('../class.httpGetCall.php');
	require ('../esqueele/connect.php');
	
	$urlHead = "https://esi.evetech.net/latest/";
	$urlTail = "/?datasource=tranquility&page=";
	$urlHead2 = "https://esi.evetech.net/latest/universe/types/";
	$urlTail2 = "?datasource=tranquility&language=en-us";
	$pageNumber = 1;
	$urlRoute = "universe/types";
	
	$numberArray = array();
	
	for ($x = 1; $x < 38 ; $x++) {
		$itemCall = new httpGetCall($urlHead.$urlRoute.$urlTail.$x);
		$response = $itemCall->getResponse();
		foreach($response as $value){
			//array_push($numberArray, $value);
			$itemCall2 = new httpGetCall($urlHead2.$value.$urlTail2);
			$response2 = $itemCall2->getResponse();
			echo "Item No: ". $value . " Name: " . $response2->name . " ";
			
			$sqlStatement = "SELECT * FROM `ESI_Types` WHERE `ESI_Types_ID` = ". $value;
			$result = $connection->query($sqlStatement);
			
			if ($result->num_rows != 0) {
				$sqlInsert = $connection->prepare("UPDATE `ESI_Types` SET `ESI_Types_Description` = ?, `ESI_Types_GroupID` = ?, `ESI_Types_Name` = ?, `ESI_Types_Published` = ?= ? WHERE ESI_Types_ID = ?");
				$sqlInsert->bind_param('sisii', $response2->description, $response2->group_id, $response2->name, $response2->published, $value);
				
				if ($sqlInsert->execute()) {
					echo "Record updated successfully<br />";
				} else {
					echo "<br />Update Error in SQL Injection<br />";
				}
				
			} else {
				$sqlInsert = $connection->prepare("INSERT INTO `ESI_Types` (`ESI_Types_ID`, `ESI_Types_Description`, `ESI_Types_GroupID`, `ESI_Types_Name`, `ESI_Types_Published`) VALUES (?,?,?,?,?)");

				$sqlInsert->bind_param('isisi', $value, $response2->description, $response2->group_id, $response2->name, $response2->published);

				if ($sqlInsert->execute()) {
					echo "New record created successfully<br />";
				} else {
					echo "<br />Error in SQL Injection<br />";
				}
			}
		}
	}
?>