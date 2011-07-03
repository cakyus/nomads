<?php
class Nomads_HTML_Form extends Nomads_HTML_Element {
    
    public $method;
    public $action;
    public $dataSource;
    
    public function __construct() {
        parent::__construct();
        $this->tagName = 'form';
        $this->method = 'POST';
        // by default the action url is current url
        $this->action = 'index.php';
        
        $this->attributesSpecial[] = 'dataSource';
    }
}

