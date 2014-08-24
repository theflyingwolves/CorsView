<?php
function respondToClient($response_code,$response_array){
    //http_response_code($response_code);
    sendHttpResponseCode($response_code);
    $responsedJSON = json_encode($response_array);
    echo $responsedJSON;
}

function generateAccessToken($user_name){
    $currentDateTime = date('Y/m/d,H:i:s');
    return sha1($user_name.$currentDateTime);
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
