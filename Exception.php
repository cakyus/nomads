<?php

class Nomads_Exception extends Exception {

    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Exception $previous = null) {
        // some code
    
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
        echo $this->__toString();
    }

    // custom string representation of object
    public function __toString() {
        return "<html>
	<head>
		<title>Error</title>
	</head>
	<body>
		<h1>Error</h1>
		{$this->file} ({$this->line}): {$this->message}
		<pre>{$this->getTraceAsString()}</pre>
	</body>
</html>
";
    }
}

