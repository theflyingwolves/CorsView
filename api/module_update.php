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
            echo "<br>";
            
      //      $new_insert_query = sprintf("INSERT INTO ". MODULES_TABLE ." (Module_Code,Module_Title,Module_Year,Module_Sem,Faculty,Department,Module_Description,
       //         Module_Credit,Workload,Pre_requisite,Co_requisite,Created_TIme) VALUES ('%s','%s','%s','%s')",
          $new_insert_query = sprintf("INSERT INTO ". MODULES_TABLE ." (Module_Code,Module_Title,Module_Year,Module_Sem,Faculty,Department,Module_Description,
                Module_Credit,Workload,Pre_requisite,Preclusion,Co_requisite,Created_TIme) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
                $module->ModuleCode,
                $module->ModuleTitle,
                $module->AcadYear,
                $module->SemesterName,
                $module->Faculty,
                $module->Department,
                $module->ModuleDescription,
                $module->ModuleCredit,
                $module->Workload,
                $module->Prerequisite,
                $module->Preclusion,
                $module->Corequisite,
                mysql_real_escape_string(date('Y-m-d H:i:s')));

          //$new_insert_query = 
          //      "INSERT INTO " .MODULES_TABLE. " (Module_Code,Module_Title,Module_Description,Created_Time,Modified_Time) VALUES (" .$module->ModuleCode. "," .$module->ModuleTitle. "," .$module->ModuleDescription. ",'2014-1-1 1:1:1','2014-2-2 2:2:2')";
            mysql_query($new_insert_query,$con);
           // echo "finish";
        }
    }
    
}