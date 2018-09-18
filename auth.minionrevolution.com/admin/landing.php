<?php

	session_start();

	$page = "admin/landing.php";

	//include_once ('../classes/class.pagelog.php');

	//$pageLog = new PageLog($page);

	require '../esqueele/connect.php';
	
	$sqlStatement = "SELECT `ESI_CharPublic`.`ESI_CharPublic_Name`, `ESI_CharPublic`.`ESI_CharPublic_ID` FROM `auth_Token` LEFT OUTER JOIN ESI_CharPublic ON `auth_Token_CharacterID`=`ESI_CharPublic_ID` GROUP BY `auth_Token_CharacterID`";
	$result = $connection->query($sqlStatement);
	
	$message = "";
	
	$connection->close();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<link rel="stylesheet" type="text/css" href="css/layout.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="icon" type="image/png" href="../images/favicon.png" />
	<head>
	</head>
	<body>
		<?php 
			while ($row = $result->fetch_assoc()){
				echo $row["ESI_CharPublic_Name"] . " <a href='report.php?charID=" . $row["ESI_CharPublic_ID"] . "'>See Report</a><br />";
			}
		?>
	</body>
</html>