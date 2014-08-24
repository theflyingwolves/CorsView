<?php

function respondToClient($response_code,$response_array){
	// http_response_code($response_code);
	$responsedJSON = json_encode($response_array);
	echo $responsedJSON;
}

?>
