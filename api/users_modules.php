<?php
require_once('constants.php');
require_once('common_functions.php');

function getModulesTaken($userID){
    if($user != null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

        $newQuery = sprintf("SELECT * FROM " . MODULES_TABLE . .", ". ENROLLMENTS_TABLE " WHERE User_ID = '%s'",
                mysql_real_escape_string($userID));
        $result = mysql_query($newQuery,$dbc);

        $moduleList = array();
        while($row = mysql_fetch_array($result)){
            $module = array(
                    'moduleID' => $row['Module_ID'],
                    'moduleCode' => $row['Module_Code'],
                    'moduleTitle' => $row['Module_Title']);
                array_push($moduleList,$module);
        }

        respondToClient(400,array('moduleTakenList' => $moduleList));
    }
    else{
        $returnMessage = "user id is missing";
        respondToClient(400,array('message' => $returnMessage));
    }
}


function addEnrollment($enrollmentsDetails){
    if ($enrollmentsDetails != null) {
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);
        
        if(!authentication($enrollmentsDetails['userID'],$enrollmentsDetails['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("INSERT INTO ". ENROLLMENTS_TABLE ." (Module_ID,User_ID,Created_Time) VALUES ('%s','%s','%s')",
                mysql_real_escape_string($enrollmentsDetails['moduleID']),
                mysql_real_escape_string($enrollmentsDetails['userID']),
                mysql_real_escape_string(timeGenerator()));
        // note: remember to handle exception here, e.g. inserting the same enrollment
        if(mysql_query($newQuery,$dbc)){
            $returnMessage = "module enrolled successfully";
            respondToClient(200,array('message' => $returnMessage,'Enrollment_ID' => mysql_insert_id()));        
        }
        else{
             $returnMessage = "module are not enrolled.";
            respondToClient(503,array('message' => $returnMessage));
        }
        mysql_close($dbc);
    } else{
            $returnMessage = "enrollments detail is missing";
            respondToClient(400,array('message' => $returnMessage));
    }
}

function deleteEnrollment($enrollmentsDetails){
    if ($enrollmentsDetails != null) {
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);
        
        if(!authentication($enrollmentsDetails['userID'],$enrollmentsDetails['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $new_query = sprintf("UPDATE ". ENROLLMENTS_TABLE ." SET Deleted = 1 WHERE Enrollment_ID = '%s' ",
                mysql_real_escape_string($enrollmentsDetails['Enrollment_ID']));
        if(mysql_query($new_query,$dbc)){
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
    if($user != null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

        $newQuery = sprintf("SELECT * FROM " . MODULES_TABLE . .", ". BOOKMARKS_TABLE " WHERE User_ID = '%s'",
                mysql_real_escape_string($userID));
        $result = mysql_query($newQuery,$dbc);

        $moduleList = array();
        while($row = mysql_fetch_array($result)){
            $module = array(
                    'moduleID' => $row['Module_ID'],
                    'moduleCode' => $row['Module_Code'],
                    'moduleTitle' => $row['Module_Title']);
                array_push($moduleList,$module);
        }

        respondToClient(400,array('moduleTakenList' => $moduleList));
    }
    else{
        $returnMessage = "user id is missing";
        respondToClient(400,array('message' => $returnMessage));
    }
}


function addBookmark($bookmarkDetails){
    if ($bookmarkDetails != null) {
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);
        
        if(!authentication($bookmarkDetails['userID'],$bookmarkDetails['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $newQuery = sprintf("INSERT INTO ". BOOKMARKS_TABLE ." (Module_ID,User_ID,Created_Time) VALUES ('%s','%s','%s')",
                mysql_real_escape_string($bookmarkDetails['moduleID']),
                mysql_real_escape_string($bookmarkDetails['userID']),
                mysql_real_escape_string(timeGenerator()));
        // note: remember to handle exception here, e.g. inserting the same enrollment
        if(mysql_query($newQuery,$dbc)){
            $returnMessage = "module bookmarked successfully";
            respondToClient(200,array('message' => $returnMessage,'Bookmark_ID' => mysql_insert_id()));        
        }
        else{
             $returnMessage = "module are not bookmarked.";
            respondToClient(503,array('message' => $returnMessage));
        }
        mysql_close($dbc);
    } else{
            $returnMessage = "bookmark detail is missing";
            respondToClient(400,array('message' => $returnMessage));
    }
}

function deleteBookmark($bookmarkDetails){
    if ($bookmarkDetails != null) {
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);
        
        if(!authentication($bookmarkDetails['userID'],$bookmarkDetails['accessToken'])){
            $returnMessage = "user is not authorized.";
            respondToClient(403,array('message' => $returnMessage));
            return;
        }

        $new_query = sprintf("UPDATE ". BOOKMARKS_TABLE ." SET Deleted = 1 WHERE Bookmark_ID = '%s' ",
                mysql_real_escape_string($bookmarkDetails['Bookmark_ID']));
        if(mysql_query($new_query,$dbc)){
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






