<?php

$query = $_GET['q'];

$result = array(
	array('id'=>"856",'name'=>"CS2020"),
	array('id'=>"103",'name'=>"MA3238")
	);

echo json_encode($result);

?>