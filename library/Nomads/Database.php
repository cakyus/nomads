<?php

class Nomads_Database {

	private $handle;
	
    public function __construct() {
    	
    	$config = new Nomads_Database_Config;
    	
    	$hostname = $config->hostname;
    	$username = $config->username;
    	$password = $config->password;
    	$database = $config->database;
    	
		if ($handle = mysql_connect($hostname, $username, $password)) {
			// it's okay
		} else {
			exit('can\'t connect to database');
		}
		
		if (mysql_select_db($database, $handle)) {
			// it's okay
		} else {
			exit('can\'t open database');
		}
		
		$this->handle = $handle;
    }
	
	public function query($sql) {
		
        $result = array();
        
        if ($query = mysql_query($sql, $this->handle)) {
			while ($rows = mysql_fetch_assoc($query)) {
				$result[] = $rows;
			}
		} else {			
            trigger_error($this->getErrorString()."\n".$sql, E_USER_WARNING);
        }
        
        return $result;		
	}
	
	public function exec($sql) {
		if ($query = mysql_query($sql, $this->handle)) {
			return $query;
		} else {
			trigger_error($this->getErrorString()."\n".$sql, E_USER_WARNING);
		}
		return false;
	}
	
	public function quote($string) {
        return '"'.mysql_real_escape_string($string, $this->handle).'"';
	}
	
	public function getErrorNumber() {
        return mysql_errno($this->handle);
	}
	
	public function getErrorString() {
        return mysql_error($this->handle);
	}
	
	public function getCurrentTime() {
		if ($query = $this->query('SELECT CURRENT_TIMESTAMP()')) {
			return strtotime(current($query[0]));
		}
		return false;
	}
	
	public function getInsertId() {
		return mysql_insert_id($this->handle);
	}
}

