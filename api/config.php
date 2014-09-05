<?php

function connect_database(){

	$db_hostname = "127.0.0.1";

	$db_username = "root";

	$db_password = "";
	//$db_password = "";
	$db_database = "CORSVIEW_DB";
	$con = new mysqli($db_hostname, $db_username, $db_password,$db_database);

	if (!$con) {
			die('Failed to connect to host:' . $db_hostname . ' Error: ' . mysqli_error());  
	}
	return $con;
}
/*
function select_database($con){
	
	$db = mysql_select_db("CORSVIEW_DB", $con);  

	return $db;
}
*/
?>

