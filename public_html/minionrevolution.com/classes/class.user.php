<?php

/*
	Class:		
	Author:		Jeremie M Adams
	Project:	ISKino.com
	Date: 		1/7/2015
	Status:		Untested
	T B C :		
*/


class User {

	/*	Attributes	*/
	
	private $userId;
	private $userIGN;
	private $userEmail;
	private $userBalance;
	private $userActive;
	private $userPassword;
	private $userSessionKey;
	private $userSessionDate;
	
	/*	Methods		*/
	
		/*
	$passwordTest = "Bri143jer";
	$passwordHash = crypt($passwordTest, '_BbEeEeRr');
		*/
	
	////***	Constructor

	function __construct($InUser)
	{
		$this->userId = $InUser;
		if ($InUser == 0) {
			$this->userIGN = "Guest";
			$this->userBalance = 0;
			$this->userActive = 0;
			$this->userPassword = 'NONE';
			$this->userSessionKey = '';
			$this->userSessionDate = '';
		} else {
			require 'esqueele/connect.php';
			$stmt = $connection->prepare("SELECT * FROM users WHERE user_id = ?");
			$stmt->bind_param('i', $InUser);
			$stmt->execute();
			$stmt->bind_result($ID, $name, $email, $balance, $active, $password, $sessionKey, $sessionDate);
			$stmt->fetch();
			$this->SetUserName($name);
			$this->SetUserEmail($email);
			$this->SetUserBalance($balance);
			$this->SetUserActive($active);
			$this->SetUserPassword($password);
			$this->SetUserSessionKey($sessionKey);
			$this->SetUserSessionDate($sessionDate);
			$stmt->close();
		}
	}

	////***	Modifier Functions
	
	
	
	////***	Set Functions
	function SetUserName($name) {
		$this->userIGN = $name;
		$this->GetUserName();
	}
	
	function SetUserEmail($email) {
		$this->userEmail = $email;
		$this->GetUserEmail();
	}
	
	function SetUserBalance($balance) {
		$this->userBalance = $balance;
		$this->GetUserBalance();
	}
	
	function SetUserActive($active) {
		$this->userActive = $active;
		$this->GetUserActive();
	}
	
	function SetUserPassword($password) {
		$this->userPassword = $password;
		$this->GetUserPassword();
	}
	
	function SetUserSessionKey($sessionKey) {
		$this->userSessionKey = $sessionKey;
		$this->GetUserSessionKey();
	}
	
	function SetUserSessionDate($sessionDate) {
		$this->userSessionDate = $sessionDate;
		$this->GetUserSessionDate();
	}
	
	////***	Get Functions
	
	function GetUserName() {
		return $this->userIGN;
	}
	
	function GetUserEmail() {
		return $this->userEmail;
	}
	
	function GetUserBalance() {
		return $this->userBalance;
	}
	
	function GetUserActive() {
		return $this->userActive;
	}
	
	function GetUserPassword() {
		return $this->userPassword;
	}
	
	function GetUserSessionKey() {
		return $this->userSessionKey;
	}
	
	function GetUserSessionDate() {
		return $this->userSessionDate;
	}
}//Close Class function
?>