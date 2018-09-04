<?php

	$page = "purchase.php";

	include_once ('classes/class.pagelog.php');

	//$pageLog = new PageLog($page);

	require 'esqueele/connect.php';
	
	$ship_id=(int)$_GET['ship'];
	
	$sql = "SELECT `fitting_id`, `fitting_desc`, `fitting_cost`, `hull_name` ,  `hullClass_name` ,  `factionName`
	FROM `fitting` a
	LEFT JOIN `hull` b ON `fitting_hull_id` = `hull_id`
	LEFT JOIN  `hullClass` c ON  `hull_class_id` =  `hullClass_id` 
	LEFT JOIN  `faction` d ON  `hull_faction_id` =  `factionId`
	WHERE `fitting_hull_id`=$ship_id";

	$result = $connection->query($sql);
	$connection->close();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<link rel="stylesheet" type="text/css" href="css/layout.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="icon" type="image/png" href="images/favicon.png" />
	<head>
	</head>
	<body>
		
		<?php echo $ship_id . "<br>"; ?>
		
		<?php 
			while($row = $result->fetch_assoc()) {
				echo $row["hull_name"] . " " . $row["fitting_desc"] . " " . $row["fitting_cost"] . " " . $row["factionName"] . " " . $row["hullClass_name"] . " " . '<a href="order.php?fitting=' . $row["fitting_id"] . '">Order</a><br>';
			} 
		?>
		
	</body>
</html>