<?php

class developerController {

	public function index() {
		
		$url = new url;
		$response = new response;
		
		$url->getLocalUrl('developerDatabase','index');
		$response->redirect($url->getUrl());
		
	}
}
