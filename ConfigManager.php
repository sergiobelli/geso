<?php

//require_once("dblib.php");
//require_once("clublib.php");

class ConfigManager {

	public $ambiente;
	public $Host_locale, $Database_locale, $User_locale, $Password_locale, $table_prefix_locale;
	public $Host, $Database, $User, $Password, $table_prefix;
	
	public function __construct() {
	
		$this->ambiente				= "locale"; //"online";
	
	//Parametri di accesso: localhost
		$this->Host_locale     		= "localhost";
		$this->Database_locale 		= "atletica60358";
		$this->User_locale     		= "root";
		$this->Password_locale 		= "";
		$this->table_prefix_locale 	= "sd";
	
	
	//Parametri di accesso: atleticavalsesia.it
		$this->Host     				= "sql.atleticavalsesia.it";
		$this->Database 				= "atletica60358";
		$this->User     				= "atletica60358";
		$this->Password 				= "atle17370";
		$this->table_prefix 			= "sd";
	
	}
		
	function getHost () {
		if ($this->ambiente == "online") {
			return $this->Host;
		} else {
			return $this->Host_locale;
		}
	}

	function getDatabase () {
		if ($this->ambiente == "online") {
			return $this->Database;
		} else {
			return $this->Database_locale;
		}
	}
	
	function getUser () {
		if ($this->ambiente == "online") {
			return $this->User;
		} else {
			return $this->User_locale;
		}
	}
	
	function getPassword () {
		if ($this->ambiente == "online") {
			return $this->Password;
		} else {
			return $this->Password_locale;
		}
	}
	
	function getTablePrefix () {
		if ($this->ambiente == "online") {
			return $this->table_prefix;
		} else {
			return $this->table_prefix_locale;
		}
	}
}