<?php
require_once("config.php");
require_once("constants.php");

database_setup();

function database_setup(){
    //$mysqli = new mysqli("localhost","root","");
    $mysqli = new mysqli("localhost","root","");
    $new_database_query = "CREATE DATABASE IF NOT EXISTS ". CORSVIEW_DB . " DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci";
    if($mysqli->query($new_database_query)){
        echo "works";
    }
    else{
        echo "sucks";
    }
    $mysqli->select_db(CORSVIEW_DB);

    $new_table_query = "CREATE TABLE IF NOT EXISTS `" . USERS_TABLE . "`(
        `User_ID` int(11) NOT NULL AUTO_INCREMENT, 
        `Facebook_ID` int(11) NOT NULL UNIQUE,
        `Facebook_Name` varchar(255) NOT NULL,
        `Gender` tinyint(1) DEFAULT NULL,
        `Access_Token`  varchar(255) DEFAULT NULL,
        `Created_Time` datetime NOT NULL,
        `Last_Log_In_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY(`User_ID`)
        )ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
    $mysqli->query($new_table_query);


    $new_table_query = "CREATE TABLE IF NOT EXISTS `" . MODULES_TABLE . "`(
        `Module_ID` int(11) NOT NULL AUTO_INCREMENT, 
        `Module_Code` varchar(16) NOT NULL,
        `Module_Title` varchar(128) NOT NULL,
        `Module_Year` varchar(16),
        `Module_Sem` varchar(16),
        `Faculty` varchar(128),
        `Department` varchar(128),
        `Module_Description` text,
        `Module_Credit` int(1),
        `Workload` varchar(16),
        `Pre_requisite` varchar(255),
        `Preclusion` varchar(255),
        `Co_requisite` varchar(255),
        `Module_Lecturer` varchar(128),
        `Created_Time` datetime NOT NULL,
        `Modified_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `Deleted` tinyint(1) DEFAULT '0',
        PRIMARY KEY(`Module_ID`)
        )ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
    $mysqli->query($new_table_query);

    $new_table_query = "CREATE TABLE IF NOT EXISTS `" . MODULE_REVIEWS_TABLE . "`(
        `Review_ID` int(11) NOT NULL AUTO_INCREMENT,
        `Module_ID` int(11) NOT NULL,
        `Module_Code` varchar(16) NOT NULL,
        `Module_Title` varchar(128) NOT NULL, 
        `Creator_ID` int(11) NOT NULL,
        `Review_Content` text,
        `Created_Time` datetime NOT NULL,
        `Modified_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `Vote_Up` int(11) DEFAULT '0',
        `Vote_Down` int(11) DEFAULT '0',
        `Deleted` tinyint(1)  DEFAULT '0',
        PRIMARY KEY(`Review_ID`),
        FOREIGN KEY(`Creator_ID`) REFERENCES " . USERS_TABLE . "(`User_ID`) ON UPDATE CASCADE ON DELETE CASCADE,
        FOREIGN KEY(`Module_ID`) REFERENCES " . MODULES_TABLE . "(`Module_ID`) ON UPDATE CASCADE ON DELETE CASCADE
        )ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
    $mysqli->query($new_table_query);

    $new_table_query = "CREATE TABLE IF NOT EXISTS `" . REVIEW_COMMENTS_TABLE . "`(
        `Comment_ID` int(11) NOT NULL AUTO_INCREMENT,
        `Review_ID` int(11) NOT NULL,
        `Creator_ID` int(11) NOT NULL,
        `Comment_Content` text,
        `Created_Time` datetime NOT NULL,
        `Modified_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `Deleted` tinyint(1)  DEFAULT '0',
        PRIMARY KEY(`Comment_ID`),
        FOREIGN KEY(`Review_ID`) REFERENCES " . MODULE_REVIEWS_TABLE . "(`Review_ID`) ON UPDATE CASCADE ON DELETE CASCADE,
        FOREIGN KEY(`Creator_ID`) REFERENCES " . USERS_TABLE . "(`User_ID`) ON UPDATE CASCADE ON DELETE CASCADE
        )ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
    $mysqli->query($new_table_query);

   $new_table_query = "CREATE TABLE IF NOT EXISTS `" . DOCUMENTS_TABLE . "`(
        `Document_ID` int(11) NOT NULL AUTO_INCREMENT,
        `Module_ID` int(11) NOT NULL,
        `Module_Code` varchar(16) NOT NULL,
        `Module_Title` varchar(128) NOT NULL, 
        `Creator_ID` int(11) NOT NULL,
        `Document_Title` varchar(255),
        `Document_Link` varchar(255),
        `Created_Time` datetime NOT NULL,
        `Modified_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `Vote_Up` int(11) DEFAULT '0',
        `Vote_Down` int(11) DEFAULT '0',
        `Deleted` tinyint(1)  DEFAULT '0',
        PRIMARY KEY(`Document_ID`),
        FOREIGN KEY(`Creator_ID`) REFERENCES " . USERS_TABLE . "(`User_ID`) ON UPDATE CASCADE ON DELETE CASCADE,
        FOREIGN KEY(`Module_ID`) REFERENCES " . MODULES_TABLE . "(`Module_ID`) ON UPDATE CASCADE ON DELETE CASCADE

        )ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT =1";
    $mysqli->query($new_table_query);

   $new_table_query = "CREATE TABLE IF NOT EXISTS `" . DOCUMENT_COMMENTS_TABLE . "`(
        `Comment_ID` int(11) NOT NULL AUTO_INCREMENT,
        `Document_ID` int(11) NOT NULL,
        `Creator_ID` int(11) NOT NULL,
        `Comment_Content` text,
        `Created_Time` datetime NOT NULL,
        `Modified_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `Deleted` tinyint(1)  DEFAULT '0',
        PRIMARY KEY(`Comment_ID`),
        FOREIGN KEY(`Document_ID`) REFERENCES " . DOCUMENTS_TABLE . "(`Document_ID`) ON UPDATE CASCADE ON DELETE CASCADE,
        FOREIGN KEY(`Creator_ID`) REFERENCES " . USERS_TABLE . "(`User_ID`) ON UPDATE CASCADE ON DELETE CASCADE
        )ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
    $mysqli->query($new_table_query);

    $new_table_query="CREATE TABLE IF NOT EXISTS `" . ENROLLMENTS_TABLE . "`(
        `Enrollment_ID` int(11) NOT NULL AUTO_INCREMENT,
        `Module_ID` int(11) NOT NULL, 
        `User_ID` int(11) NOT NULL,
        `Created_Time` datetime NOT NULL,
        `Modified_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `Deleted` tinyint(1) DEFAULT '0',
        PRIMARY KEY(`Enrollment_ID`),
        UNIQUE KEY `Module_ID_User_ID` (`Module_ID`,`User_ID`),
        FOREIGN KEY(`User_ID`) REFERENCES " . USERS_TABLE . "(`User_ID`) ON UPDATE CASCADE ON DELETE CASCADE,
        FOREIGN KEY(`Module_ID`) REFERENCES " . MODULES_TABLE . "(`Module_ID`) ON UPDATE CASCADE ON DELETE CASCADE
        )ENGINE=InnoDB DEFAULT CHARSET = latin1 AUTO_INCREMENT =1";
    $mysqli->query($new_table_query);

    $new_table_query="CREATE TABLE IF NOT EXISTS `" . BOOKMARKS_TABLE . "`(
        `Bookmark_ID` int(11) NOT NULL AUTO_INCREMENT,
        `Module_ID` int(11) NOT NULL,
        `User_ID` int(11) NOT NULL,
        `Created_Time` datetime NOT NULL,
        `Modified_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `Deleted` tinyint(1) DEFAULT '0',
        PRIMARY KEY(`Bookmark_ID`),
        UNIQUE KEY `Module_ID_User_ID` (`Module_ID`,`User_ID`),
        FOREIGN KEY(`User_ID`) REFERENCES " . USERS_TABLE . "(`User_ID`) ON UPDATE CASCADE ON DELETE CASCADE,
        FOREIGN KEY(`Module_ID`) REFERENCES " . MODULES_TABLE . "(`Module_ID`) ON UPDATE CASCADE ON DELETE CASCADE
        )ENGINE=InnoDB DEFAULT CHARSET = latin1 AUTO_INCREMENT =1";
    $mysqli->query($new_table_query);

    $new_table_query="CREATE TABLE IF NOT EXISTS `" . REVIEW_VOTES_TABLE . "`(
        `Vote_ID` int(11) NOT NULL AUTO_INCREMENT,
        `Review_ID` int(11) NOT NULL,
        `User_ID` int(11) NOT NULL,
        `Vote` tinyint(1) NOT NULL,
        `Created_Time` datetime NOT NULL,
        `Modified_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `Deleted` tinyint(1) DEFAULT '0',
        PRIMARY KEY(`Vote_ID`),
        FOREIGN KEY(`Review_ID`) REFERENCES " . MODULE_REVIEWS_TABLE . "(`Review_ID`) ON UPDATE CASCADE ON DELETE CASCADE,
        FOREIGN KEY(`User_ID`) REFERENCES " . USERS_TABLE . "(`User_ID`) ON UPDATE CASCADE ON DELETE CASCADE
        )ENGINE=InnoDB DEFAULT CHARSET = latin1 AUTO_INCREMENT =1";
    $mysqli->query($new_table_query);

    $new_table_query="CREATE TABLE IF NOT EXISTS `" . DOCUMENT_VOTES_TABLE . "`(
        `Vote_ID` int(11) NOT NULL AUTO_INCREMENT,
        `Document_ID` int(11) NOT NULL,
        `User_ID` int(11) NOT NULL,
        `Vote` tinyint(1) NOT NULL,
        `Created_Time` datetime NOT NULL,
        `Modified_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `Deleted` tinyint(1) DEFAULT '0',
        PRIMARY KEY(`Vote_ID`),
        FOREIGN KEY(`Document_ID`) REFERENCES " . DOCUMENTS_TABLE . "(`Document_ID`) ON UPDATE CASCADE ON DELETE CASCADE,
        FOREIGN KEY(`User_ID`) REFERENCES " . USERS_TABLE . "(`User_ID`) ON UPDATE CASCADE ON DELETE CASCADE
        )ENGINE=InnoDB DEFAULT CHARSET = latin1 AUTO_INCREMENT =1";
    $mysqli->query($new_table_query);

}