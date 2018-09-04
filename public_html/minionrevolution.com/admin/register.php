<?php
	
	$page = "admin/register.php";

	include_once ('../classes/class.pagelog.php');

	//$pageLog = new PageLog($page);

	require '../esqueele/connect.php';
	$message = "";
	
	include_once ('../classes/class.register.php');
	
	if(isset($_POST['userName']) && $_POST['userName'] != ""){
		if (isset($_POST['email']) && $_POST['email'] != "") {
			if (isset($_POST['password']) && $_POST['password'] != ""){
				if (isset($_POST['robot']) && $_POST['robot'] == "Higive"){
					$userName = $_POST['userName'];
					$email = $_POST['email'];
					$password = $_POST['password'];
					$passConfirm = $_POST['confirmPassword'];

					if ($password == $passConfirm){
						$message = "Passwords matched.  WTG. <a href='index.php'>Click here to login</a>";
						
						$passwordHash = crypt($password, '_BbEeEeRr');
						
						$sqlInsert = $connection->prepare("INSERT INTO  `dickinso_mini`.`users` (`userID` ,`user_igName` , `user_email` , `user_password` , `user_active` , `user_capshop`)
						VALUES (NULL ,  ?, ?,  ?,  0, 0)");
						$sqlInsert->bind_param("sss", $userName, $email, $passwordHash);
						$sqlInsert->execute();
						
						//$register = new Register($userName, $email, $password);
					} else {
						$message = "Passwords did not match.  Try again";
					}
				} else {
					$message = "You're a ROBOT  Try again";
				}
			} else {
				$message = "Passwords was not entered.  Try again";
			}
		} else {
			$message = "Email was not entered.  Try again";
		}
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<link rel="stylesheet" type="text/css" href="css/layout.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="icon" type="image/png" href="../images/favicon.png" />
	<head>
	</head>
	<body>
		<form name="frmUser" method="post" action="register.php">
			<div class="message"><?php if($message!="") { echo $message; } ?></div>
				<table border="0" cellpadding="10" cellspacing="1" width="500" align="center">
					<tr class="tableheader">
						<td align="center" colspan="2">Register Please!!!</td>
					</tr>
					<tr class="tablerow">
						<td align="right">Username</td>
						<td><input type="text" name="userName"></td>
					</tr>
					<tr class="tablerow">
						<td align="right">Email</td>
						<td><input type="text" name="email"></td>
					</tr>
					<tr class="tablerow">
						<td align="right">Password</td>
						<td><input type="password" name="password"></td>
					</tr>
					<tr class="tablerow">
						<td align="right">Confirm Password</td>
						<td><input type="password" name="confirmPassword"></td>
					</tr>
					<tr class="tablerow">
						<td align="right">Robot Avoidance - Type in Higive</td>
						<td><input type="text" name="robot"></td>
					</tr>
					<tr class="tableheader">
						<td align="center" colspan="2"><input type="submit" name="submit" value="Register"></td>
					</tr>
				</table>
			</div>
		</form>
	</body>
</html>