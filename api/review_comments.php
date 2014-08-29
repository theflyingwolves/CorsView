<?php
require_once('constants.php');
require_once('common_functions.php');

function postReviewComment($commentDetails){
    if($commentDetails != null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

        if(!authentication($commentDetails['creatorID'],$commentDetails['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("INSERT INTO " . REVIEW_COMMENTS_TABLE . "(Review_ID,Creator_ID,
            Comment_Content,Created_Time) VALUES ('%s','%s','%s','%s')",
         mysql_real_escape_string($commentDetails['reviewID']),
         mysql_real_escape_string($commentDetails['creatorID']),
         mysql_real_escape_string($commentDetails['commentContent']),
         mysql_real_escape_string(timeGenerator()));
        if($result = mysql_query($newQuery,$dbc)){
            $Comment_ID = mysql_insert_id();
            $returnMessage = "comment inserted successfully";
            respondToClient(200,array('message' => $returnMessage,'commentID' => mysql_insert_id()));
        }
        else{
            $returnMessage = "comment inserted unccessfully";
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
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

        $newQuery  = sprintf("SELECT * FROM " . REVIEW_COMMENTS_TABLE . " WHERE Review_ID = '%s' AND deleted = 0",
            mysql_real_escape_string($reviewID) );
        $result = mysql_query($newQuery,$dbc);
        $commentsList = array();
        while($row = mysql_fetch_array($result)){
            $comment = array(
                'commentID' => $row['Comment_ID'],
                'reviewID' => $row['Review_ID'],
                'creatorID' => $row['Creator_ID'],
                'commentContent' => $row['Comment_Content'],
                'createdTime' => $row['Created_Time'],
                'modifiedTime' => $row['Modified_Time']);
            array_push($commentsList, $comment);
        }

        if(sizeof($commentsList)){
            $returnMessage = "get comments successfully.";
            respondToClient(200,array('message' => $returnMessage, 'comments_list' => $commentsList));

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
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

        $newQuery  = sprintf("SELECT * FROM " . REVIEW_COMMENTS_TABLE . " WHERE Comment_ID = '%s' AND deleted = 0",
            mysql_real_escape_string($commentID) );
        $result = mysql_query($newQuery,$dbc);
        if($row = mysql_fetch_array($result)){
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
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

        if(!authentication($commentContent['creatorID'],$commentContent['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("UPDATE ". REVIEW_COMMENTS_TABLE . " SET Comment_Content = '%s' WHERE Comment_ID = '%s'",
            mysql_real_escape_string($commentContent['commentContent']),
            mysql_real_escape_string($commentID));
         if($result = mysql_query($newQuery,$dbc)){
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
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

        if(!authentication($creatorID,$accessToken)){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("UPDATE " . REVIEW_COMMENTS_TABLE . " SET deleted = 1 WHERE Comment_ID = '%s'",
            mysql_real_escape_string($commentID));
        if(mysql_query($newQuery,$dbc)){
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
