<?php
require_once('config.php');
require_once('constants.php');
require_once('common_functions.php');

function getModulesTaken($userID){
    if($userID != null){
         $mysqli = connect_database();

        $newQuery = sprintf("SELECT * FROM " . MODULES_TABLE . ",". ENROLLMENTS_TABLE . " WHERE " . MODULES_TABLE . ".Module_ID =" . ENROLLMENTS_TABLE .
            ".Module_ID AND User_ID = '%s' AND " . MODULES_TABLE . ".Deleted = 0 AND " . ENROLLMENTS_TABLE . ".Deleted = 0",
                $mysqli->real_escape_string($userID));
        if($result = $mysqli->query($newQuery)){
            $moduleList = array();
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                $module = array(
                        'moduleID' => $row['Module_ID'],
                        'moduleCode' => $row['Module_Code'],
                        'moduleTitle' => $row['Module_Title']);
                    array_push($moduleList,$module);
            }
            respondToClient(200,array('moduleTakenList' => $moduleList));
            } else{
            $returnMessage = "No enrollment record";
            respondToClient(200,array('message' => $returnMessage));
        }
    }
    else{
        $returnMessage = "user id is missing";
        respondToClient(400,array('message' => $returnMessage));
    }
}

function addEnrollmentList($enrollmentsDetailList){
    if ($enrollmentsDetailList != null) {
         $mysqli = connect_database();
        
        if(!authentication($enrollmentsDetailList['userID'],$enrollmentsDetailList['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $count = 0;

        for ($enrollmentsDetailList['list'] as $enrollmentsDetails){

            // check whether the module code exist in the db
            $newQuery = sprintf("SELECT * FROM " . MODULES_TABLE ." WHERE Module_Code = '%s' AND Deleted = 0",
                $mysqli->real_escape_string($enrollmentsDetails['moduleCode']));
            $result=$mysqli->query($newQuery);
            // create enrollment only when the module code exist in the db
            // deal with this issue later
            if($row = $result->fetch_array(MYSQLI_ASSOC)){
                $moduleID = $row['Module_ID'];

                $newQuery = sprintf("SELECT * FROM " . ENROLLMENTS_TABLE ." WHERE Module_ID = '%s' AND User_ID = '%s' AND Deleted = 0",
                    $mysqli->real_escape_string($moduleID),
                    $mysqli->real_escape_string($enrollmentsDetails['userID']));
                $mysqli->query($newQuery);
                if($mysqli->affected_rows != 0){
                    break;
                } else{
                    $newQuery = sprintf("INSERT INTO ". ENROLLMENTS_TABLE ." (Module_ID,User_ID,Created_Time) VALUES ('%s','%s','%s')",
                            $mysqli->real_escape_string($moduleID),
                            $mysqli->real_escape_string($enrollmentsDetails['userID']),
                            $mysqli->real_escape_string(timeGenerator()));
                    // note: remember to handle exception here, e.g. inserting the same enrollment
                $mysqli->query($newQuery);
                if($mysqli->affected_rows != 0){
                        $count += 1;
                    }
                }

            } 

            
        }

        $mysqli->close();

        $returnMessage = strval($count) . " modules enrolled successfully";
        respondToClient(200,array('message' => $returnMessage));        

    } else{
            $returnMessage = "enrollments detail is missing";
            respondToClient(400,array('message' => $returnMessage));
    }
}

function addEnrollment($enrollmentsDetails){
    if ($enrollmentsDetails != null) {
         $mysqli = connect_database();
        
        if(!authentication($enrollmentsDetails['userID'],$enrollmentsDetails['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        // check whether the module code exist in the db
        $newQuery = sprintf("SELECT * FROM " . MODULES_TABLE ." WHERE Module_Code = '%s' AND Deleted = 0",
            $mysqli->real_escape_string($enrollmentsDetails['moduleCode']));
        $result=$mysqli->query($newQuery);
        // create enrollment only when the module code exist in the db
        // deal with this issue later

        if($row = $result->fetch_array(MYSQLI_ASSOC)){
            $moduleID = $row['Module_ID'];

            $newQuery = sprintf("SELECT * FROM " . ENROLLMENTS_TABLE ." WHERE Module_ID = '%s' AND User_ID = '%s' AND Deleted = 0",
                $mysqli->real_escape_string($moduleID),
                $mysqli->real_escape_string($enrollmentsDetails['userID']));
            $mysqli->query($newQuery);
            if($mysqli->affected_rows != 0){
                $returnMessage = "user has enrolled this module ";
                respondToClient(200,array('message' => $returnMessage));
            } else{
                $newQuery = sprintf("INSERT INTO ". ENROLLMENTS_TABLE ." (Module_ID,User_ID,Created_Time) VALUES ('%s','%s','%s')",
                        $mysqli->real_escape_string($moduleID),
                        $mysqli->real_escape_string($enrollmentsDetails['userID']),
                        $mysqli->real_escape_string(timeGenerator()));
                // note: remember to handle exception here, e.g. inserting the same enrollment
                $mysqli->query($newQuery);
                if($mysqli->affected_rows != 0){
                    $returnMessage = "module enrolled successfully";
                    respondToClient(200,array('message' => $returnMessage,'Enrollment_ID' => mysql_insert_id()));        
                } else{
                    $returnMessage = "module are not enrolled.";
                    respondToClient(503,array('message' => $returnMessage));
                }
            }
        } else {
            $returnMessage = "module not exist";
            respondToClient(200,array('message' => $returnMessage));
        }

        $mysqli->close();
    } else{
            $returnMessage = "enrollments detail is missing";
            respondToClient(400,array('message' => $returnMessage));
    }
}

function deleteEnrollment($enrollmentID,$userID,$accessToken){
    if ($enrollmentID != null) {
         $mysqli = connect_database();        
        if(!authentication($userID,$accessToken)){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("UPDATE ". ENROLLMENTS_TABLE ." SET Deleted = 1 WHERE Enrollment_ID = '%s' AND User_ID = '%s'",
                $mysqli->real_escape_string($enrollmentID),
                $mysqli->real_escape_string($userID));
        $mysqli->query($newQuery);
        if($mysqli->affected_rows != 0){
            $returnMessage = "enrollment deleted successfully";
            respondToClient(200,array('message' => $returnMessage));     
        } else{
            $returnMessage = "enrollment is not deleted.";
            respondToClient(503,array('message' => $returnMessage));
        }
    } else{
            $returnMessage = "enrollments detail is missing";
            respondToClient(400,array('message' => $returnMessage));
    }
}


function getModulesBookmarked($userID){
    if($userID != null){
         $mysqli = connect_database();

        $newQuery = sprintf("SELECT * FROM " . MODULES_TABLE . ",". BOOKMARKS_TABLE . " WHERE " . MODULES_TABLE . ".Module_ID =" . BOOKMARKS_TABLE .
            ".Module_ID AND User_ID = '%s' AND " . MODULES_TABLE . ".Deleted = 0 AND " . BOOKMARKS_TABLE . ".Deleted = 0" ,
            $mysqli->real_escape_string($userID));
        if($result = $mysqli->query($newQuery)){
            $moduleList = array();
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                $module = array(
                        'moduleID' => $row['Module_ID'],
                        'moduleCode' => $row['Module_Code'],
                        'moduleTitle' => $row['Module_Title']);
                    array_push($moduleList,$module);
            }
            respondToClient(200,array('moduleTakenList' => $moduleList));
        } else{
            $returnMessage = "no bookmark records";
            respondToClient(200,array('message' => $returnMessage));
        }
    }
    else{
        $returnMessage = "user id is missing";
        respondToClient(400,array('message' => $returnMessage));
    }
}


function addBookmark($bookmarkDetails){
    if ($bookmarkDetails != null) {
         $mysqli = connect_database();

        
        if(!authentication($bookmarkDetails['userID'],$bookmarkDetails['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }
        $newQuery = sprintf("SELECT * FROM " . BOOKMARKS_TABLE ." WHERE Module_ID = '%s' AND User_ID = '%s' AND Deleted = 0",
            $mysqli->real_escape_string($bookmarkDetails['moduleID']),
            $mysqli->real_escape_string($bookmarkDetails['userID']));

        $mysqli->query($newQuery);
        if($mysqli->affected_rows != 0){
            $returnMessage = "user has bookmarked this module ";
            respondToClient(200,array('message' => $returnMessage));
        } else{
            $newQuery = sprintf("INSERT INTO ". BOOKMARKS_TABLE ." (Module_ID,User_ID,Created_Time) VALUES ('%s','%s','%s')",
                    $mysqli->real_escape_string($bookmarkDetails['moduleID']),
                    $mysqli->real_escape_string($bookmarkDetails['userID']),
                    $mysqli->real_escape_string(timeGenerator()));
            // note: remember to handle exception here, e.g. inserting the same enrollment
        $mysqli->query($newQuery);
        if($mysqli->affected_rows != 0){
                $bookmarkID = $mysqli->insert_id;
                $returnMessage = "module bookmarked successfully";
                respondToClient(200,array('message' => $returnMessage,'Bookmark_ID' => $bookmarkID));        
            }
            else{
                 $returnMessage = "module are not bookmarked.";
                respondToClient(503,array('message' => $returnMessage));
            }
        }
        $mysqli->close();
    } else{
            $returnMessage = "bookmark detail is missing";
            respondToClient(400,array('message' => $returnMessage));
    }
}

function deleteBookmark($bookmarkID,$creatorID,$accessToken){
    if ($bookmarkID != null) {
         $mysqli = connect_database();
        if(!authentication($creatorID,$accessToken)){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("UPDATE ". BOOKMARKS_TABLE ." SET Deleted = 1 WHERE Bookmark_ID = '%s' ",
                $mysqli->real_escape_string($bookmarkID));
        $mysqli->query($newQuery);
        if($mysqli->affected_rows != 0){
            $returnMessage = "bookmark deleted successfully";
            respondToClient(200,array('message' => $returnMessage));     
        } else{
            $returnMessage = "bookmark is not deleted.";
            respondToClient(503,array('message' => $returnMessage));
        }

    } else{
            $returnMessage = "bookmark detail is missing";
            respondToClient(400,array('message' => $returnMessage));
    }
}






