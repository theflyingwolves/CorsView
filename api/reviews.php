<?php
require_once('constants.php');
require_once('common_functions.php');

function getReviews($moduleCode){
    if($moduleCode !=null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

         $newQuery = sprintf("SELECT * FROM " . MODULE_REVIEWS_TABLE ." WHERE Module_Code = '%s' AND Deleted = 0",
                mysql_real_escape_string($moduleCode));
     //   $new_query = "SELECT * FROM " . MODULE_REVIEWS_TABLE ." WHERE Review_ID = 2";

        $result = mysql_query($newQuery,$dbc);
        $reviewList = array();
            while($row = mysql_fetch_array($result)){
                $review = array(
                    'reviewID' => $row['Review_ID'],
                    'moduleCode' => $row['Module_Code'],
                    'moduleTitle' => $row['Module_Title'],
                    'moduleReview' => $row['Module_Title'],
                    'createdTime' => $row['Created_Time'],
                    'modifiedTime' => $row['Modified_Time'],
                    'voteUp' => $row['Vote_Up'],
                    'voteDown' => $row['Vote_Down']);
                array_push($reviewList,$review);
            }
            if(sizeof($reviewList) == 0){
                    $returnMessage = "reviews are not found.";
                    respondToClient(404,array('message' => $returnMessage));
            }
            else{
            $returnMessage = "get module info successfully.";
            respondToClient(200,array('message' => $returnMessage, 'review_list' => $reviewList));
            }

            mysql_close($dbc);      
        }
        else{
            $returnMessage = "module code is missing";
            respondToClient(400,array('message' => $returnMessage));
        }
}
function getSpecificReview($reviewID){
    if($reviewID !=null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

         $newQuery = sprintf("SELECT * FROM " . MODULE_REVIEWS_TABLE ." WHERE Review_ID = '%s' AND Deleted = 0",
                mysql_real_escape_string($reviewID));

         $result=mysql_query($newQuery,$dbc);
         if($row = mysql_fetch_array($result)){
            $review = array(
                    'reviewID' => $row['Review_ID'],
                    'moduleCode' => $row['Module_Code'],
                    'moduleTitle' => $row['Module_Title'],
                    'moduleReview' => $row['Review_Content'],
                    'createdTime' => $row['Created_Time'],
                    'modifiedTime' => $row['Modified_Time'],
                    'voteUp' => $row['Vote_Up'],
                    'voteDown' => $row['Vote_Down']);      
            $returnMessage = "review found";
            respondToClient(200,array('message' => $returnMessage,'review' => $review));  
        }
        else{
             $returnMessage = "review is not found.";
            respondToClient(503,array('message' => $returnMessage));
        }
        mysql_close($dbc);
    } else{
        $returnMessage = "review id is missing";
        respondToClient(400,array('message' => $returnMessage));    }
}


function addReview($reviewDetails){
    if($reviewDetails !=null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);
        
        if(!authentication($reviewDetails['creatorID'],$reviewDetails['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("INSERT INTO ". MODULE_REVIEWS_TABLE ." (Module_ID,Module_Code,Module_Title,Creator_ID,Review_Content,Created_Time) VALUES ('%s','%s','%s','%s','%s','%s')",
                mysql_real_escape_string($reviewDetails['moduleID']),
                mysql_real_escape_string($reviewDetails['moduleCode']),
                mysql_real_escape_string($reviewDetails['moduleTitle']),
                mysql_real_escape_string($reviewDetails['creatorID']),
                mysql_real_escape_string($reviewDetails['reviewContent']),
                mysql_real_escape_string(timeGenerator()));
        if(mysql_query($newQuery,$dbc)){
            $returnMessage = "review added successfully";
            respondToClient(200,array('message' => $returnMessage,'reviewID' => mysql_insert_id()));        
        }
        else{
             $returnMessage = "reviews are not added.";
            respondToClient(503,array('message' => $returnMessage));
        }
        mysql_close($dbc);
    } else{
            $returnMessage = "review detail is missing";
            respondToClient(400,array('message' => $returnMessage));
    }
}

function modifyReview($reviewID, $newReview){
    if($newReview !=null && $reviewID != null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

       if(!authentication($newReview['creatorID'],$newReview['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $new_query = sprintf("UPDATE ". MODULE_REVIEWS_TABLE ." SET Review_Content = '%s' WHERE Review_ID = '%s' ",
                mysql_real_escape_string($newReview['newContent']),
                mysql_real_escape_string($reviewID));

        if(mysql_query($new_query,$dbc)){
            $returnMessage = "review modified successfully";
            respondToClient(200,array('message' => $returnMessage));        
        }
        else{
            $returnMessage = "review is not modified.";
            respondToClient(503,array('message' => $returnMessage));
        }
        mysql_close($dbc);
    } else{
            $returnMessage = "review id or detail is missing";
            respondToClient(400,array('message' => $returnMessage));
    }
}

function deleteReview($reviewID,$creatorID,$accessToken){
    if($reviewID != null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);
         if(!authentication($creatorID,$accessToken)){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        } 

       $new_query = sprintf("UPDATE ". MODULE_REVIEWS_TABLE ." SET Deleted = 1 WHERE Review_ID = '%s' ",
                mysql_real_escape_string($reviewID));
           if(mysql_query($new_query,$dbc)){
                $returnMessage = "review deleted successfully";
                respondToClient(200,array('message' => $returnMessage));     
           } else{
            $returnMessage = "review is not deleted.";
            respondToClient(503,array('message' => $returnMessage));
           }
    } else{
        $returnMessage = "review id is missing";
        respondToClient(400,array('message' => $returnMessage));
    }
}

function reviewVote($vote){
    if($vote != null){
require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);
         if(!authentication($vote['userID'],$vote['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("SELECT * FROM " . REVIEW_VOTES_TABLE . " WHERE Review_ID = '%s' AND User_ID = '%s'",
            mysql_real_escape_string($vote['reviewID']),
            mysql_real_escape_string($vote['userID']));         
        $result = mysql_query($newQuery,$dbc);
        if($row = mysql_fetch_array($result)){  //user voted in the past 
            $newQuery = sprintf("UPDATE ". REVIEW_VOTES_TABLE ." SET Vote = '%s' WHERE Review_ID = '%s' AND User_ID = '%s'",
                mysql_real_escape_string($vote['vote']),
                mysql_real_escape_string($vote['reviewID']),
            mysql_real_escape_string($vote['userID']));
            if($result = mysql_query($newQuery,$dbc)){
                $returnMessage = "user vote up successfully";
                respondToClient(200,array('message' => $returnMessage));
            } else{
                $returnMessage = "user vote up unsuccessfully";
                respondToClient(503,array('message' => $returnMessage));
            }
        } else{ //vote did not vote in the past
            $newQuery = sprintf("INSERT INTO " . REVIEW_VOTES_TABLE ."(Review_ID,User_ID,Vote,Created_Time) VALUES ('%s','%s','%s','%s')",
                mysql_real_escape_string($vote['reviewID']),
                mysql_real_escape_string($vote['userID']),
                1,
                mysql_real_escape_string(timeGenerator()));
                if($result = mysql_query($newQuery,$dbc)){
                    $returnMessage = "user vote up successfully";
                    respondToClient(200,array('message' => $returnMessage));
                } else{
                    $returnMessage = "user vote up unsuccessfully";
                    respondToClient(503,array('message' => $returnMessage));
                }
        }
    } else{
       $returnMessage = "user id and review id are missing";
        respondToClient(400,array('message' => $returnMessage));
    } 
}

function reviewVoteDown(){

}
