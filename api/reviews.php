<?php
require_once('constants.php');
require_once('common_functions.php');

function getReviews($module_code){
    if($module_code !=null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

         $new_query = sprintf("SELECT * FROM " . MODULE_REVIEWS_TABLE ." WHERE Module_Code = '%s'",
                mysql_real_escape_string($module_code));
     //   $new_query = "SELECT * FROM " . MODULE_REVIEWS_TABLE ." WHERE Review_ID = 2";

        $result = mysql_query($new_query,$dbc);
        $review_list = array();
            while($row = mysql_fetch_array($result)){
                echo 'true';
                $review = array(
                    'Review_ID' => $row['Review_ID'],
                    'moduleCode' => $row['Module_Code'],
                    'moduleTitle' => $row['Module_Title'],
                    'moduleReview' => $row['Module_Title'],
                    'createdTime' => $row['Created_Time'],
                    'modifiedTime' => $row['Modified_Time'],
                    'like' => $row['Like'],
                    'dislike' => $row['Dislike']);
                array_push($review_list,$review);
            }
            if(sizeof($review_list) == 0){
                    $returnMessage = "reviews are not found.";
                    respondToClient(404,array('message' => $returnMessage));
            }
            else{
            $returnMessage = "get module info successfully.";
            respondToClient(200,array('message' => $returnMessage, 'review_list' => $review_list));
            }

            mysql_close($dbc);      
        }
        else{
            $returnMessage = "module code is missing";
            respondToClient(400,array('message' => $returnMessage));
        }
}

function addReview($reviewDetails){
    if($reviewDetails !=null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

        $new_insert_query = sprintf("INSERT INTO ". MODULE_REVIEWS_TABLE ." (Module_Code,Module_Title,Creator_ID,Review_Content,Created_Time) VALUES ('%s','%s','%s','%s','%s')",
                $reviewDetails->ModuleCode,
                $reviewDetails->ModuleTitle,
                $reviewDetails->CreatorID,
                $reviewDetails->ReviewContent,
                mysql_real_escape_string(date('Y-m-d H:i:s')));

        $result = mysql_query($new_query,$dbc);

        $returnMessage = "review added successfully";
        respondToClient(200,array('message' => $returnMessage);        


        mysql_close($dbc);
    } else{
            $returnMessage = "review detail is missing";
            respondToClient(400,array('message' => $returnMessage));
    }
}

function modifyReview($reviewID, $newContent){
    if($newContent !=null && $reviewID != null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

        $new_insert_query = sprintf("UPDATE ". MODULE_REVIEWS_TABLE ." SET Review_Content = '%s', Modified_Time = '%s' WHERE Review_ID = '%s' ",
                $newContent,
                mysql_real_escape_string(date('Y-m-d H:i:s')), 
                $reviewID);

        $result = mysql_query($new_query,$dbc);

        $returnMessage = "review modified successfully";
        respondToClient(200,array('message' => $returnMessage);        

        mysql_close($dbc);
    } else{
            $returnMessage = "review id or detail is missing";
            respondToClient(400,array('message' => $returnMessage));
    }
}

function deleteReview($reviewID){
    if($reviewID != null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

        $new_insert_query = sprintf("DELETE FROM ". MODULE_REVIEWS_TABLE ."WHERE Review_ID = '%s' ",
                $reviewID);

        $result = mysql_query($new_query,$dbc);

        $returnMessage = "review deleted successfully";
        respondToClient(200,array('message' => $returnMessage);        

        mysql_close($dbc);
    } else{
            $returnMessage = "review id is missing";
            respondToClient(400,array('message' => $returnMessage));
    }
}





