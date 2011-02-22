<?php

class homeController {
	function index() {
		echo '<html><head><title>Welcome</title></head><body>'
			.'<h1>It Work\'s !</h1>'
			.'You can now :'
			.'<ul>'
			.'<li>Read <a href="index.php?c=documentation">documentation</a></li>'
			.'<li>Use <a href="index.php?c=developer">developer tools</a></li>'
			.'</ul>'
			.'</body></html>'
			;
	}
}

