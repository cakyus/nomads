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
	
	public function addStyle($URL) {
	    $this->styles[] = $URL;
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
		
		//$storageURL = $config->get('Nomads_Storage_URL');
		$storageURL = '';
		
		// styles
		foreach ($this->styles as $style) {
		    echo '<link rel="stylesheet" type="text/css"'
		    	.' href="'.$storageURL.'/'.$style.'"'
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

