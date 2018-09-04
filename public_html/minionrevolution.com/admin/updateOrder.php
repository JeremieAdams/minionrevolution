<?php

	$page = "admin/updateOrder.php";
	
	session_start();
	
	if (!isset($_SESSION["mini_account"])){
		header('Location: ../index.php');
	}

	include_once ('../classes/class.pagelog.php');

	//$pageLog = new PageLog($page);

	require '../esqueele/connect.php';
	
	if(isset($_POST['amount']) && $_POST['amount'] != ""){
		if(isset($_POST['orderID']) && $_POST['orderID'] != ""){
			if(isset($_POST['message']) && $_POST['message'] != ""){
				echo "Record Updated";
				
				$orderID = $_POST['orderID'];
				$deposit = $_POST['amount'];
				$issuer = $_SESSION["mini_account"];
				
				$sqlBalance = "SELECT `order_balance`, `order_pin` FROM `order` WHERE `order_id` = $orderID";
				$resultBalance = $connection->query($sqlBalance);
				$rowResult = $resultBalance->fetch_assoc();
				$oldBalance = $rowResult["order_balance"];
				$OrderPin = $rowResult["order_pin"];
				
				$newBalance = $oldBalance - $deposit;
				
				if ($newBalance < 0){
					$deposit = $oldBalance;
					$newBalance = 0;
				}
				
				$sqlInsert = $connection->prepare("INSERT INTO  `dickinso_mini`.`update_log` (`update_id` ,`update_order_id` , `update_payment_amount` , `update_status_id` , `update_user_id` , `update_time` , `update_notes`)
				VALUES (NULL ,  ?, ?,  ?,  ?, CURRENT_TIMESTAMP ,  ?)");
				$sqlInsert->bind_param("isiis", $_POST['orderID'], $deposit, $_POST['orderStatus'], $issuer, $_POST['message']);
				$sqlInsert->execute();
				
				$sqlUpdate = $connection->prepare("UPDATE  `dickinso_mini`.`order` SET   `order_balance` =  ?, `order_status_id` =  ? WHERE  `order`.`order_id` = ?");
				$sqlUpdate->bind_param("sii", $newBalance, $_POST['orderStatus'], $_POST['orderID']);
				$sqlUpdate->execute();
				
				$order_id=$_POST['orderID'];
			} else {
				echo "Failure - Message";
				$order_id=$_POST['orderID'];
			}
		} else {
			echo "Failure - Order ID";
			$order_id=$_POST['orderID'];
		}
	} else if (!isset($_POST['amount'])){
		$order_id=(int)$_GET['order'];
	} else {
		echo "Failure - Amount";
		$order_id=$_POST['orderID'];
	}
	
	$sql = "SELECT  `order_id`, `order_contact`, `order_price`, `order_status_id`, `order_balance`, `hull_name`,  `fitting_desc`, `order_status_desc`
	FROM  `order` a
	LEFT JOIN `order_status` b ON `orderStatus_id` = `order_status_id`
	LEFT JOIN `fitting` c ON `order_fitting_id` = `fitting_id`
	LEFT JOIN  `hull` e ON  `fitting_hull_id` =  `hull_id`
	LEFT JOIN  `hullClass` d ON  `hull_class_id` =  `hullClass_id`
	WHERE order_id = $order_id";
	
	$sqlChanges = "SELECT `user_igName`, `order_status_desc`, `update_payment_amount`, `update_time`, `update_notes`
	FROM `update_log` a
	LEFT JOIN `order_status` b ON `orderStatus_id` = `update_status_id`
	LEFT JOIN `users` c ON `update_user_id` = `userID`
	WHERE `update_order_id` = $order_id";
	
	$sqlPin = "SELECT `order_pin` FROM `order` WHERE `order_id` = $order_id";
	$resultPin = $connection->query($sqlPin);
	$rowPin = $resultPin->fetch_assoc();
	$OrderPin = $rowPin["order_pin"];
	
	$sqlOptions = "SELECT * FROM `order_status`";

	$result = $connection->query($sql);
	$resultChanges = $connection->query($sqlChanges);
	$resultOptions = $connection->query($sqlOptions);
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
		<br>
		<?php 
			while($row = $result->fetch_assoc()) {
				echo  $row["order_contact"] . " - $" . number_format($row["order_price"]) .  " ISK - $" . number_format($row["order_balance"]) .  " ISK - " . $row["hull_name"] .  " - " . $row["fitting_desc"] .  " - " . $row["order_status_desc"];
			} 
		?>
		<form action="updateOrder.php" method="post">
			Payment Amount: <input type="text" name="amount"><br>
			Status:<select name="orderStatus">
				<?php
					while($rowOptions = $resultOptions->fetch_assoc()){
						echo '<option value="' . $rowOptions["orderStatus_id"] . '">' . $rowOptions["order_status_desc"] . '</option>';
					}
				?>
			</select><br>
			Notes:<br>
			<textarea name="message" rows="10" cols="50"></textarea><br>
			<input type="hidden" name="orderID" value="<?php echo $order_id ?>">
			<input type="submit" name="submit" value="Update">
		</form>
		<br><br>
		Change History
		<table>
				<?php while($rowChanges = $resultChanges->fetch_assoc()) {
					echo '<tr><td>' . $rowChanges["user_igName"] . '</td><td>$' . number_format($rowChanges["update_payment_amount"]) . ' ISK</td><td>' . $rowChanges["order_status_desc"] . '</td><td>' . $rowChanges["update_time"] . '</td><td>' . $rowChanges["update_notes"] . '</td></tr>';
				}?>
		</table><br><br>
		<a href="orderStatus.php">Back to Order Status Page</a><br><br>
		This is the text for the email to be sent to this buyer.  Copy and paste this into an email to him.<br><br>
		
		Greetings from Minion Revolution.  Thank you for your order.<br>
		If you would like to see status updates on your order you will need the following information:<br>
		www.minionrevolution.com/checkOrder.php<br>
		Order Number : <?php echo $order_id; ?><br>
		PIN : <?php echo $OrderPin; ?><br><br>
		
		If you have any quetions please contact us.<br><br>
		
		Thanks again for your order!!
		
		
<br>--------------------------------<br>		We have accepted your order and will begin production as soon as we confirm your deposit made to (Minion Revolution) in game corp.

 <br>--------------------------------<br> 
Your deposit has been confirmed and production has begun!

  <br>--------------------------------<br>
The last of your parts are in production and we will begin assembly of your ship as soon as they finish!

  <br>--------------------------------<br>
We have started assembling your ship and we will have it to you on or about    /  /17

<br>--------------------------------<br>
We have finished building your parts and will now begin assembling your ship and it should be contracted to you for the balance due on or about (date)

 <br>--------------------------------<br>
Your Order is complete and here is the contract for  the ballance due.<br>
(contract link)<br>
PS; if you would be so kind as to visit our forum page https://goonfleet.com/index.php/topic/209857-minnion-revolution-cap-emporium/?p=7712356  and give us some feed back. It would be greatly appreciated.
<br>
Again THANK YOU for choosing us  to fill your needs
<br>
MINI3 INDY TEAM

  <br>--------------------------------<br>
Your Order is complete and contracted to you<br>
PS; if you would be so kind as to visit our forum page https://goonfleet.com/index.php/topic/209857-minnion-revolution-cap-emporium/?p=7712356  and give us some feed back. It would be greatly appreciated.
<br>
Again THANK YOU for choosing us
		
		
		
		
		
	</body>
</html>