<?php
require_once("config.php");
require_once("constants.php");

module_update();

function module_update(){
    $mysqli = connect_database();  

    $content0 = json_decode(file_get_contents('http://api.nusmods.com/2014-2015/0/bulletinModulesRaw.json'));
    $content1 = json_decode(file_get_contents('http://api.nusmods.com/2014-2015/1/bulletinModulesRaw.json'));
    $content2 = json_decode(file_get_contents('http://api.nusmods.com/2014-2015/2/bulletinModulesRaw.json'));
    $content3 = json_decode(file_get_contents('http://api.nusmods.com/2014-2015/3/bulletinModulesRaw.json'));
    $content4 = json_decode(file_get_contents('http://api.nusmods.com/2014-2015/4/bulletinModulesRaw.json'));
    $result = array_merge($content0, $content1, $content2, $content3, $content4);

    $record = array();
    $count = 0;
    date_default_timezone_set('UTC');

    foreach ($result as $module){
        $code = $module->ModuleCode;
        // $count ++;

        if (!isset($record[$code])){
    // if ($record[$code] != "yes"){
            $count ++;
            $record[$code] = "yes";
            //echo $code ."<br>";
            //echo $module->ModuleTitle ."<br>";
            //echo $module->ModuleDescription ."<br>";
            // echo $module->AcadYear ."<br>";
            // echo $module->SemesterName ."<br>";
            // echo $module->Faculty ."<br>";
            // echo $module->Department ."<br>";
            // echo $module->ModuleCredit ."<br>";
            // echo $module->Workload ."<br>";
            // echo $module->Prerequisite ."<br>";
            // echo $module->Preclusion ."<br>";
            // echo $module->Corequisite ."<br>";
            //echo "<br>";

      //      $new_insert_query = sprintf("INSERT INTO ". MODULES_TABLE ." (Module_Code,Module_Title,Module_Year,Module_Sem,Faculty,Department,Module_Description,
       //         Module_Credit,Workload,Pre_requisite,Co_requisite,Created_TIme) VALUES ('%s','%s','%s','%s')",
          $new_insert_query = sprintf("INSERT INTO ". MODULES_TABLE ." (Module_Code,Module_Title,Module_Year,Module_Sem,Faculty,Department,Module_Description,
                Module_Credit,Workload,Pre_requisite,Preclusion,Co_requisite,Created_TIme) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
                $mysqli->real_escape_string($module->ModuleCode),
                $mysqli->real_escape_string($module->ModuleTitle),
                $mysqli->real_escape_string($module->AcadYear),
                $mysqli->real_escape_string($module->SemesterName),
                $mysqli->real_escape_string($module->Faculty),
                $mysqli->real_escape_string($module->Department),
                $mysqli->real_escape_string($module->ModuleDescription),
                $mysqli->real_escape_string($module->ModuleCredit),
                $mysqli->real_escape_string($module->Workload),
                $mysqli->real_escape_string($module->Prerequisite),
                $mysqli->real_escape_string($module->Preclusion),
                $mysqli->real_escape_string($module->Corequisite),
                $mysqli->real_escape_string(date('Y-m-d H:i:s')));

       
            $mysqli->query($new_insert_query);
            if($mysqli->cubrid_affected_rows !=0){
                echo "work";
            }
        }
    }
    
}