<?php
require_once('config.php');
require_once('constants.php');
require_once('common_functions.php');

function getDocuments($moduleCode){
    if($moduleCode !=null){
         $mysqli = connect_database();

         $newQuery = sprintf("SELECT * FROM " . DOCUMENTS_TABLE ." WHERE Module_Code = '%s' AND Deleted = 0",
                $mysqli->real_escape_string($moduleCode));

        $result = $mysqli->query($newQuery);
        $documentList = array();
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
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
            $mysqli->close();      
        }
        else{
            $returnMessage = "module code is missing";
            respondToClient(400,array('message' => $returnMessage));
        }
}
function getSpecificDocument($documentID){
    if($documentID !=null){
         $mysqli = connect_database();

         $newQuery = sprintf("SELECT * FROM " . DOCUMENTS_TABLE ." WHERE Document_ID = '%s' AND Deleted = 0",
                $mysqli->real_escape_string($documentID));

         $result=$mysqli->query($newQuery);
         if($row = $result->fetch_array(MYSQLI_ASSOC)){
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
        $mysqli->close();
    } else{
        $returnMessage = "document id is missing";
        respondToClient(400,array('message' => $returnMessage));    }
}


function addDocument($documentDetails){
    if($documentDetails !=null){
         $mysqli = connect_database();
        
        if(!authentication($documentDetails['creatorID'],$documentDetails['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("INSERT INTO ". DOCUMENTS_TABLE ." (Module_ID,Module_Code,Module_Title,Creator_ID,Document_Title,Document_Link,Created_Time) VALUES ('%s','%s','%s','%s','%s','%s','%s')",
                $mysqli->real_escape_string($documentDetails['moduleID']),
                $mysqli->real_escape_string($documentDetails['moduleCode']),
                $mysqli->real_escape_string($documentDetails['moduleTitle']),
                $mysqli->real_escape_string($documentDetails['creatorID']),
                $mysqli->real_escape_string($documentDetails['documentTitle']),
                $mysqli->real_escape_string($documentDetails['documentLink']),
                $mysqli->real_escape_string(timeGenerator()));
        $mysqli->query($newQuery);
        if($mysqli->affected_rows != 0){
            $returnMessage = "document added successfully";
            respondToClient(200,array('message' => $returnMessage,'reviewID' => $mysqli->insert_id));        
        } else{
             $returnMessage = "document is not added.";
            respondToClient(503,array('message' => $returnMessage));
        }
        $mysqli->close();
    } else{
            $returnMessage = "document detail is missing";
            respondToClient(400,array('message' => $returnMessage));
    }
}

function modifyDocument($documentID, $newDocument){
    if($newDocument !=null && $documentID != null){
         $mysqli = connect_database();

       if(!authentication($newDocument['creatorID'],$newDocument['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("UPDATE ". DOCUMENTS_TABLE ." SET Document_Title = '%s', Document_Link = '%s' WHERE Document_ID = '%s' AND Creator_ID = '%s'",
                $mysqli->real_escape_string($newDocument['documentTitle']),
                $mysqli->real_escape_string($newDocument['documentLink']),
                $mysqli->real_escape_string($documentID),
                $mysqli->real_escape_string($newDocument['creatorID']));

        $mysqli->query($newQuery);
        if($mysqli->affected_rows != 0){
            $returnMessage = "document modified successfully";
            respondToClient(200,array('message' => $returnMessage));        
        }
        else{
            $returnMessage = "document is not modified.";
            respondToClient(503,array('message' => $returnMessage));
        }
        $mysqli->close();
    } else{
            $returnMessage = "document id or detail is missing";
            respondToClient(400,array('message' => $returnMessage));
    }
}


function deleteDocument($documentID,$creatorID,$accessToken){
    if($documentID != null){
         $mysqli = connect_database();

         if(!authentication($creatorID,$accessToken)){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        } 

       $newQuery = sprintf("UPDATE ". DOCUMENTS_TABLE ." SET Deleted = 1 WHERE Document_ID = '%s' AND Creator_ID ='%s'",
                $mysqli->real_escape_string($documentID),
                $mysqli->real_escape_string($creatorID));
       $mysqli->query($newQuery);
           if($mysqli->affected_rows !=0){
                $returnMessage = "document deleted successfully";
                respondToClient(200,array('message' => $returnMessage));     
           } else{
            $returnMessage = "document is not deleted.";
            respondToClient(503,array('message' => $returnMessage));
           }
           $mysqli->close();
    } else{
        $returnMessage = "document id is missing";
        respondToClient(400,array('message' => $returnMessage));
    }
}

function documentVote($vote){
    if($vote != null){
         $mysqli = connect_database();

         if(!authentication($vote['userID'],$vote['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("SELECT * FROM " . DOCUMENT_VOTES_TABLE . " WHERE Document_ID = '%s' AND User_ID = '%s'",
            $mysqli->real_escape_string($vote['documentID']),
            $mysqli->real_escape_string($vote['userID']));         
        $result = $mysqli->query($newQuery);
        if($row = $result->fetch_array(MYSQLI_ASSOC)){  //user voted in the past 
            $newQuery = sprintf("UPDATE ". DOCUMENT_VOTES_TABLE ." SET Vote = '%s' WHERE Document_ID = '%s' AND User_ID = '%s'",
                $mysqli->real_escape_string($vote['vote']),
                $mysqli->real_escape_string($vote['documentID']),
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
            $newQuery = sprintf("INSERT INTO " . DOCUMENT_VOTES_TABLE ."(Document_ID,User_ID,Vote,Created_Time) VALUES ('%s','%s','%s','%s')",
                $mysqli->real_escape_string($vote['documentID']),
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
       $returnMessage = "user id and document id are missing";
        respondToClient(400,array('message' => $returnMessage));
    } 
}


