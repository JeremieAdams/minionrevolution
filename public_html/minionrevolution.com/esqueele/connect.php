<?php

/*
	Routine:	Connection Routine
	Author:		Jeremie M Adams
	Project:	Mini Cap Shop
	Date: 		11/22/2016
	Status:		Tested
	T B C :		Poss Class Conversion
*/

$servername = "localhost";
$username = "dickinso_iskino";
$password = "French31Star";
$dbname = "dickinso_mini";

// Create connection
$connection = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
} 

?>