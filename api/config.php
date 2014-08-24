<?php

function connect_database(){

	$db_hostname = "127.0.0.1";

	$db_username = "root";

	$db_password = "12345";
	// $db_password = "";
	$con = mysql_connect($db_hostname, $db_username, $db_password);

	if (!$con) {
			die('Failed to connect to host:' . $db_hostname . ' Error: ' . mysql_error());  
	}

	return $con;

}

function select_database($con){
	
	$db = mysql_select_db("CORSVIEW_DB", $con);  

	return $db;
}

?>

