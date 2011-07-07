<?php

class Nomads_HTML_Form_InputLabel extends Nomads_HTML_Form_Input {
	
	public $label;
	
	public function __construct() {
		parent::__construct();
		$this->attributesSpecial[] = 'label';
	}
	
	public function __toString() {
		
		$output = '';
		
		// add label
		if (	empty($this->label)
			||	empty($this->name)
			) {
			// do nothing
		} else {
			$htmlLabel = new Nomads_HTML_Form_Label;
			$htmlLabel->for = $this->name;
			$htmlLabel->innerText = $this->label;
			$output .= $htmlLabel;
		}
		
		$output .= parent::__toString();
		
		return $output;
	}
}

