<?php

class videoController {

	public function index() {
		echo '<html><head><title>HTML5 Video</title></head>'
			.'<body bgcolor="#000" topmargin=50><center>'
			.'<video id="video_1" controls loop autoplay>'
			.'<source src="'.$_GET['videoUrl'].'"  type="video/ogg"  />'
			.'This is fallback text to display if the browser does not support the video element.'
			.'</video>'
			.'<script language=\'javascript\'>'
				.'document.getElementById(\'video_1\')'
				.'.addEventListener(\'ended\', function(){'
				.'this.currentTime = 0;'
				.'}, false);'
				.'</script>'
			.'</center></body></html>'
			;	
	}
}