<?php

class htmlTableData extends htmlElement {
    
    public function __construct() {
        parent::__construct();
        $this->tagName = 'td';
    }
}

