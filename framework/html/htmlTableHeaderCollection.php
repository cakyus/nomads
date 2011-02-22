<?php

class htmlTableHeaderCollection extends htmlElement {
    
    public function __construct() {
        parent::__construct();
        $this->tagName = 'thead';
    }

    public function add($text) {
        
        $htmlText = new htmlText;
        $htmlTableHeader = new htmlTableHeader;
        
        $htmlText->appendData($text);
        $htmlTableHeader->appendChild($htmlText);
        $this->children->append($htmlTableHeader);
        
        return $htmlTableHeader;
    }
}

