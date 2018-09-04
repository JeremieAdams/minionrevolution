<?php 

	$page = "submitOrder.php";

	include_once ('classes/class.pagelog.php');

	//$pageLog = new PageLog($page);

	
	if(isset($_POST["submit"])){
		
		require 'esqueele/connect.php';
		
		$webhookURL = "https://hooks.slack.com/services/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";
		
		$orderFittingId = $_POST["fittingID"];
		
		$sql = "SELECT  `fitting_cost`, `hull_name`
		FROM  `fitting` a
		LEFT JOIN  `hull` b ON  `fitting_hull_id` =  `hull_id` 
		WHERE  `fitting_id` = $orderFittingId";
		
		$result = $connection->query($sql);
		
		$row = $result->fetch_assoc();
		
		$orderContact = $_POST["gameName"];
		$orderPrice = $row["fitting_cost"];
		$orderdelivery = $_POST["delivery"];
		$hullName = $row["hull_name"];
		$orderPin = rand(1000,9999);
		
		$sqlInsert = $connection->prepare("INSERT INTO `order` (`order_id`, `order_fitting_id`, `order_contact`, `order_price`, `order_delivery`, `order_date`, `order_balance`, `order_status_id`, `order_pin`) VALUES (NULL, ?, ?, ?, ?, CURRENT_TIMESTAMP, ?, '1', ?)");
		
		$sqlInsert->bind_param("issssi", $orderFittingId, $orderContact, $orderPrice, $orderdelivery, $orderPrice, $orderPin);
		
		if ($sqlInsert->execute()) {
		
//		$sqlInsert = "INSERT INTO `order` (`order_id`, `order_fitting_id`, `order_contact`, `order_price`, `order_delivery`, `order_date`, `order_balance`, `order_status_id`, `order_pin`) VALUES (NULL, $orderFittingId, '$orderContact', $orderPrice, '$orderdelivery', CURRENT_TIMESTAMP, $orderPrice, '1', $orderPin);";
		
//		if ($connection->query($sqlInsert) === TRUE) {
			$last_id = $connection->insert_id;
			echo "New record created successfully : " . $last_id ;
//			payload={"text": "This is a line of text in a channel.\nAnd this is another line of text."}
			$msg = "<!channel>\nA new order has been placed.\n" . $orderContact . " has placed an order for a " . $hullName . " to be delivered to " . $orderdelivery . "\n The new order number is  " . $last_id;
			$payload = array('text' => $msg);
			$data =  "payload=" .  json_encode($payload);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $webhookURL);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($ch);
			if($result === false)
			{
				echo 'Curl error: ' . curl_error($ch);
			}

			curl_close($ch);										

			$connection->close();
		
			echo "Worked " . $orderContact . " wants hull " . $orderFittingId . " with " . $orderdelivery . " location for " . $orderPrice;
			$message = "You order was received!<br><br>Your order number is " . $last_id . "<br><br>You will be contacted by a Minion as soon as your deposit is received and recorded.<br>That EveMail will have important information regarding your order.<br><br>Thanks for you order!<br><MINI3>";
			
		} else {
			echo "Error: " . $sqlInsert . "<br>" . $connection->error;
			$message = "There was a failure with the site.\nWe apologize for the inconvienience.\nPlease contact someone with Minion Revolution and let us know of the problem!";
		}
	} else {
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
	</head>
	<body>
		<div class="shopWrapper">
			<div class="orderWindow">
				<?php echo $message; ?><br>
				<a href="capshop.php">Back to the CapShop</a>
			</div>
		</div>	
	</body>
</html>