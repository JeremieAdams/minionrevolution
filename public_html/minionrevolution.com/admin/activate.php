<?php

	$page = "activate.php";
	
	session_start();
	
	if (!isset($_SESSION["mini_account"])){
		header('Location: ../index.php');
	}

	include_once ('../classes/class.pagelog.php');
	
	require '../esqueele/connect.php';
	
	$message = "";
	
	if (isset($_POST['formSubmit'])) {
		$sqlUpdate = $connection->prepare("UPDATE `fitting` SET `fitting_cost`=?, `fitting_deposit`=?, `fitting_time_delay`=? WHERE `fitting_id`=?");
		$sqlUpdate->bind_param("ssii", $_POST['cost'], $_POST['deposit'], $_POST['delay'], $_POST['fitting_id']);
		
		if ($_POST['hull'] == 'YES'){
			$active = 1;
		} else {
			$active = 0;
		}
		
		$sqlHull = $connection->prepare("UPDATE `hull` SET `hull_active`=? WHERE `hull_id`=?");
		$sqlHull->bind_param("ii", $active, $_POST['hull_id']);
		$sqlHull->execute();
		$sqlUpdate->execute();
		
		//$message = "Hull: " . $_POST['hull_id'] . " Fitting: " . $_POST['fitting_id'] . " Active: " . $_POST['hull'] . " Cost: " . $_POST['cost'] . " Deposit: " . $_POST['deposit'] . " Active: " . $_POST['delay'] . "<br>";
		
	}

	//$pageLog = new PageLog($page);
	
	$sql = "SELECT  `hull_id`, `hull_name` ,  `hullClass_name` ,  `factionName`, `hull_active`
	FROM  `hull` a
	LEFT JOIN  `hullClass` b ON  `hull_class_id` =  `hullClass_id` 
	LEFT JOIN  `faction` c ON  `hull_faction_id` =  `factionId`
	ORDER BY  `hull_class_id` ASC ,  `hull_faction_id` ASC";
	
	$sqlListing = "SELECT  `hull_id` ,  `hull_name` ,  `hull_active` , `hullClass_name`,  `fitting_cost` ,  `fitting_deposit` ,  `fitting_id` ,  `fitting_time_delay` 
	FROM  `hull` a
	LEFT JOIN  `hullClass` b ON  `hull_class_id` =  `hullClass_id` 
	LEFT JOIN  `faction` c ON  `hull_faction_id` =  `factionId` 
	LEFT JOIN  `fitting` d ON  `fitting_hull_id` =  `hull_id` 
	ORDER BY  `hull_class_id` ASC ,  `hull_faction_id` ASC ";

	$result = $connection->query($sql);
	$resultListing = $connection->query($sqlListing);
	$connection->close();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<link rel="stylesheet" type="text/css" href="css/layout.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="icon" type="image/png" href="../images/favicon.png" />
	<head>
		<title>
			Minion Revolution - Eve Online Community and Cap Shop.
		</title>
	</head>
	<body>
		<a href="orderStatus.php">Back to Order Status Page</a><br><br>
		<table>
			<tr>
				<th>Hull Name</th>
				<th>Hull Type</th>
				<th>Active</th>
				<th>Total Cost</th>
				<th>Deposit</th>
				<th>E.T.C.</th>
				<th></th>
			</tr>
			<?php
				echo $message . "<br>";
				while($rowListing = $resultListing->fetch_assoc()) {
					if ($rowListing["hull_active"] == 1) {
						 $checked = 'checked';
					 } else {
						  $checked = '';
					 }
					echo '<tr><form name="' . $rowListing["hull_name"] . '" action="activate.php" method="post"><td>' . $rowListing["hull_name"] . '</td><td>' . $rowListing["hullClass_name"] . '</td><td><input type="checkbox" name="hull" id="' . $rowListing["hull_id"] . '" value="YES" ' .  $checked . '/></td><td><input type="text" name="cost" value="' . $rowListing["fitting_cost"] . '"></td><td><input type="text" name="deposit" value="' . $rowListing["fitting_deposit"] . '"></td><td><input type="text" name="delay" value="' . $rowListing["fitting_time_delay"] . '"></td><td><input type="hidden" name="hull_id" value="' . $rowListing["hull_id"] . '"><input type="hidden" name="fitting_id" value="' . $rowListing["fitting_id"] . '"><input type="submit" name="formSubmit" value="Update ' . $rowListing["hull_name"] . '" /></form>';
				} 
			?>
		</table>
	</body>
</html>