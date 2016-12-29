<?php 
/*
 * some functions,accessable from all pages
 *
 *
 */

//
function getSymbolByQuantity($bytes) {
                $symbol = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');
                $exp = floor(log($bytes)/log(1024));
                return sprintf('%.3f '.$symbol[$exp], ($bytes/pow(1024, floor($exp))));
}

//printout messages
function pleaseLogin() {
	echo '<p><div class="alert alert-danger" ><center><strong>Sorry, please login first !</strong></center></div></p>';
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

//load ini file into an array
function getMMDVMConfig() {
        // loads into array for further use
        $conf = array();
        $conf = parse_ini_file(MMDVMINIPATH."/".MMDVMINIFILENAME,TRUE);
        return $conf;
}

//load ini file into an array
function getIRCDDBGATEWAYConfig() {
        // loads ini into array for further use
        $conf = array();
        $conf = parse_ini_file(IRCDDBGATEWAYPATH."/".IRCDDBGATEWAYINIFILENAME,TRUE);
        return $conf;
}

//load ini file into an array
function getYSFGATEWAYConfig() {
        // loads ini into array for further use
        $conf = array();
        $conf = parse_ini_file(YSFHOSTSPATH."/".YSFGATEWAYINIFILENAME,TRUE);
        return $conf;
}


//if you load a ini, you have to write it back, not parse_ini_file
// usage:  put_ini_file(string $file, array $array)
function put_ini_file($file, $array, $i = 0){
  $str="";
  foreach ($array as $k => $v){
    if (is_array($v)){
      $str.=str_repeat(" ",$i*2)."[$k]".PHP_EOL; 
      $str.=put_ini_file("",$v, $i+1);
    }else
      $str.=str_repeat(" ",$i*2)."$k = $v".PHP_EOL; 
  }
if($file)
    return file_put_contents($file,$str);
  else
    return $str;
}

//
function isProcessRunning($processname) {
        exec("pgrep " . $processname, $pids);
        if(empty($pids)) {
                // process not running!
                return false;
        } else {
                // process running!
                return true;
        }
}

?>
