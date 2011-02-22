<?php

class htmlTableRowCollection extends htmlElement {
    
    public function __construct() {
        parent::__construct();
        $this->tagName = 'tbody';
    }

    public function add() {
        
        $htmlTableRow = new htmlTableRow;
        $this->children->append($htmlTableRow);
        
        return $htmlTableRow;
    }
}

