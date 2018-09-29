<?php

	session_start();

	$page = "admin/index.php";

//	include_once ('../classes/class.pagelog.php');

	//$pageLog = new PageLog($page);

	require '../esqueele/connect.php';
	
	$message = "";
	$numRows = 0;
	
	if(isset($_POST['userName']) && $_POST['userName'] != ""){
		if(isset($_POST['password']) && $_POST['password'] != ""){
			$userName = $_POST['userName'];
			$password = $_POST['password'];
			$passwordHash = crypt($password, '_BbEeEeRr');
			
			$sqlLogin = "SELECT * FROM `users` WHERE `user_igName` = '$userName' AND `user_password` = '$passwordHash'";
			$resultLogin = $connection->query($sqlLogin);
			
			if ($resultLogin->num_rows == 1){
				$rowResult = $resultLogin->fetch_assoc();
				
				if ($rowResult["user_active"] == 1){
					$_SESSION["mini_account"] = $rowResult["userID"];
					
					header('Location: landing.php');
				} else {
					$message = "Username and Password MATCHED, account not active.  Talk to Higive.";
				}
			} else {
				$message = "Username and Password returned no match.";
			}
		} else {
			$message = "No password was entered.";
		}
	} else if(isset($_POST['userName'])) {
		$message = "No user name was entered.";
	}
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
		
		<form name="frmUser" method="post" action="index.php">
			<div class="message"><?php if($message!="") { echo $message; } ?></div>
				<table border="0" cellpadding="10" cellspacing="1" width="500" align="center">
					<tr class="tableheader">
						<td align="center" colspan="2">Minion Login</td>
					</tr>
					<tr class="tablerow">
						<td align="right">Username</td>
						<td><input type="text" name="userName"></td>
					</tr>
					<tr class="tablerow">
						<td align="right">Password</td>
						<td><input type="password" name="password"></td>
					</tr>
					<tr class="tableheader">
						<td align="center" colspan="2"><input type="submit" name="submit" value="Submit"></td>
					</tr>
					<tr class="tablerow">
						<a href="register.php">Click here to register</a>
					</tr>
				</table>
			</div>
		</form>
		
	</body>
</html>