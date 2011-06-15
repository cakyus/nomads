<?php

class Nomads_Response {

	function redirect($Url) {
		header('Location: '.$Url);
		exit();
	}
}

