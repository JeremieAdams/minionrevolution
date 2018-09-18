<?php
	
	include_once ('../class.httpGetCall.php');
	require ('../esqueele/connect.php');
	
	$urlHead = "https://esi.evetech.net/latest/universe/categories/";
	$urlTail = "?datasource=tranquility&language=en-us";
	
	//https://esi.evetech.net/latest/universe/categories/?datasource=tranquility
	//https://esi.evetech.net/latest/universe/categories/0/?datasource=tranquility&language=en-us
	
	$itemCall = new httpGetCall($urlHead.$urlTail);
	$response = $itemCall->getResponse();
	foreach($response as $value){
		$itemCall2 = new httpGetCall($urlHead.$value."/".$urlTail);
		$response2 = $itemCall2->getResponse();
		echo "Category No: ". $value . " Name: " . $response2->name . " ";
		
		$sqlStatement = "SELECT * FROM `ESI_Category` WHERE `ESI_Category_ID` = ". $value;
		$result = $connection->query($sqlStatement);
		
		if ($result->num_rows != 0) {
			$sqlInsert = $connection->prepare("UPDATE `ESI_Category` SET `ESI_Category_Groups` = ?, `ESI_Category_Name` = ?, `ESI_Category_Published` = ? WHERE ESI_Category_ID = ?");
			$sqlInsert->bind_param('issi', $response2->groups, $response2->name, $response2->published, $value);
				
			if ($sqlInsert->execute()) {
				echo "Record updated successfully<br />";
			} else {
				echo "<br />Update Error in SQL Injection<br />";
			}
		
		} else {
			$sqlInsert = $connection->prepare("INSERT INTO `ESI_Category` (`ESI_Category_ID`, `ESI_Category_Groups`, `ESI_Category_Name`, `ESI_Category_Published`) VALUES (?,?,?,?)");
			$sqlInsert->bind_param('issi', $value, $response2->groups, $response2->name, $response2->published);

			if ($sqlInsert->execute()) {
				echo "New record created successfully<br />";
			} else {
				echo "<br />Error in SQL Injection<br />";
			}
		}
	}
?>