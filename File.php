<?php

class Nomads_File {
	
	private $path;
	
	public function __construct() {}
	
	public function open($path) {
		$this->path = $path;
		return is_file($path);
	}
		
	public function move($path) {
		if (is_file($path)) {
			return false;
		}
		rename($this->path, $path);
		$this->open($path);
	}
	
	public function getName() {
		return basename($this->path);
	}
		
	public function getNameWithoutExtension($extensionLevel=1) {
	
		$items = explode('.', $this->getName());
		for ($i=0; $i<$extensionLevel;$i++) {
			array_pop($items);
		}
		
		return implode('.', $items);
	}
	
	public function getExtension($extensionLevel=0) {
		$extensions = explode('.',$this->getName());
		$extensions = array_reverse($extensions);
		return $extensions[$extensionLevel];
	}
	
	public function getPath() {
		return $this->path;
	}
		
	public function getFolderPath() {
		return dirname($this->path);
	}
	
	public function getFolder() {
		$folder = new Nomads_Folder;
		$folder->open($this->getFolderPath());
		return $folder;
	}
		
	public function getSize() {
		return filesize($this->path);
	}
	
	public function getContent() {
	    return file_get_contents($this->path);
	}
	
	public function getURL() {
	    if (substr($this->path,0,strlen($_SERVER['DOCUMENT_ROOT']))
    	        == $_SERVER['DOCUMENT_ROOT']) {
            return substr($this->path,strlen($_SERVER['DOCUMENT_ROOT']));
        }
	}
}



