<?php

class Nomads_GZip {
    
    /**
     * Uncompress a compressed string
     **/

    public function uncompress($string) {
        
        // generate random file name in temporary folder
        $text = new Nomads_Text;
        $file = sys_get_temp_dir().'/php_'.$text->getUUID();
        
        // writing file content
        $fp = fopen($file, 'w');
        fwrite($fp, $string);
        fclose($fp);
        
        // decompressing
		$zp = gzopen($file, "r");
		$b = '';
		while (!gzeof($zp)) {
			$b .= gzread($zp, 4096);
		}
		gzclose($zp);
		
        // delete temporary file
        unlink($file);
        
		return $b;
    }

}

