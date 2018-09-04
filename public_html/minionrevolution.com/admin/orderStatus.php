<?php

	session_start();
	
	if (!isset($_SESSION["mini_account"])){
		header('Location: ../index.php');
	}
	
	$page = "admin/activate.php";

	//$pageLog = new PageLog($page);

	require '../esqueele/connect.php';
	
	$sql = "SELECT  `order_id`, `order_contact`, `order_price`, `order_balance`, `hull_name`,  `fitting_desc`, `order_status_desc`, `order_pin`
	FROM  `order` a
	LEFT JOIN `order_status` b ON `orderStatus_id` = `order_status_id`
	LEFT JOIN `fitting` c ON `order_fitting_id` = `fitting_id`
	LEFT JOIN  `hull` e ON  `fitting_hull_id` =  `hull_id`
	LEFT JOIN  `hullClass` d ON  `hull_class_id` =  `hullClass_id` 
	ORDER BY  `order_id` DESC";

	$result = $connection->query($sql);
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
		<a href="activate.php">Link to Edit Details of listing</a>
		<table border=1>
			<tr><th>Order ID</th><th>Contact Name</th><th>Order Price</th><th>Balance Due</th><th>Hull</th><th>Fitting</th><th>Status</th><th>PIN</th><th></th></tr>
			<?php 
				while($row = $result->fetch_assoc()) {
					if ($row["hull_active"] == 1) {
						 $checked = 'checked';
					 } else {
						  $checked = '';
					 }
					echo  '<tr><td>' . $row["order_id"] . "</td><td>" . $row["order_contact"] . "</td><td>$" . number_format($row["order_price"]) .  " ISK</td><td>$" . number_format($row["order_balance"]) .  " ISK</td><td>" . $row["hull_name"] .  "</td><td>" . $row["fitting_desc"] .  "</td><td>" . $row["order_status_desc"] .  "</td><td>" . $row["order_pin"] . '</td><td><a href="updateOrder.php?order=' . $row["order_id"] . '">Update Order</a></tr>';
				} 
			?>
		</table>
	</body>
</html>