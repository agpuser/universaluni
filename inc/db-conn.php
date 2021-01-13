<?php
/*****************************************
 * SIT203 Web Programming
 * Assignment 2
 * Aaron Pethybridge
 * Student#: 217561644
 * Holder for Database login & connection  
 *****************************************/
/* Set MySQL user login and password info */
	// DB login details
	$user = "metaphor_uni_user";
	$pass = "K42Z9q6_";
	$dbname = "metaphor_uni";
	
	// Database connection object 
	//$db = oci_connect($dbuser, $dbpass, $dbname);
	$db = new mysqli("localhost", $user, $pass, $dbname);

	if (!$db)  {
		echo('An error occurred connecting to the database. Please try again in a short while.');
		exit; 
	}
  
	function getDatabaseConnection()
	{
		return $db;
	}
 ?>