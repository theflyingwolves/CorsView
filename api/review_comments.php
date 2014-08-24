<?php
require_once('constants.php');
require_once('common_functions.php');

function getComments($review_id){
    if($review_id != null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

        $new_query  = sprintf("SELECT * FROM " . REVIEW_COMMENTS_TABLE . " WHERE Review_ID = '%s' AND deleted = 0",
            mysql_real_escape_string($review_id) );
        $result = mysql_query($new_query,$dbc);
        $comments_list = array();
        while($row = mysql_fetch_array($result)){
            $comment = array(
                'Comment_ID' => $row['Comment_ID'],
                'Review_ID' => $row['Review_ID'],
                'moduleCode' => $row['Module_Code'],
                'moduleTitle' => $row['Module_Title'],
                'Creator_ID' => $row['Creator_ID'],
                'commentContent' => $row['Comment_Content'],
                'createdTime' => $row['Created_Time'],
                'modifiedTime' => $row['Modified_Time'],
                'like' => $row['Like'],
                'dislike' => $['Dislike']
                );
            array_push($comments_list, $comment);
        }

        if(sizeof()$comments_list){
            $returnMessage = "comments are not found.";
            respondToClient(404,array('message' => $returnMessage));
        }
        else{
            $returnMessage = "get comments successfully.";
            respondToClient(200,array('message' => $returnMessage, 'comments_list' => $comments_list));
        }
    }
    else{
            $returnMessage = "module code is missing";
            respondToClient(400,array('message' => $returnMessage));
    }
}

function postReviewComment($Review_ID,$Module_Code,$Module_Title,$Creator_ID,$Comment_Content){
    if($Review_ID != null && $moduleCode != null && $moduleTitle != null && $Creator_ID != null && $commentContent != null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

        $new_query = sprintf("INSERT INTO " . REVIEW_COMMENTS_TABLE . "(Review_ID,Module_Code,Module_Title,Creator_ID,
            Comment_Content,Created_Time,Modified_Time) VALUES ('%s','%s','%s','%s','%s','%s','%s')",
         mysql_real_escape_string($Review_ID),
         mysql_real_escape_string($Module_Code),
         mysql_real_escape_string($Module_Title),
         mysql_real_escape_string($Creator_ID),
         mysql_real_escape_string($Comment_Content),
         mysql_real_escape_string(date('Y-m-d H:i:s')),
         mysql_real_escape_string(date('Y-m-d H:i:s')));
        if($result = mysql_query($new_query,$dbc)){
            $Comment_ID = mysql_insert_id();
            $returnMessage = "comment inserted successfully";
            respondToClient(200,array('message' => $returnMessage,'Comment_ID' => $Comment_ID));
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

function modifyReviewComment($Comment_ID,$Comment_Content){
    if（$Comment_ID != null && $Comment_Content != null）{
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

        $new_query = sprintf("UPDATE ". REVIEW_COMMENTS_TABLE . " SET Comment_Content = '%s' WHERE $Comment_ID = '%s'",
            mysql_real_escape_string($Comment_Content),
            mysql_real_escape_string($Comment_ID));
         if($result = mysql_query($new_query,$dbc)){
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

function deleteReviewComment($Comment_ID){
    if($Comment_ID != null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

        $new_query = sprintf("UPDATE " . REVIEW_COMMENTS_TABLE . " SET deleted = 1 WHERE Comment_ID = '%s'",
            mysql_real_escape_string($Comment_ID);
        if(mysql_query($new_query,$dbc)){
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

function likeComment(){

}

function dislikeComment(){
    
}
?>
