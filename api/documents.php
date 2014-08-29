<?php
require_once('constants.php');
require_once('common_functions.php');

function getDocuments($moduleCode){
    if($moduleCode !=null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

         $newQuery = sprintf("SELECT * FROM " . DOCUMENTS_TABLE ." WHERE Module_Code = '%s' AND Deleted = 0",
                mysql_real_escape_string($moduleCode));

        $result = mysql_query($newQuery,$dbc);
        $documentList = array();
            while($row = mysql_fetch_array($result)){
                $document = array(
                    'documentID' => $row['Document_ID'],
                    'moduleCode' => $row['Module_Code'],
                    'moduleTitle' => $row['Module_Title'],
                    'creatorID' => $row['Creator_ID'],
                    'documentTitle' => $row['Document_Title'],
                    'documentLink' => $row['Document_Link'],
                    'createdTime' => $row['Created_Time'],
                    'modifiedTime' => $row['Modified_Time'],
                    'voteUp' => $row['Vote_Up'],
                    'voteDown' => $row['Vote_Down']);
                array_push($documentList,$document);
            }
            if(sizeof($documentList) == 0){
                    $returnMessage = "documents are not found.";
                    respondToClient(404,array('message' => $returnMessage));
            }
            else{
            $returnMessage = "get documents info successfully.";
            respondToClient(200,array('message' => $returnMessage, 'documentList' => $documentList));
            }
            mysql_close($dbc);      
        }
        else{
            $returnMessage = "module code is missing";
            respondToClient(400,array('message' => $returnMessage));
        }
}
function getSpecificDocument($documentID){
    if($documentID !=null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

         $newQuery = sprintf("SELECT * FROM " . DOCUMENTS_TABLE ." WHERE Document_ID = '%s' AND Deleted = 0",
                mysql_real_escape_string($documentID));

         $result=mysql_query($newQuery,$dbc);
         if($row = mysql_fetch_array($result)){
              $document = array(
                    'documentID' => $row['Document_ID'],
                    'moduleCode' => $row['Module_Code'],
                    'moduleTitle' => $row['Module_Title'],
                    'creatorID' => $row['Creator_ID'],
                    'documentTitle' => $row['Document_Title'],
                    'documentLink' => $row['Document_Link'],
                    'createdTime' => $row['Created_Time'],
                    'modifiedTime' => $row['Modified_Time'],
                    'voteUp' => $row['Vote_Up'],
                    'voteDown' => $row['Vote_Down']);    
            $returnMessage = "document found";
            respondToClient(200,array('message' => $returnMessage,'document' => $document));  
        }
        else{
             $returnMessage = "document is not found.";
            respondToClient(503,array('message' => $returnMessage));
        }
        mysql_close($dbc);
    } else{
        $returnMessage = "document id is missing";
        respondToClient(400,array('message' => $returnMessage));    }
}


function addDocument($documentDetails){
    if($documentDetails !=null){

        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);
        
        if(!authentication($documentDetails['creatorID'],$documentDetails['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("INSERT INTO ". DOCUMENTS_TABLE ." (Module_ID,Module_Code,Module_Title,Creator_ID,Document_Title,Document_Link,Created_Time) VALUES ('%s','%s','%s','%s','%s','%s','%s')",
                mysql_real_escape_string($documentDetails['moduleID']),
                mysql_real_escape_string($documentDetails['moduleCode']),
                mysql_real_escape_string($documentDetails['moduleTitle']),
                mysql_real_escape_string($documentDetails['creatorID']),
                mysql_real_escape_string($documentDetails['documentTitle']),
                mysql_real_escape_string($documentDetails['documentLink']),
                mysql_real_escape_string(timeGenerator()));
        if(mysql_query($newQuery,$dbc)){
            $returnMessage = "document added successfully";
            respondToClient(200,array('message' => $returnMessage,'reviewID' => mysql_insert_id()));        
        } else{
             $returnMessage = "document is not added.";
            respondToClient(503,array('message' => $returnMessage));
        }
        mysql_close($dbc);
    } else{
            $returnMessage = "document detail is missing";
            respondToClient(400,array('message' => $returnMessage));
    }
}

function modifyDocument($documentID, $newDocument){
    if($newDocument !=null && $documentID != null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

       if(!authentication($newDocument['creatorID'],$newDocument['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("UPDATE ". DOCUMENTS_TABLE ." SET Document_Title = '%s', Document_Link = '%s' WHERE Document_ID = '%s' ",
                mysql_real_escape_string($newDocument['documentTitle']),
                mysql_real_escape_string($newDocument['documentLink']),
                mysql_real_escape_string($documentID));

        if(mysql_query($newQuery,$dbc)){
            $returnMessage = "document modified successfully";
            respondToClient(200,array('message' => $returnMessage));        
        }
        else{
            $returnMessage = "document is not modified.";
            respondToClient(503,array('message' => $returnMessage));
        }
        mysql_close($dbc);
    } else{
            $returnMessage = "document id or detail is missing";
            respondToClient(400,array('message' => $returnMessage));
    }
}


function deleteDocument($documentID,$creatorID,$accessToken){
    if($documentID != null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);
         if(!authentication($creatorID,$accessToken)){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        } 

       $newQuery = sprintf("UPDATE ". DOCUMENTS_TABLE ." SET Deleted = 1 WHERE Document_ID = '%s' ",
                mysql_real_escape_string($documentID));
           if(mysql_query($newQuery,$dbc)){
                $returnMessage = "document deleted successfully";
                respondToClient(200,array('message' => $returnMessage));     
           } else{
            $returnMessage = "document is not deleted.";
            respondToClient(503,array('message' => $returnMessage));
           }
    } else{
        $returnMessage = "document id is missing";
        respondToClient(400,array('message' => $returnMessage));
    }
}

function documentVote($vote){
    if($vote != null){
require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);
         if(!authentication($vote['userID'],$vote['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("SELECT * FROM " . DOCUMENT_VOTES_TABLE . " WHERE Document_ID = '%s' AND User_ID = '%s'",
            mysql_real_escape_string($vote['documentID']),
            mysql_real_escape_string($vote['userID']));         
        $result = mysql_query($newQuery,$dbc);
        if($row = mysql_fetch_array($result)){  //user voted in the past 
            $newQuery = sprintf("UPDATE ". DOCUMENT_VOTES_TABLE ." SET Vote = '%s' WHERE Document_ID = '%s' AND User_ID = '%s'",
                mysql_real_escape_string($vote['vote']),
                mysql_real_escape_string($vote['documentID']),
            mysql_real_escape_string($vote['userID']));
            if($result = mysql_query($newQuery,$dbc)){
                $returnMessage = "user vote up successfully case 1";
                respondToClient(200,array('message' => $returnMessage));
            } else{
                $returnMessage = "user vote up unsuccessfully case 1";
                respondToClient(503,array('message' => $returnMessage));
            }
        } else{ //vote did not vote in the past
            $newQuery = sprintf("INSERT INTO " . DOCUMENT_VOTES_TABLE ."(Document_ID,User_ID,Vote,Created_Time) VALUES ('%s','%s','%s','%s')",
                mysql_real_escape_string($vote['documentID']),
                mysql_real_escape_string($vote['userID']),
                mysql_real_escape_string($vote['vote']),
                mysql_real_escape_string(timeGenerator()));
                if($result = mysql_query($newQuery,$dbc)){
                    $returnMessage = "user vote up successfully case 2";
                    respondToClient(200,array('message' => $returnMessage));
                } else{
                    $returnMessage = "user vote up unsuccessfully case 2";
                    respondToClient(503,array('message' => $returnMessage));
                }
        }
    } else{
       $returnMessage = "user id and document id are missing";
        respondToClient(400,array('message' => $returnMessage));
    } 
}

function reviewVoteDown(){

}

