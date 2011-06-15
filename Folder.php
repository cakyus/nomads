<?php

class Nomads_Folder {
	
	private $path;
	
	public function open($path) {
		$this->path = $path;
		return is_dir($path);
	}
		
	public function openCurrentFolder() {
		return $this->open(getcwd());
	}
	
	public function create() {
		return mkdir($this->path);
	}
		
	public function delete() {
		return rmdir($this->path);
	}
	
	public function getParentFolder() {
		$folder = new Nomads_Folder;
		$dir = $this->getFixedPath();
		$dirs = explode('\\',$dir);
		array_pop($dirs);
		$dir = implode('\\',$dirs);
		$folder->open($dir);
		return $folder;
	}
		
	public function getName() {
		return basename($this->path);
	}
	
	public function getPath() {
		if (is_dir($this->path)) {
			$this->path = realpath($this->path);
		}
		return $this->path;
	}
	
	public function getFolders() {
	    
	}
	
	public function getFiles() {
	
	    $files = array();
	    
		$path = $this->path;
		$path = str_replace('\\','/',$path);
		
		if (!$dh = opendir($path)) {
			return false;
		}
		
		if (substr($path,-1) != '/') {
			$path .= '/';
		}
		
		while (($file = readdir($dh)) !== false) {
			$filePath = $path.$file;
#			echo $filePath."\n";
			if (is_file($filePath)) {
#    			echo $filePath."\n";
				$Nomads_File = new Nomads_File;
				$Nomads_File->open($filePath);
				$files[] = $Nomads_File;
			}
		}
		
		closedir($dh);
		
	    return $files;
	}
	
	private function getFixedPath() {
		if (is_dir($this->path)) {
			$this->path = realpath($this->path);
		}
		$this->path = str_replace('/','\\',$this->path);
		if (substr($this->path,-1) == '\\') {
			$this->path = substr($this->path,0,-1);
		}
		return $this->path;
	}
	
}

