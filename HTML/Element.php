<?php

class Nomads_HTML_Element {
	
	public $id;
	public $tagName;
	public $attributes;
	public $attributesSpecial;
	public $childs;
	public $innerText;
	
	public function __construct() {
		
		//$text = new text;
		//$this->id = '_'.$text->newId();
		
		$this->id = '';
		$this->tagName = '';
		$this->attributes = array();
		$this->attributesSpecial = array(
			 'id'
			,'tagName'
			,'attributes'
			,'childs'
			,'innerText'
			,'attributesSpecial'
			);
		$this->childs = array();
		$this->innerText = '';
	}
	
	public function appendChild($htmlElement) {
		$this->childs[] = $htmlElement;
	}
	
	public function getChilds() {
		return $this->childs;		
	}
	
	public function getAttribute($name) {
		if (isset($this->attributes[$name])) {
			return $this->attributes[$name];
		}
		return false;
	}
	
	public function setAttribute($name, $value) {
		$this->attributes[$name] = $value;
	}
	
	public function __toString() {
		
		if (empty($this->tagName)) {
			trigger_error('$tagName should not has empty value');
			return '';
		}
		
		$output = '<'.$this->tagName;
		
		// attributes
		foreach ($this as $keyword => $property) {
			if (in_array($keyword, $this->attributesSpecial)) {
				// do nothing
			} else {
				if (empty($property)) {
					// do nothing
				} elseif (is_string($property)) {
					$output .= ' '.$keyword.'="'.htmlentities($property).'"';
				} else {
					trigger_error(
						 '$property should be string.'
						.' "'.$this->tagName.'"'
						.'."'.$keyword.'"'
						);
				}
			}
		}
		
		// childs
		$innerHtml = $this->innerText;
		
		foreach ($this->childs as $child) {
			$innerHtml .= $child;
		}
		
		if (empty($innerHtml)) {
			$output .= ' />';
		} else {
			$output .= '>'.$innerHtml.'</'.$this->tagName.'>';
		}
		
		return $output;
	}
}

