<?php

	$page = "order.php";

	include_once ('classes/class.pagelog.php');

	//$pageLog = new PageLog($page);

	require 'esqueele/connect.php';
	
	if(isset($_POST['submit'])){
		
	} 
	
	$fitting_id=(int)$_GET['fitting'];
	
	$sql = "SELECT `fitting_id`, `fitting_desc`, `fitting_cost`, `fitting_deposit`, `hull_name`, `hull_image` ,  `hullClass_name` ,  `factionName`, `hull_active`
	FROM `fitting` a
	LEFT JOIN `hull` b ON `fitting_hull_id` = `hull_id`
	LEFT JOIN  `hullClass` c ON  `hull_class_id` =  `hullClass_id` 
	LEFT JOIN  `faction` d ON  `hull_faction_id` =  `factionId`
	WHERE `fitting_id`=$fitting_id";
	
	$result = $connection->query($sql);
	$connection->close();
	
	$row = $result->fetch_assoc();
	
	$hullName = $row["hull_name"];
	$fittingDesc = $row["fitting_desc"];
	$fittingCost = $row["fitting_cost"];
	$fittingDeposit = $row["fitting_deposit"];
	$fittingDue = $fittingCost - $fittingDeposit;
	$factionName = $row["factionName"];
	$hullClassName = $row["hullClass_name"];
	$hullImage = $row["hull_image"];
	
	if ($row["hull_name"] === 0) {
		header( 'Location: http://www.yahoo.com' );
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<link rel="stylesheet" type="text/css" href="css/layout.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="icon" type="image/png" href="images/favicon.png" />
	<head>
		<title>
			Minion Revolution - Eve Online Community and Cap Shop.
		</title>
		<script>
			function validateForm() {
				var x = document.forms["orderForm"]["gameName"].value;
				if (x == "") {
					alert("Name must be filled out");
					return false;
				}
			}
		</script>
	</head>
	<body>
		<div class="shopWrapper">
			<div class="orderWindow">
				<div class="orderWindowHeader">
					Hull: <?php  echo $hullName . " - " . $hullClassName; ?>
				</div>
				<img src="images/<?php echo $hullImage ?>"><br><br>
				<form name="orderForm" action="submitOrder.php" onsubmit="return validateForm()" method="post">
					<table border="0" align="center">
						<tr>
							<td align="right">Fitting Description: </td><td align="left"><?php  echo $fittingDesc; ?></td>
						</tr>
						<tr>
							<td align="right">Total Cost: </td><td align="left"><?php  echo "$" . number_format($fittingCost); ?> ISK</td>
						</tr>
						<tr>
							<td align="right">Deposit: </td><td align="left"><?php  echo "$" . number_format($fittingDeposit); ?> ISK (required to be sent ASAP)</td>
						</tr>
						<tr>
							<td align="right">Due at Delivery: </td><td align="left"><?php  echo "$" . number_format($fittingDue); ?> ISK</td>
						</tr>
						<tr>
							<td align="right">In-Game name: </td><td align="left"><input type="text" name="gameName"></td>
						</tr>
						<tr>
							<td align="right">Delivery Location : </td><td align="left">
							<select name="delivery">
							  <option value="HZAQ-W">HZAQ-W</option>
							</select></td>
						</tr>
							<input type="hidden" name="fittingID" value="<?php echo $fitting_id ?>">
						<tr>
							<td>	 </td><td align="right"><input type="submit" name="submit" value="Place Order!"></td>
						</tr>
				</form>
			</div>
		</div>	
	</body>
</html>