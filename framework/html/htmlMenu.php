<?php

class htmlMenu extends htmlElement {

    public function __construct() {
        parent::__construct();
        $this->tagName = 'div';
        $this->setAttribute('class',__CLASS__);
    }

    public function add($text, $url=null) {
        
        $htmlAnchor = new htmlAnchor;
        $htmlAnchor->text = $text;
        $htmlAnchor->url = $url;
        
        return $this->appendChild($htmlAnchor);
    }
    
    public function addLocalUrl(
        $text
        , $className
        , $functionName
        , $queries = null
        ) {
        
        $url = new url;
        $url->getLocalUrl($className, $functionName);
        if (is_null($queries) == false) {
            foreach ($queries as $name => $value) {
                $url->setQuery($name, $value);
            }
        }
        
        return $this->add($text, $url->getUrl());
    }

}

