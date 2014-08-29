<?php
require_once('constants.php');
require_once('common_functions.php');
function getModuleInfo($module_code){
    if($module_code !=null){
        require_once('database_setup.php');
        $dbc = connect_database();
        $db = select_database($dbc);

        $newQuery = sprintf("SELECT * FROM " . MODULES_TABLE ." WHERE Module_Code = '%s'",
                mysql_real_escape_string($module_code));
            $result = mysql_query($newQuery,$dbc);
            if($row = mysql_fetch_array($result)){
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
        mysql_close($dbc);      
        }
        else{
            $returnMessage = "module code is missing";
            respondToClient(400,array('message' => $returnMessage));
        }
}

function getModuleInfoForSearch(){
    require_once('database_setup.php');
    $dbc = connect_database();
    $db = select_database($dbc);
     $newQuery = "SELECT * FROM " . MODULES_TABLE;
     $result = mysql_query($newQuery,$dbc);
     $moduleList = array();
     while($row = mysql_fetch_array($result)){  
        $module = array(
                    'moduleID' => $row['Module_ID'],
                    'moduleCode' => $row['Module_Code'],
                    'moduleTitle' => $row['Module_Title']);
                array_push($moduleList,$module);
     }
    respondToClient(400,array('moduleInfoList' => $moduleList));

}