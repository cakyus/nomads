<?php

class response {
	
	public function redirect($url) {
		header('Location: '.$url);
	}
}