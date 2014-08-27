<?php
require_once("config.php");
require_once("constants.php");

module_update();

function module_update(){
    $con = connect_database() or die(mysql_error());
    mysql_select_db(CORSVIEW_DB,$con) or die(mysql_error());

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
            echo $code ."<br>";
            echo $module->ModuleTitle ."<br>";
            echo $module->ModuleDescription ."<br>";
            // echo $module->AcadYear ."<br>";
            // echo $module->SemesterName ."<br>";
            // echo $module->Faculty ."<br>";
            // echo $module->Department ."<br>";
            // echo $module->ModuleCredit ."<br>";
            // echo $module->Workload ."<br>";
            // echo $module->Prerequisite ."<br>";
            // echo $module->Preclusion ."<br>";
            // echo $module->Corequisite ."<br>";
            echo "<br>";

      //      $new_insert_query = sprintf("INSERT INTO ". MODULES_TABLE ." (Module_Code,Module_Title,Module_Year,Module_Sem,Faculty,Department,Module_Description,
       //         Module_Credit,Workload,Pre_requisite,Co_requisite,Created_TIme) VALUES ('%s','%s','%s','%s')",
          $new_insert_query = sprintf("INSERT INTO ". MODULES_TABLE ." (Module_Code,Module_Title,Module_Year,Module_Sem,Faculty,Department,Module_Description,
                Module_Credit,Workload,Pre_requisite,Preclusion,Co_requisite,Created_TIme) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
                mysql_real_escape_string($module->ModuleCode),
                mysql_real_escape_string($module->ModuleTitle),
                mysql_real_escape_string($module->AcadYear),
                mysql_real_escape_string($module->SemesterName),
                mysql_real_escape_string($module->Faculty),
                mysql_real_escape_string($module->Department),
                mysql_real_escape_string($module->ModuleDescription),
                mysql_real_escape_string($module->ModuleCredit),
                mysql_real_escape_string($module->Workload),
                mysql_real_escape_string($module->Prerequisite),
                mysql_real_escape_string($module->Preclusion),
                mysql_real_escape_string($module->Corequisite),
                mysql_real_escape_string(date('Y-m-d H:i:s')));


          //$new_insert_query = 
          //      "INSERT INTO " .MODULES_TABLE. " (Module_Code,Module_Title,Module_Description,Created_Time,Modified_Time) VALUES (" .$module->ModuleCode. "," .$module->ModuleTitle. "," .$module->ModuleDescription. ",'2014-1-1 1:1:1','2014-2-2 2:2:2')";
            
            mysql_query($new_insert_query,$con);
        }
    }
    
}