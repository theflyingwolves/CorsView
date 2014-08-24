<?php

//$requestURI = explode('/', $_SERVER['REQUEST_URI']);
// $requestURI = explode('/', $_SERVER['REQUEST_URI']);
$requestURI = explode('/', $_GET['url']);

//current api call starts with "localhost/corsview/api/..."
//54.164.2131/api/modules
$addr_offset = 1;
$command = array_values($requestURI);

//initialize the rest of $command to empty strings 
for ($i = sizeof($command); $i < $addr_offset + 10 ; $i++) {
    $command[$i]='';
}


switch($command[$addr_offset + 0]){
            case 'modules':
                        switch($command[$addr_offset+1]){
                                    case '':
                                                break;
                                    default:    //module code exists
                                                switch($command[$addr_offset + 2]){
                                                            case '':
                                                                        switch($_SERVER['REQUEST_METHOD']){
                                                                                    case 'GET':
                                                                                                require_once('modules.php');
                                                                                                getModuleInfo($command[$addr_offset + 1]);
                                                                                                break;
                                                                                    case 'POST':
                                                                                                break;
                                                                                    case 'PUT':
                                                                                                break;
                                                                                    case 'DELETE':
                                                                                                break;
                                                                                    default:
                                                                                                break;    
                                                                        }
                                                                        break;
                                                            case 'reviews':
                                                                        switch($command[$addr_offset+3]){
                                                                                    case '':
                                                                                            switch($_SERVER['REQUEST_METHOD']){
                                                                                                            case 'GET':
                                                                                                                        require_once('reviews.php');
                                                                                                                        getReviews($command[$addr_offset+1]);
                                                                                                                        break;
                                                                                                            case 'POST':
                                                                                                                        break;
                                                                                                            case 'PUT':
                                                                                                                        break;
                                                                                                            case 'DELETE':
                                                                                                                        break;
                                                                                                            default:
                                                                                                                        break;    
                                                                                                }

                                                                                                break;
                                                                                    default:    //review id exists
                                                                                                switch($_SERVER['REQUEST_METHOD']){
                                                                                                            case 'GET':
                                                                                                                        break;
                                                                                                            case 'POST':
                                                                                                                        break;
                                                                                                            case 'PUT':
                                                                                                                        break;
                                                                                                            case 'DELETE':
                                                                                                                        break;
                                                                                                            default:
                                                                                                                        break;    
                                                                                                }
                                                                                                break;
                                                                        }
                                                                        break;
                                                            default: 
                                                                         break;
                                                }
                                                break;
                        }
                        break; 
            default:
                        break;
}
?>