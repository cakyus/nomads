<?php

/**
 * Nomads_View
 **/
 
class Nomads_View {

	private $title;
	private $content;
	private $styles;
	private $scripts;
	
	public function __construct() {
	    $this->styles = array();
	    $this->scripts = array();
	}

	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function addStyle($filePath) {
	
		$storage = new Nomads_Storage;
		
		$className = get_class($this);
		$libraryName = substr($className, 0, strpos($className, '_'));
		$filePath = $libraryName.'/'.$filePath;
		
		if ($storage->open($filePath)) {
		    $this->styles[] = $storage->getURL();
		}
	}

	public function addScript($URL) {
	    $this->scripts[] = $URL;
	}

	public function add($string) {
		$this->content .= $string;
	}

	public function write() {
	
		$config = new Nomads_Config;
		
		echo '<html><head>';
		echo '<title>'.$this->title.'</title>';
				
		// styles
		foreach ($this->styles as $style) {
		    echo '<link rel="stylesheet" type="text/css"'
		    	.' href="'.$style.'"'
		    	.' />';    
        }
		// scripts
		foreach ($this->scripts as $script) {
		    echo '<script src="'.$storageURL.'/'.$script.'"></script>';    
        }
        
		echo '</head><body><center><div id="theme">';
		
		if (empty($this->pageTitle) == false) {
    		echo '<h1>'.$this->pageTitle.'</h1>';
		}
		
		echo $this->content;
		echo '</div></center></body></html>';
	}
}

