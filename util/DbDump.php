<?php

require_once("../ConfigManager.php");

$configManager = new ConfigManager();

//ENTER THE RELEVANT INFO BELOW
$mysqlDatabaseName 	=	$configManager->getDatabase();
$mysqlUserName 		=	$configManager->getUser();
$mysqlPassword 		=	$configManager->getPassword();
$mysqlHostName 		=	$configManager->getHost();
$mysqlExportPath 	=	"../database/backups/db_dump_".date("Y-m-d").".sql";

//DONT EDIT BELOW THIS LINE
//Export the database and output the status to the page
$command='mysqldump --opt -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' > ~/' .$mysqlExportPath;
exec($command,$output=array(),$worked);
switch($worked){
    case 0:
        echo 'Database <b>' .$mysqlDatabaseName .'</b> successfully exported to <b>~/' .$mysqlExportPath .'</b>';
        break;
    case 1:
        echo 'There was a warning during the export of <b>' .$mysqlDatabaseName .'</b> to <b>~/' .$mysqlExportPath .'</b>';
        break;
    case 2:
        echo 'There was an error during export. Please check your values:<br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' .$mysqlHostName .'</b></td></tr></table>';
        break;
}
?>  