<?php

function respondToClient($response_code,$response_array){
    //http_response_code($response_code);
    sendHttpResponseCode($response_code);
    $responsedJSON = json_encode($response_array);
    echo $responsedJSON;
}

function authentication($facebookID,$accessToken){
    if($accessToken ==''){
        return FALSE;
    }
    else {
        require_once('config.php');
        $mysqli = connect_database();
        $newQuery = sprintf("SELECT Access_Token FROM ". USERS_TABLE ." u WHERE u.Facebook_ID='%s'",$mysqli->real_escape_string($facebookID));
        $result = $mysqli->query($newQuery);
        if($row = $result->fetch_array(MYSQLI_ASSOC)){
            if(strcmp($row['Access_Token'],$accessToken) == 0){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
        else{
            return FALSE;
        }
        mysql_close($dbc);
    }
}

function timeGenerator(){
    $UTC = new DateTimeZone("UTC");
$newTZ = new DateTimeZone("Asia/Singapore");
$date = new DateTime("now",$UTC );
$date->setTimezone( $newTZ );
return $date->format('Y-m-d H:i:s');
}

function sendHttpResponseCode($response_code){
    if (!function_exists('http_response_code'))
    {
        function http_response_code($response_code = NULL)
        {
            static $code = 200;
            if($response_code !== NULL)
            {
                header('X-PHP-Response-Code: '.$response_code, true, $response_code);
                if(!headers_sent())
                    $code = $newcode;
            }       
            return $code;
        }
    }
}
?>
