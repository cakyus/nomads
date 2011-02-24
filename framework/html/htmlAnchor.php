<?php

class htmlAnchor extends htmlElement {
    
    public $url;
    public $text;

    public function __construct() {
        parent::__construct();
        $this->tagName = 'a';
    }

    public function __toString() {
        
        $htmlText = new htmlText;
        
        $this->setAttribute('href',$this->url);
        $htmlText->appendData($this->text);
        
        $this->appendChild($htmlText);
        
        return parent::__toString();
    }

}

