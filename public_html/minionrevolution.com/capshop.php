<?php

	$page = "capshop.php";

	include_once ('classes/class.pagelog.php');

	//$pageLog = new PageLog($page);

	require 'esqueele/connect.php';

	$sqlTitan = "SELECT  `hull_id`, `hull_name` ,  `hull_image` ,  `hullClass_name` ,  `factionName`, `hull_active`, `fitting_desc`, `fitting_cost`, `fitting_deposit`, `fitting_id`, `fitting_time_delay`
	FROM  `hull` a
	LEFT JOIN  `hullClass` b ON  `hull_class_id` =  `hullClass_id` 
	LEFT JOIN  `faction` c ON  `hull_faction_id` =  `factionId`
	LEFT JOIN `fitting` d ON `fitting_hull_id` = `hull_id`
	WHERE `hull_class_id` = 1
	ORDER BY  `hull_class_id` ASC ,  `hull_faction_id` ASC";

	$sqlSuper = "SELECT  `hull_id`, `hull_name` ,  `hull_image` ,  `hullClass_name` ,  `factionName`, `hull_active`, `fitting_desc`, `fitting_cost`, `fitting_deposit`, `fitting_id`, `fitting_time_delay`
	FROM  `hull` a
	LEFT JOIN  `hullClass` b ON  `hull_class_id` =  `hullClass_id` 
	LEFT JOIN  `faction` c ON  `hull_faction_id` =  `factionId`
	LEFT JOIN `fitting` d ON `fitting_hull_id` = `hull_id`
	WHERE `hull_class_id` = 2
	ORDER BY  `hull_class_id` ASC ,  `hull_faction_id` ASC";
	
	$sqlCarrier = "SELECT  `hull_id`, `hull_name` ,   `hull_image` , `hullClass_name` ,  `factionName`, `hull_active`, `fitting_desc`, `fitting_cost`, `fitting_deposit`, `fitting_id`, `fitting_time_delay`
	FROM  `hull` a
	LEFT JOIN  `hullClass` b ON  `hull_class_id` =  `hullClass_id` 
	LEFT JOIN  `faction` c ON  `hull_faction_id` =  `factionId`
	LEFT JOIN `fitting` d ON `fitting_hull_id` = `hull_id`
	WHERE `hull_class_id` = 3
	ORDER BY  `hull_class_id` ASC ,  `hull_faction_id` ASC";
	
	$sqlDread = "SELECT  `hull_id`, `hull_name` ,   `hull_image` , `hullClass_name` ,  `factionName`, `hull_active`, `fitting_desc`, `fitting_cost`, `fitting_deposit`, `fitting_id`, `fitting_time_delay`
	FROM  `hull` a
	LEFT JOIN  `hullClass` b ON  `hull_class_id` =  `hullClass_id` 
	LEFT JOIN  `faction` c ON  `hull_faction_id` =  `factionId`
	LEFT JOIN `fitting` d ON `fitting_hull_id` = `hull_id`
	WHERE `hull_class_id` = 4
	ORDER BY  `hull_class_id` ASC ,  `hull_faction_id` ASC";
	
	$sqlFax = "SELECT  `hull_id`, `hull_name` ,  `hull_image` ,  `hullClass_name` ,  `factionName`, `hull_active`, `fitting_desc`, `fitting_cost`, `fitting_deposit`, `fitting_id`, `fitting_time_delay`
	FROM  `hull` a
	LEFT JOIN  `hullClass` b ON  `hull_class_id` =  `hullClass_id` 
	LEFT JOIN  `faction` c ON  `hull_faction_id` =  `factionId`
	LEFT JOIN `fitting` d ON `fitting_hull_id` = `hull_id`
	WHERE `hull_class_id` = 5
	ORDER BY  `hull_class_id` ASC ,  `hull_faction_id` ASC";
	
	$sqlFreighter = "SELECT  `hull_id`, `hull_name` ,  `hull_image` ,  `hullClass_name` ,  `factionName`, `hull_active`, `fitting_desc`, `fitting_cost`, `fitting_deposit`, `fitting_id`, `fitting_time_delay`
	FROM  `hull` a
	LEFT JOIN  `hullClass` b ON  `hull_class_id` =  `hullClass_id` 
	LEFT JOIN  `faction` c ON  `hull_faction_id` =  `factionId`
	LEFT JOIN `fitting` d ON `fitting_hull_id` = `hull_id`
	WHERE `hull_class_id` = 6
	ORDER BY  `hull_class_id` ASC ,  `hull_faction_id` ASC";
	
	$sqlORE = "SELECT  `hull_id`, `hull_name` ,   `hull_image` , `hullClass_name` ,  `factionName`, `hull_active`, `fitting_desc`, `fitting_cost`, `fitting_deposit`, `fitting_id`, `fitting_time_delay`
	FROM  `hull` a
	LEFT JOIN  `hullClass` b ON  `hull_class_id` =  `hullClass_id` 
	LEFT JOIN  `faction` c ON  `hull_faction_id` =  `factionId`
	LEFT JOIN `fitting` d ON `fitting_hull_id` = `hull_id`
	WHERE `hull_class_id` = 7
	ORDER BY  `hull_class_id` ASC ,  `hull_faction_id` ASC";
	
	$resultTitan = $connection->query($sqlTitan);
	$resultSuper = $connection->query($sqlSuper);
	$resultCarrier = $connection->query($sqlCarrier);
	$resultDread = $connection->query($sqlDread);
	$resultFax = $connection->query($sqlFax);
	$resultFreighter = $connection->query($sqlFreighter);
	$resultORE = $connection->query($sqlORE);
	$connection->close();
	
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

		</script>
	</head>
	<body>
<!--		<div class="shopBanner"> 
			Cap Shop:
		</div>												-->
		<div class="shopWrapper">
			<div class="FAQSectionWrapper">
				<span style="text-align: center">**** IMPORTANT INFORMATION ****</span>
				<ul>
					<li>No order will be started until deposit has been verified.</li>
					<li>Deposits must be made to the Minion Revolution Corporation.</li>
					<li>Deposits are not refundable, period.</li>
					<li>We are not responsible if you donate to the wrong corporation.**Double Check**</li>
					<li>Once Deposit is verified, you will be sent an EVEmail with order information</li>
					<li>When the order is completed, you will be contacted to arrange pickup.</li>
					<li>***Now included in your order is 10k racial Isotopes***</li>
				</ul>
				
			</div>
			<a href="checkOrder.php" class="CheckLink">Check On Order Status</a>
			<div class="shopSectionWrapper">
				<div id="shopSectionHeader">
					Titans
				</div>
				<div id="shopSectionBody">
					<?php 
						while($rowA = $resultTitan->fetch_assoc()) {
							if ($rowA["hull_active"] == 1) {
								$link = '<a href="order.php?fitting=' . $rowA["fitting_id"] . '"><img src="images/active.png"></a>';
							} else {
								$link = '<img src="images/inactive.png">';
							}
							$today = date("F j, Y", strtotime("+" . $rowA["fitting_time_delay"] . " days"));
							echo '<div id="shopLinkWrapper">
									<div id="shopLink">
										<span id="bolden1">' . $rowA["hull_name"] . '</span><br>
										<img src="images/' . $rowA["hull_image"] . '">
										<div id="shopText">
											<span id="bolden2">Total Cost</span><br>' . number_format($rowA["fitting_cost"]) . ' ISK<br>
											<span id="bolden2">Deposit Required</span><br>' . number_format($rowA["fitting_deposit"]) . ' ISK<br>
											<span id="bolden2">Expected Delivery</span><br>' . $today . '<br>
											' . $link . '
										</div>
									</div>
								</div>';
						} 
					?>
				</div>
			</div>
			<div class="shopSectionWrapper">
				<div id="shopSectionHeader">
					Super Carriers
				</div>
				<div id="shopSectionBody">
					<?php 
						while($rowA = $resultSuper->fetch_assoc()) {
							if ($rowA["hull_active"] == 1) {
								$link = '<a href="order.php?fitting=' . $rowA["fitting_id"] . '"><img src="images/active.png"></a>';
							} else {
								$link = '<img src="images/inactive.png">';
							}
							$today = date("F j, Y", strtotime("+" . $rowA["fitting_time_delay"] . " days"));
							echo '<div id="shopLinkWrapper">
									<div id="shopLink">
										<span id="bolden1">' . $rowA["hull_name"] . '</span><br>
										<img src="images/' . $rowA["hull_image"] . '">
										<div id="shopText">
											<span id="bolden2">Total Cost</span><br>' . number_format($rowA["fitting_cost"]) . ' ISK<br>
											<span id="bolden2">Deposit Required</span><br>' . number_format($rowA["fitting_deposit"]) . ' ISK<br>
											<span id="bolden2">Expected Delivery</span><br>' . $today . '<br>
											' . $link . '
										</div>
									</div>
								</div>';
						} 
					?>
				</div>
			</div>
			<div class="shopSectionWrapper">
				<div id="shopSectionHeader">
					Carriers
				</div>
				<div id="shopSectionBody">
					<?php 
						while($rowA = $resultCarrier->fetch_assoc()) {
							if ($rowA["hull_active"] == 1) {
								$link = '<a href="order.php?fitting=' . $rowA["fitting_id"] . '"><img src="images/active.png"></a>';
							} else {
								$link = '<img src="images/inactive.png">';
							}
							$today = date("F j, Y", strtotime("+" . $rowA["fitting_time_delay"] . " days"));
							echo '<div id="shopLinkWrapper">
									<div id="shopLink">
										<span id="bolden1">' . $rowA["hull_name"] . '</span><br>
										<img src="images/' . $rowA["hull_image"] . '">
										<div id="shopText">
											<span id="bolden2">Total Cost</span><br>' . number_format($rowA["fitting_cost"]) . ' ISK<br>
											<span id="bolden2">Deposit Required</span><br>' . number_format($rowA["fitting_deposit"]) . ' ISK<br>
											<span id="bolden2">Expected Delivery</span><br>' . $today . '<br>
											' . $link . '
										</div>
									</div>
								</div>';
						} 
					?>
				</div>
			</div>
			<div class="shopSectionWrapper">
				<div id="shopSectionHeader">
					Force Auxiliaries
				</div>
				<div id="shopSectionBody">
					<?php 
						while($rowA = $resultFax->fetch_assoc()) {
							if ($rowA["hull_active"] == 1) {
								$link = '<a href="order.php?fitting=' . $rowA["fitting_id"] . '"><img src="images/active.png"></a>';
							} else {
								$link = '<img src="images/inactive.png">';
							}
							$today = date("F j, Y", strtotime("+" . $rowA["fitting_time_delay"] . " days"));
							echo '<div id="shopLinkWrapper">
									<div id="shopLink">
										<span id="bolden1">' . $rowA["hull_name"] . '</span><br>
										<img src="images/' . $rowA["hull_image"] . '">
										<div id="shopText">
											<span id="bolden2">Total Cost</span><br>' . number_format($rowA["fitting_cost"]) . ' ISK<br>
											<span id="bolden2">Deposit Required</span><br>' . number_format($rowA["fitting_deposit"]) . ' ISK<br>
											<span id="bolden2">Expected Delivery</span><br>' . $today . '<br>
											' . $link . '
										</div>
									</div>
								</div>';
						} 
					?>
				</div>
			</div>
			<div class="shopSectionWrapper">
				<div id="shopSectionHeader">
					Dreadnoughts
				</div>
				<div id="shopSectionBody">
					<?php 
						while($rowA = $resultDread->fetch_assoc()) {
							if ($rowA["hull_active"] == 1) {
								$link = '<a href="order.php?fitting=' . $rowA["fitting_id"] . '"><img src="images/active.png"></a>';
							} else {
								$link = '<img src="images/inactive.png">';
							}
							$today = date("F j, Y", strtotime("+" . $rowA["fitting_time_delay"] . " days"));
							echo '<div id="shopLinkWrapper">
									<div id="shopLink">
										<span id="bolden1">' . $rowA["hull_name"] . '</span><br>
										<img src="images/' . $rowA["hull_image"] . '">
										<div id="shopText">
											<span id="bolden2">Total Cost</span><br>' . number_format($rowA["fitting_cost"]) . ' ISK<br>
											<span id="bolden2">Deposit Required</span><br>' . number_format($rowA["fitting_deposit"]) . ' ISK<br>
											<span id="bolden2">Expected Delivery</span><br>' . $today . '<br>
											' . $link . '
										</div>
									</div>
								</div>';
						} 
					?>
				</div>
			</div>
			<div class="shopSectionWrapper">
				<div id="shopSectionHeader">
					Freighters
				</div>
				<div id="shopSectionBody">
					<?php 
						while($rowA = $resultFreighter->fetch_assoc()) {
							if ($rowA["hull_active"] == 1) {
								$link = '<a href="order.php?fitting=' . $rowA["fitting_id"] . '"><img src="images/active.png"></a>';
							} else {
								$link = '<img src="images/inactive.png">';
							}
							$today = date("F j, Y", strtotime("+" . $rowA["fitting_time_delay"] . " days"));
							echo '<div id="shopLinkWrapper">
									<div id="shopLink">
										<span id="bolden1">' . $rowA["hull_name"] . '</span><br>
										<img src="images/' . $rowA["hull_image"] . '">
										<div id="shopText">
											<span id="bolden2">Total Cost</span><br>' . number_format($rowA["fitting_cost"]) . ' ISK<br>
											<span id="bolden2">Deposit Required</span><br>' . number_format($rowA["fitting_deposit"]) . ' ISK<br>
											<span id="bolden2">Expected Delivery</span><br>' . $today . '<br>
											' . $link . '
										</div>
									</div>
								</div>';
						} 
					?>
				</div>
			</div>
			<div class="shopSectionWrapper">
				<div id="shopSectionHeader">
					O.R.E. Hulls
				</div>
				<div id="shopSectionBody">
					<?php 
						while($rowA = $resultORE->fetch_assoc()) {
							if ($rowA["hull_active"] == 1) {
								$link = '<a href="order.php?fitting=' . $rowA["fitting_id"] . '"><img src="images/active.png"></a>';
							} else {
								$link = '<img src="images/inactive.png">';
							}
							$today = date("F j, Y", strtotime("+" . $rowA["fitting_time_delay"] . " days"));
							echo '<div id="shopLinkWrapper">
									<div id="shopLink">
										<span id="bolden1">' . $rowA["hull_name"] . '</span><br>
										<img src="images/' . $rowA["hull_image"] . '">
										<div id="shopText">
											<span id="bolden2">Total Cost</span><br>' . number_format($rowA["fitting_cost"]) . ' ISK<br>
											<span id="bolden2">Deposit Required</span><br>' . number_format($rowA["fitting_deposit"]) . ' ISK<br>
											<span id="bolden2">Expected Delivery</span><br>' . $today . '<br>
											' . $link . '
										</div>
									</div>
								</div>';
						} 
					?>
				</div>
			</div>
		</div>
	</body>
</html>