<?php

class Nomads_Logger {
	
	//  Log an INFO message.
	public function info($message) {
		echo date('Y-m-d H:i:s ').$message."\n";
	}
}
