<?php
require_once('config.php');
require_once('constants.php');
require_once('common_functions.php');

function postReviewComment($commentDetails){
    if($commentDetails != null){
        $mysqli  = connect_database();

        if(!authentication($commentDetails['creatorID'],$commentDetails['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("INSERT INTO " . REVIEW_COMMENTS_TABLE . "(Review_ID,Creator_ID,
            Comment_Content,Created_Time) VALUES ('%s','%s','%s','%s')",
             $mysqli->real_escape_string($commentDetails['reviewID']),
             $mysqli->real_escape_string($commentDetails['creatorID']),
             $mysqli->real_escape_string($commentDetails['commentContent']),
             $mysqli->real_escape_string(timeGenerator()));
        $mysqli->query($newQuery);
        if($mysqli->affected_rows != 0){
            $Comment_ID = $mysqli->insert_id;
            $returnMessage = "comment inserted successfully";
            respondToClient(200,array('message' => $returnMessage,'commentID' => $Comment_ID));
        }
        else{
            $returnMessage = "comment inserted unsuccessfully";
            respondToClient(503,array('message' => $returnMessage));
        }  
    }
    else{
        $returnMessage = "inputs are missing";
        respondToClient(400,array('message' => $returnMessage));
    }
}

function getComments($reviewID){
    if($reviewID != null){
        $mysqli  = connect_database();

        $newQuery  = sprintf("SELECT * FROM " . REVIEW_COMMENTS_TABLE . " WHERE Review_ID = '%s' AND deleted = 0",
            $mysqli->real_escape_string($reviewID) );
        $result = $mysqli->query($newQuery);
        $commentList = array();
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
            $comment = array(
                'commentID' => $row['Comment_ID'],
                'reviewID' => $row['Review_ID'],
                'creatorID' => $row['Creator_ID'],
                'commentContent' => $row['Comment_Content'],
                'createdTime' => $row['Created_Time'],
                'modifiedTime' => $row['Modified_Time']);
            array_push($commentList, $comment);
        }

        if(sizeof($commentList)){
            $returnMessage = "get comments successfully.";
            respondToClient(200,array('message' => $returnMessage, 'commentList' => $commentList));

        } else{
            $returnMessage = "comments are not found.";
            respondToClient(404,array('message' => $returnMessage));
        }
    } else{
            $returnMessage = "module code is missing";
            respondToClient(400,array('message' => $returnMessage));
    }
}

function getSpecificReviewComment($commentID){
        if($commentID != null){
        $mysqli  = connect_database();
        $newQuery  = sprintf("SELECT * FROM " . REVIEW_COMMENTS_TABLE . " WHERE Comment_ID = '%s' AND deleted = 0",
            $mysqli->real_escape_string($commentID) );
        $result = $mysqli->query($newQuery);
        if($row = $result->fetch_array(MYSQLI_ASSOC)){
            $comment = array(
                'commentID' => $row['Comment_ID'],
                'reviewID' => $row['Review_ID'],
                'creatorID' => $row['Creator_ID'],
                'commentContent' => $row['Comment_Content'],
                'createdTime' => $row['Created_Time'],
                'modifiedTime' => $row['Modified_Time']);
            $returnMessage = "get comments successfully.";
            respondToClient(200,array('message' => $returnMessage, 'comment' => $comment));
        } else {
            $returnMessage = "comment is not found.";
            respondToClient(404,array('message' => $returnMessage));
        }


    } else{
            $returnMessage = "comment id is missing";
            respondToClient(400,array('message' => $returnMessage));
    }

}

function modifyReviewComment($commentID,$commentContent){
    if($commentID != null && $commentContent != null) {
         $mysqli  = connect_database();

        if(!authentication($commentContent['creatorID'],$commentContent['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("UPDATE ". REVIEW_COMMENTS_TABLE . " SET Comment_Content = '%s' WHERE Comment_ID = '%s' AND Deleted = 0",
            $mysqli->real_escape_string($commentContent['newComment']),
            $mysqli->real_escape_string($commentID));
        $mysqli->query($newQuery);
        if($mysqli->affected_rows != 0){
            $returnMessage = "comment updated successfully";
            respondToClient(200,array('message' => $returnMessage));
        }
        else{
            $returnMessage = "comment updated unccessfully";
            respondToClient(503,array('message' => $returnMessage));
        }  

    }
    else{
         $returnMessage = "inputs are missing";
         respondToClient(400,array('message' => $returnMessage));   
    }
}

function deleteReviewComment($commentID,$creatorID,$accessToken){
    if($commentID != null){
         $mysqli  = connect_database();

        if(!authentication($creatorID,$accessToken)){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("UPDATE " . REVIEW_COMMENTS_TABLE . " SET deleted = 1 WHERE Comment_ID = '%s' AND Creator_ID = '%s'",
            $mysqli->real_escape_string($commentID),
            $mysqli->real_escape_string($creatorID));
        $mysqli->query($newQuery);
        if($mysqli->affected_rows != 0){
            $returnMessage = "comment deleted successfully";
            respondToClient(200,array('message' => $returnMessage));
        } 
        else{
            $returnMessage = "comment deleted unsuccessfully";
            respondToClient(503,array('message' => $returnMessage));
        }     
    }
    else{
        $returnMessage = "comment id is missing";
        respondToClient(400,array('message' => $returnMessage));   
    }      
}

?>
