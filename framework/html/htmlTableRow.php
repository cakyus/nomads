<?php

class htmlTableRow extends htmlElement {
    
    public function __construct() {
        parent::__construct();
        $this->tagName = 'tr';
    }

    public function add($text) {
        
        $htmlText = new htmlText;
        $htmlTableData = new htmlTableData;
        
        $htmlText->appendData($text);
        $htmlTableData->appendChild($htmlText);
        $this->children->append($htmlTableData);
        
        return $htmlTableData;
    }
}

