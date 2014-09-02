<?php
require_once('config.php');
require_once('constants.php');
require_once('common_functions.php');
function getModuleInfo($module_code){
    if($module_code !=null){
        $mysqli = connect_database();

        $newQuery = sprintf("SELECT * FROM " . MODULES_TABLE ." WHERE Module_Code = '%s'",
                $mysqli->real_escape_string($module_code));
            $result = $mysqli->query($newQuery);
            if($row = $result->fetch_array(MYSQLI_ASSOC)){
                $returnMessage = "get module info successfully.";
                respondToClient(200,array('message' => $returnMessage, 'Module_ID' => $row['Module_ID'],
                    'moduleCode' => $row['Module_Code'],'moduleTitle' => $row['Module_Title'],
                    'moduleDescription' => $row['Module_Description'],'modulePrerequisite' => $row['Pre_requisite'],
                    'modulePreclusion' => $row['Preclusion'],'moduleCredit' => $row['Module_Credit']));
            }
            else{
                $returnMessage = "module is not found.";
                respondToClient(404,array('message' => $returnMessage));
            }
        $mysqli->close();      
        }
        else{
            $returnMessage = "module code is missing";
            respondToClient(400,array('message' => $returnMessage));
        }
}

function getModuleInfoForSearch(){
     $mysqli = connect_database();
     $newQuery = "SELECT * FROM " . MODULES_TABLE;
     $result = $mysqli->query($newQuery);
     $moduleList = array();
     while($row = $result->fetch_array(MYSQLI_ASSOC)){  
        $module = array(
                    'moduleID' => $row['Module_ID'],
                    'moduleCode' => $row['Module_Code'],
                    'moduleTitle' => $row['Module_Title']);
                array_push($moduleList,$module);
     }
    respondToClient(400,array('moduleInfoList' => $moduleList));

}