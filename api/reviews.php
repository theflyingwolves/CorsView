<?php
require_once('config.php');
require_once('constants.php');
require_once('common_functions.php');

function getReviews($moduleCode){
    if($moduleCode !=null){
         $mysqli = connect_database();
         $newQuery = sprintf("SELECT * FROM " . MODULE_REVIEWS_TABLE ." WHERE Module_Code = '%s' AND Deleted = 0",
                $mysqli->real_escape_string($moduleCode));
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
                    $returnMessage = "reviews are not found.";
                    respondToClient(404,array('message' => $returnMessage));
            }
            else{
            $returnMessage = "get reviews info successfully.";
            respondToClient(200,array('message' => $returnMessage, 'reviewList' => $reviewList));
            }
            $mysqli->close();      
        }
        else{
            $returnMessage = "module code is missing";
            respondToClient(400,array('message' => $returnMessage));
        }
}
function getSpecificReview($reviewID){
    if($reviewID !=null){
         $mysqli = connect_database();
         $newQuery = sprintf("SELECT * FROM " . MODULE_REVIEWS_TABLE ." WHERE Review_ID = '%s' AND Deleted = 0",
                $mysqli->real_escape_string($reviewID));

         $result=$mysqli->query($newQuery);
         if($row = $result->fetch_array(MYSQLI_ASSOC)){
            $review = array(
                    'reviewID' => $row['Review_ID'],
                    'moduleCode' => $row['Module_Code'],
                    'moduleTitle' => $row['Module_Title'],
                    'creatorID' => $row['Creator_ID'],
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
        $mysqli->close();
    } else{
        $returnMessage = "review id is missing";
        respondToClient(400,array('message' => $returnMessage));    }
}


function addReview($reviewDetails){
    if($reviewDetails !=null){
         $mysqli = connect_database();
        
        if(!authentication($reviewDetails['creatorID'],$reviewDetails['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("INSERT INTO ". MODULE_REVIEWS_TABLE ." (Module_ID,Module_Code,Module_Title,Creator_ID,Review_Content,Created_Time) VALUES ('%s','%s','%s','%s','%s','%s')",
                $mysqli->real_escape_string($reviewDetails['moduleID']),
                $mysqli->real_escape_string($reviewDetails['moduleCode']),
                $mysqli->real_escape_string($reviewDetails['moduleTitle']),
                $mysqli->real_escape_string($reviewDetails['creatorID']),
                $mysqli->real_escape_string($reviewDetails['reviewContent']),
                $mysqli->real_escape_string(timeGenerator()));
        $mysqli->query($newQuery);
        if($mysqli->affected_rows != 0){
            $returnMessage = "review added successfully";
            respondToClient(200,array('message' => $returnMessage,'reviewID' => $mysqli->insert_id));        
        }
        else{
             $returnMessage = "reviews are not added.";
            respondToClient(503,array('message' => $returnMessage));
        }
        $mysqli->close();
    } else{
            $returnMessage = "review detail is missing";
            respondToClient(400,array('message' => $returnMessage));
    }
}

function modifyReview($reviewID, $newReview){
    if($newReview !=null && $reviewID != null){
         $mysqli = connect_database();

       if(!authentication($newReview['creatorID'],$newReview['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("UPDATE ". MODULE_REVIEWS_TABLE ." SET Review_Content = '%s' WHERE Review_ID = '%s' AND Deleted = 0 AND Creator_ID = '%s'",
                $mysqli->real_escape_string($newReview['newContent']),
                $mysqli->real_escape_string($newReview['creatorID']),
                $mysqli->real_escape_string($reviewID));

        $mysqli->query($newQuery);
        if($mysqli->affected_rows != 0){
            $returnMessage = "review modified successfully";
            respondToClient(200,array('message' => $returnMessage));        
        }
        else{
            $returnMessage = "review is not modified.";
            respondToClient(503,array('message' => $returnMessage));
        }
        $mysqli->close();
    } else{
            $returnMessage = "review id or detail is missing";
            respondToClient(400,array('message' => $returnMessage));
    }
}

function deleteReview($reviewID,$creatorID,$accessToken){
    if($reviewID != null){
         $mysqli = connect_database();
         if(!authentication($creatorID,$accessToken)){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        } 

       $newQuery = sprintf("UPDATE ". MODULE_REVIEWS_TABLE ." SET Deleted = 1 WHERE Review_ID = '%s' AND Deleted = 0 AND Creator_ID = '%s'",
                $mysqli->real_escape_string($reviewID),
                $mysqli->real_escape_string($creatorID));
           $mysqli->query($newQuery);
           if($mysqli->affected_rows !=0){
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
         $mysqli = connect_database();
         if(!authentication($vote['userID'],$vote['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("SELECT * FROM " . REVIEW_VOTES_TABLE . " WHERE Review_ID = '%s' AND Deleted = 0 AND User_ID = '%s'",
            $mysqli->real_escape_string($vote['reviewID']),
            $mysqli->real_escape_string($vote['userID']));         
        $result = $mysqli->query($newQuery);
        if($row = $result->fetch_array(MYSQLI_ASSOC)){  //user voted in the past 
            $newQuery = sprintf("UPDATE ". REVIEW_VOTES_TABLE ." SET Vote = '%s' WHERE Review_ID = '%s' AND User_ID = '%s'",
                $mysqli->real_escape_string($vote['vote']),
                $mysqli->real_escape_string($vote['reviewID']),
                $mysqli->real_escape_string($vote['userID']));
            $mysqli->query($newQuery);
            if($mysqli->affected_rows != 0){
                $returnMessage = "user vote up successfully case 1";
                respondToClient(200,array('message' => $returnMessage));
            } else{
                $returnMessage = "user vote up unsuccessfully case 1";
                respondToClient(503,array('message' => $returnMessage));
            }
        } else{ //vote did not vote in the past
            $newQuery = sprintf("INSERT INTO " . REVIEW_VOTES_TABLE ."(Review_ID,User_ID,Vote,Created_Time) VALUES ('%s','%s','%s','%s')",
                $mysqli->real_escape_string($vote['reviewID']),
                $mysqli->real_escape_string($vote['userID']),
                $mysqli->real_escape_string($vote['vote']),
                $mysqli->real_escape_string(timeGenerator()));
            $mysqli->query($newQuery);
            if($mysqli->affected_rows != 0){
                    $returnMessage = "user vote up successfully case 2";
                    respondToClient(200,array('message' => $returnMessage));
                } else{
                    $returnMessage = "user vote up unsuccessfully case 2";
                    respondToClient(503,array('message' => $returnMessage));
                }
        }
    } else{
       $returnMessage = "user id and review id are missing";
        respondToClient(400,array('message' => $returnMessage));
    } 
}

