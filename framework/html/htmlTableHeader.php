<?php

class htmlTableHeader extends htmlElement {
    
    public function __construct() {
        parent::__construct();
        $this->tagName = 'th';
    }
}

