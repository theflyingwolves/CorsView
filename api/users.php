<?php
require_once('constants.php');
require_once('common_functions.php');

function userRegister($newUser){
    if($newUser != null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

         $newQuery = sprintf("INSERT INTO ". USERS_TABLE ." (Facebook_ID,Access_Token,Created_Time) VALUES ('%s','%s','%s')",
            mysql_real_escape_string($newUser['facebookID']),
            mysql_real_escape_string($newUser['accessToken']),
            mysql_real_escape_string(timeGenerator()));
        if(mysql_query($newQuery,$dbc)){
            $returnMessage = "user registers successfully";
                userLogin($newUser);
            //respondToClient(200,array('message' => $returnMessage,'userID' => mysql_insert_id()));
        }
        else{
            $returnMessage = "user registers unsuccessfully";
            respondToClient(503,array('message' => $returnMessage));
        }  
    }
    else{
        $returnMessage = "user info is missing";
        respondToClient(400,array('message' => $returnMessage));
    }
}

function userLogin($user){
    if($user != null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

           $newQuery = sprintf("UPDATE " . USERS_TABLE . " SET Access_Token = '%s' WHERE Facebook_ID = '%s' LIMIT 1",
            mysql_real_escape_string($user['accessToken']),
            mysql_real_escape_string($user['facebookID']));
           if(mysql_query($newQuery,$dbc)){
                $newQuery = sprintf("SELECT User_ID FROM " . USERS_TABLE . " WHERE Facebook_ID = '%s'",
                    mysql_real_escape_string($user['facebookID']));
                $result = mysql_query($newQuery,$dbc);
                $row = mysql_fetch_array($result);
                $userID = $row['User_ID'];
                $returnMessage = "user logs in successfully";
                respondToClient(200,array('message' => $returnMessage,'userID' => $userID));
        }   else{
                $returnMessage = "user logs in unsuccessfully";
                respondToClient(503,array('message' => $returnMessage));
        }  
    } else{
        $returnMessage = "inputs are missing";
        respondToClient(400,array('message' => $returnMessage));
    }
}

function userLogout($user){
    if($user != null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);
       
       $newQuery = sprintf("UPDATE " . USERS_TABLE . " SET Access_Token = '' WHERE Facebook_ID = '%s' LIMIT 1",
        mysql_real_escape_string($user['facebookID']));
       if(mysql_query($newQuery,$dbc)){
            $returnMessage = "user logs out successfully";
            respondToClient(200,array('message' => $returnMessage));
       } else{
            $returnMessage = "user logs out unsuccessfully";
            respondToClient(503,array('message' => $returnMessage));
       }
    } else{
        $returnMessage = "inputs are missing";
        respondToClient(400,array('message' => $returnMessage));
    }
}
