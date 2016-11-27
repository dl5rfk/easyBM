<?php 


//
function getSymbolByQuantity($bytes) {
                $symbol = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');
                $exp = floor(log($bytes)/log(1024));
                return sprintf('%.3f '.$symbol[$exp], ($bytes/pow(1024, floor($exp))));
}

//
function pleaseLogin() {
	echo '<div class="alert alert-danger" ><center><strong>Sorry, please login first !</strong></center></div>';
}

//
function json_decode_nice($json, $assoc = FALSE){
    $json = str_replace(array("\n","\r"),"",$json);
    $json = preg_replace('/([{,]+)(\s*)([^"]+?)\s*:/','$1"$3":',$json);
    $json = preg_replace('/(,)\s*}$/','}',$json);
    return json_decode($json,$assoc);
}


//CREATE INITITAL PASSWORD STRING
function getInitialPassword($length) {
   //Mögliche Zeichen für den String
   $zeichen = '0123456789';
   $zeichen .= 'abcdefghijklmnopqrstuvwxyz';
   $zeichen .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $zeichen .= '!.:=';

   //String wird generiert
   $str = '';
   $anz = strlen($zeichen);
   for ($i=0; $i<$length; $i++) {
      $str .= $zeichen[rand(0,$anz-1)];
   }
   return $str;
}

/*
function is_loggedin(){
   if (isset($_SESSION('angemeldet')) && $_SESSION['angemeldet'] === TRUE){
    return TRUE;
   } else {  
	    return FALSE;
	  } 
	
}
*/

function getMMDVMConfig() {
        // loads into array for further use
        $conf = array();
        $conf = parse_ini_file(MMDVMINIPATH."/".MMDVMINIFILENAME,TRUE);
        /*
        if ($configs = fopen(MMDVMINIPATH."/".MMDVMINIFILENAME, 'r')) {	
                while ($config = fgets($configs)) {
                        array_push($conf, trim ( $config, " \t\n\r\0\x0B"));
                }
                fclose($configs);
        }
        */
        return $conf;
}

function getIRCDDBGATEWAYConfig() {
        // loads ini into array for further use
        $conf = array();
        $conf = parse_ini_file(IRCDDBGATEWAYPATH."/".IRCDDBGATEWAYINIFILENAME,TRUE);
        return $conf;
}

function getYSFGATEWAYConfig() {
        // loads ini into array for further use
        $conf = array();
        $conf = parse_ini_file(YSFHOSTSPATH."/".YSFGATEWAYINIFILENAME,TRUE);
        return $conf;
}

?>
