<?php
require_once("config.php");
require_once('constants.php');
require_once('common_functions.php');

getModDetails("BN5501");

function getModDetails($modCode){
	if($modCode != null){
		$con = connect_database() or die(mysql_error());
    	mysql_select_db(CORSVIEW_DB,$con) or die(mysql_error());

		$new_query = sprintf("SELECT * FROM ". MODULES_TABLE ." WHERE Module_Code ='%s'",mysql_real_escape_string(($modCode)));
		
		if($result = mysql_query($new_query,$con)){
			$row = mysql_fetch_array($result);
			if($row['Module_Code'] != null && $row['Deleted'] == 0){
				$moduleDetail = $row;
				$moduleReviews = array();
				$moduleDocuments = array();

				$new_query = sprintf("SELECT * FROM ". MODULE_REVIEWS_TABLE ." WHERE Module_ID ='%s'",mysql_real_escape_string(($row['Module_ID'])));
				if($result = mysql_query($new_query,$con)){
					$row = mysql_fetch_array($result);
					while ($row['Review_ID'] != null && $row['Deleted'] == 0) {
						$new_query = sprintf("SELECT * FROM ". COMMENTS_TABLE ." WHERE Review_ID ='%s'",mysql_real_escape_string(($row['Review_ID'])));
						$comments = mysql_query($new_query,$con);
						$review = array("review" => $row, "comments" => $comments);
						array_push($moduleReviews, $review);

						$row = mysql_fetch_array($result);
					}
				}

				$new_query = sprintf("SELECT * FROM ". DOCUMENTS_TABLE ." WHERE Module_ID ='%s'",mysql_real_escape_string(($row['Module_ID'])));
				if($result = mysql_query($new_query,$con)){
					$row = mysql_fetch_array($result);
					while ($row['Document_ID'] != null && $row['Deleted'] == 0) {
						$new_query = sprintf("SELECT * FROM ". COMMENTS_TABLE ." WHERE Document_ID ='%s'",mysql_real_escape_string(($row['Document_ID'])));
						$comments = mysql_query($new_query,$con);
						$document = array("document" => $row, "comments" => $comments);
						array_push($moduleDocuments, $document);

						$row = mysql_fetch_array($result);
					}
				}

				$returnMessage = "module found!";
				respondToClient(401,array('message' => $returnMessage, 'moduleDetail' => $moduleDetail, 'moduleReviews' => $moduleReviews, 'moduleDocuments' => $moduleDocuments));
			}
			else{
				$returnMessage = "module not found";
				respondToClient(401,array('message' => $returnMessage, 'Module_Code' => $modCode));	
			}
		}
		else{
			$errorMessage = "Database error.";
			respondToClient(401,array('message' => $errorMessage, 'Module_Code' => $modCode));
		}
	}
	else{
		$errorMessage = "mod code is empty.";
		respondToClient(401,array('message' => $errorMessage));
	}
}

?>
