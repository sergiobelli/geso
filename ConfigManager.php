<?php

require_once("dblib.php");
require_once("clublib.php");

class ConfigManager {

	$ambiente				= "locale"; //"online";
	
	//Parametri di accesso: localhost
	$Host_locale     		= "localhost";
	$Database_locale 		= "atletica60358";
	$User_locale     		= "root";
	$Password_locale 		= "";
	$table_prefix_locale 	= "sd";
	
	
	//Parametri di accesso: atleticavalsesia.it
	$Host     				= "sql.atleticavalsesia.it";
	$Database 				= "atletica60358";
	$User     				= "atletica60358";
	$Password 				= "atle17370";
	$table_prefix 			= "sd";
	
	function getHost () {
		if ($ambiente == "online") {
			return $Host;
		} else {
			return $Host_locale;
		}
	}

	function getDatabase () {
		if ($ambiente == "online") {
			return $Database;
		} else {
			return $Database_locale;
		}
	}
	
	function getUser () {
		if ($ambiente == "online") {
			return $User;
		} else {
			return $User_locale;
		}
	}
	
	function getPassword () {
		if ($ambiente == "online") {
			return $Password;
		} else {
			return $Password_locale;
		}
	}
	
	function getTablePrefix () {
		if ($ambiente == "online") {
			return $table_prefix;
		} else {
			return $table_prefix_locale;
		}
	}
}