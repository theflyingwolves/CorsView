<?php
require_once('config.php');
require_once('constants.php');
require_once('common_functions.php');

function userRegister($newUser){
    if($newUser != null){
         $mysqli = connect_database();

         $newQuery = sprintf("INSERT INTO ". USERS_TABLE ." (Facebook_ID,Facebook_Name,Gender,Access_Token,Created_Time) VALUES ('%s','%s','%s','%s','%s')",
            $mysqli->real_escape_string($newUser['facebookID']),
            $mysqli->real_escape_string($newUser['facebookName']),
            $mysqli->real_escape_string($newUser['gender']),
            $mysqli->real_escape_string($newUser['accessToken']),
            $mysqli->real_escape_string(timeGenerator()));
        if($mysqli->query($newQuery)){
            $returnMessage = "user registers successfully";
                userLogin($newUser);
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
         $mysqli = connect_database();
           $newQuery = sprintf("UPDATE " . USERS_TABLE . " SET Access_Token = '%s' WHERE Facebook_ID = '%s' LIMIT 1",
            $mysqli->real_escape_string($user['accessToken']),
            $mysqli->real_escape_string($user['facebookID']));
           if($mysqli->query($newQuery)){
                $newQuery = sprintf("SELECT User_ID FROM " . USERS_TABLE . " WHERE Facebook_ID = '%s'",
                    $mysqli->real_escape_string($user['facebookID']));
                $result = $mysqli->query($newQuery);
                $row = $result->fetch_array(MYSQLI_ASSOC);
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

function userLogout($userID){
    if($userID != null){
       $mysqli = connect_database();
       $newQuery = sprintf("UPDATE " . USERS_TABLE . " SET Access_Token = '' WHERE User_ID = '%s' LIMIT 1",
        $mysqli->real_escape_string($userID));
       if($mysqli->query($newQuery)){
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

function getUserInfo($facebookID){
    if($facebookID != null){
       $mysqli = connect_database();
        $newQuery  = sprintf("SELECT * FROM " . USERS_TABLE . " WHERE Facebook_ID = '%s'",
            $mysqli->real_escape_string($facebookID));
        $result = $mysqli->query($newQuery);
        if($row = $result->fetch_array(MYSQLI_ASSOC)){
            $userInfo = array(
                'userID' => $row['User_ID'],
                'FacebookID' => $row['Facebook_ID'],
                'Facebook_Name' => $row['Facebook_Name'],
                'accessToken' => $row['Access_Token'],
                'createdTime' => $row['Created_Time'],
                'lastLogInTime' => $row['Last_Log_In_Time']);
         $returnMessage = "user's profile is found";
        respondToClient(400,array('message' => $returnMessage,'userInfo' => $userInfo));         
        }
        else{
            $returnMessage = "user's not registered";
        respondToClient(400,array('message' => $returnMessage));
        }

    } else{
        $returnMessage = "user's facebook id is missing";
        respondToClient(400,array('message' => $returnMessage));       
    }
}

function getReviewsByUserId($facebookID){
    if($facebookID !=null){
         $mysqli = connect_database();
         $newQuery = sprintf("SELECT * FROM " . MODULE_REVIEWS_TABLE ." WHERE Creator_ID = '%s' AND Deleted = 0",
                $mysqli->real_escape_string($facebookID));
     //   $new_query = "SELECT * FROM " . MODULE_REVIEWS_TABLE ." WHERE Review_ID = 2";

        //$result = mysql_query($newQuery,$dbc);
        $result = $mysqli->query($newQuery);

        $reviewList = array();
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                $review = array(
                    'reviewID' => $row['Review_ID'],
                    'moduleCode' => $row['Module_Code'],
                    'moduleTitle' => $row['Module_Title'],
                    'creatorID' => $row['Creator_ID'],
                    'reviewContent' => $row['Review_Content'],
                    'createdTime' => $row['Created_Time'],
                    'modifiedTime' => $row['Modified_Time'],
                    'voteUp' => $row['Vote_Up'],
                    'voteDown' => $row['Vote_Down']);
                array_push($reviewList,$review);
            }
            if(sizeof($reviewList) == 0){
                    $returnMessage = "user's reviews are not found.";
                    respondToClient(404,array('message' => $returnMessage));
            }
            else{
            $returnMessage = "get user's reviews successfully.";
            respondToClient(200,array('message' => $returnMessage, 'reviewList' => $reviewList));
            }
            $mysqli->close();      
        }
        else{
            $returnMessage = "module code is missing";
            respondToClient(400,array('message' => $returnMessage));
        }
}
