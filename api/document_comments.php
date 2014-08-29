<?php
require_once('constants.php');
require_once('common_functions.php');

function postDocumentComment($commentDetails){
    if($commentDetails != null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

        if(!authentication($commentDetails['creatorID'],$commentDetails['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("INSERT INTO " . DOCUMENT_COMMENTS_TABLE . "(Document_ID,Creator_ID,
            Comment_Content,Created_Time) VALUES ('%s','%s','%s','%s')",
         mysql_real_escape_string($commentDetails['documentID']),
         mysql_real_escape_string($commentDetails['creatorID']),
         mysql_real_escape_string($commentDetails['commentContent']),
         mysql_real_escape_string(timeGenerator()));
        if($result=mysql_query($newQuery,$dbc)){
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

function getComments($documentID){
    if($documentID != null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

        $newQuery  = sprintf("SELECT * FROM " . DOCUMENT_COMMENTS_TABLE . " WHERE Document_ID = '%s' AND deleted = 0",
            mysql_real_escape_string($documentID) );
        $result = mysql_query($newQuery,$dbc);
        $commentList = array();
        while($row = mysql_fetch_array($result)){
            $comment = array(
                'commentID' => $row['Comment_ID'],
                'documentID' => $row['Document_ID'],
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

function getSpecificDocumentComment($commentID){
        if($commentID != null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

        $newQuery  = sprintf("SELECT * FROM " . DOCUMENT_COMMENTS_TABLE . " WHERE Comment_ID = '%s' AND deleted = 0",
            mysql_real_escape_string($commentID) );
        $result = mysql_query($newQuery,$dbc);
        if($row = mysql_fetch_array($result)){
            $comment = array(
                'commentID' => $row['Comment_ID'],
                'documentID' => $row['Document_ID'],
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

        $newQuery = sprintf("UPDATE ". DOCUMENT_COMMENTS_TABLE . " SET Comment_Content = '%s' WHERE Comment_ID = '%s'",
            mysql_real_escape_string($commentContent['newComment']),
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

function deleteDocumentComment($commentID,$creatorID,$accessToken){
    if($commentID != null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

        if(!authentication($creatorID,$accessToken)){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("UPDATE " . DOCUMENT_COMMENTS_TABLE . " SET deleted = 1 WHERE Comment_ID = '%s'",
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
