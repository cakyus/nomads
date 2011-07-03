<?php
class Nomads_HTML_Form_Textarea extends Nomads_HTML_Form_InputLabel {
    
    public $name;
    
    public function __construct() {
        parent::__construct();
        $this->tagName = 'textarea';
        $this->attributesSpecial[] = 'value';
    }
    
    public function __toString() {
        $this->innerText = $this->value;
        return parent::__toString();
    }
}

