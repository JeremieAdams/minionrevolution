<?php

$page = "index.php";

include_once ('classes/class.pagelog.php');

header('Location: capshop.php');

//$pageLog = new PageLog($page);

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
		<link href="css/layout.css" rel='stylesheet' type='text/css' />
	</head>
	<body>
		<div class="banner">
			<div class="leftBanner">
			</div>
			<div class="capBanner">
				<a href="capshop.php" class="capButton"><img src="images/capButton.png" /></a>
			</div>
		</div>
	</body>
</html>