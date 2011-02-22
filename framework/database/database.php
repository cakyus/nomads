<?php

class database {
    
	public function exec($sql) {
		
		$connection = databaseConnection::getInstance();
		
		if ($query = mysql_query($sql, $connection->handle)) {
			return $query;
		} else {
			trigger_error($this->getErrorString().' "'.$sql.'"', E_USER_WARNING);
			return false;
		}
	}
    
    public function query($sql) {
		
		$connection = databaseConnection::getInstance();
        
        $result = array();
        if (!$query = mysql_query($sql, $connection->handle)) {
			trigger_error($this->getErrorString().' "'.$sql.'"', E_USER_WARNING);
            return $result;
        }
        
        while ($rows = mysql_fetch_assoc($query)) {
            $result[] = $rows;
        }
        return $result;
    }
	
    public function quote($text) {
		$connection = databaseConnection::getInstance();
        return '"'.mysql_real_escape_string($text, $connection->handle).'"';
    }
	
    public function getErrorString() {
		$connection = databaseConnection::getInstance();
        return mysql_error($connection->handle);
    }
	
	public function getInsertId() {
		$connection = databaseConnection::getInstance();
		return mysql_insert_id($connection->handle);
	}
}
