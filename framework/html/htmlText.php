<?php

class htmlText {
    
    public $text;
    
    public function __construct() {
        $this->text = '';
    }

    public function appendData($string) {
        $this->text .= $string;
    }
    
    public function __toString() {
        return $this->text;
    }

}

