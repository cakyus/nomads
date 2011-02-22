<?php

class databaseSchemaIndex {
    
    public $name;
    public $unique;
    public $columns;
    
    public function __construct() {
        $this->columns = new collection;
    }
}

