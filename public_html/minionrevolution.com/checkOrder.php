<?php

	$page = "checkOrder.php";

	include_once ('classes/class.pagelog.php');

	//$pageLog = new PageLog($page);

	require 'esqueele/connect.php';
	
	$message = "";
	$numRows = 0;
	
	if(isset($_POST['orderID']) && $_POST['orderID'] != ""){
		if(isset($_POST['pinNumber']) && $_POST['pinNumber'] != ""){
			$orderID = $_POST['orderID'];
			$pin = $_POST['pinNumber'];
			$sqlOrder = "SELECT * FROM `order` WHERE `order_id` = $orderID AND `order_pin` = $pin";
			$resultBalance = $connection->query($sqlOrder);
			$numRows = $resultBalance->num_rows;
			if ($numRows == 1){
				$rowResult = $resultBalance->fetch_assoc();
				
				$sqlChanges = "SELECT `user_igName`, `order_status_desc`, `update_payment_amount`, `update_time`, `update_notes`
				FROM `update_log` a
				LEFT JOIN `order_status` b ON `orderStatus_id` = `update_status_id`
				LEFT JOIN `users` c ON `update_user_id` = `userID`
				WHERE `update_order_id` = $orderID";
				$resultChanges = $connection->query($sqlChanges);
				$connection->close();
				
			} else {
				$message = "Order number and PIN returned no match.";
			}
		} else {
			$message = "No PIN was entered.";
		}
	} else {
		$message = "No order number was entered.";
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
	</head>
	<body>
		<div class="shopWrapper">
			<div class="orderWindow">
				<?php echo $message; ?><br>
				<form action="checkOrder.php" method="post">
					Order Number: <input type="text" name="orderID"><br>
					PIN: <input type="text" name="pinNumber"><br>
					<input type="submit" name="submit" value="Check">
				</form>
				<br><br>
				Change History
				<table>
						<?php 
							if ($numRows == 1){
								while($rowChanges = $resultChanges->fetch_assoc()) {
									echo '<tr><td>' . $rowChanges["user_igName"] . '</td><td>$' . number_format($rowChanges["update_payment_amount"]) . ' ISK</td><td>' . $rowChanges["order_status_desc"] . '</td><td>' . $rowChanges["update_time"] . '</td><td>' . $rowChanges["update_notes"] . '</td></tr>';
								}
							}
						?>
				</table><br><br>
				<a href="capshop.php">Back to Cap Shop</a>
			</div>
		</div>
	</body>
</html>