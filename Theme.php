<?php


class Nomads_Theme {

	private $title;
	private $pageTitle;
	private $content;

	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function setPageTitle($pageTitle) {
		$this->pageTitle = $pageTitle;
	}

	public function add($string) {
		$this->content .= $string;
	}

	public function write() {
		
		if (empty($this->pageTitle)) {
			$this->pageTitle = $this->title;
			
		}
		
		echo '<html><head>';
		echo '<title>'.$this->title.'</title>';
		
		echo '<style>'
			.'body { background-color: #000; color: #fff; }'
			.'body { font-family: georgia; }'
			.'</style>';
		
		echo '</head><body>';
		echo '<h1>'.$this->pageTitle.'</h1>';
		echo $this->content;
		echo '</body></html>';
	}
}

