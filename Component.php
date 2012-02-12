<?php

class Nomads_Component {

	public function __construct() {}
	
	public function setProperties($object) {
		foreach ($object as $name => $value) {
			$this->$name = $value;
		}	
	}
	
	public function __get($name) {
		$getter = "get".$name;
		if (method_exists($this, $getter)) {
			return $this->$getter();
		}
		throw new Nomads_Exception("Property '$name' is not defined");
	}

	public function __set($name, $value) {
		$setter = "set" . $name;
		if (method_exists($this, $setter)) {
			return $this->$setter($value);
		}

		if (method_exists($this, "get".$name)) {
			throw new CException("Property '$name' is read only.");
		} else {
			throw new CException("Property '$name' is not defined.");
		}
	}
}

