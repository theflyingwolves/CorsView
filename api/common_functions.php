<?php
function respondToClient($response_code,$response_array){
    //http_response_code($response_code);
    sendHttpResponseCode($response_code);
    $responsedJSON = json_encode($response_array);
    echo $responsedJSON;
}

function authentication($userID,$accessToken){
    if($accessToken ==''){
        return FALSE;
    }
    else {
        require_once('database_setup.php');
        $dbc = connect_database();
        $newQuery = sprintf("SELECT Access_Token FROM ". USERS_TABLE ." u WHERE u.User_ID='%s'",mysql_real_escape_string($userID));
        $result = mysql_query($newQuery,$dbc);
        if($row = mysql_fetch_array($result)){
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
