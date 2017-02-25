<?php
session_start();

/**
 * THE EASYMB LIGHT INIT WEBSITE
 *
 * Use this code for a initial easyBM Setup 
 *
 * @file       /var/www/html/init.php
 * @author     DL5RFK <easybm@dl5rfk.org>
 * @review     DJ2RF <fritz@dj2rf.de>
 * @copyright  2017 The German BrandMeister Team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3
 * @version    2017-02-14
 * @remarks    WITHOUT ANY WARRANTY OR GUARANTEE
 * @see        http://www.bm262.de
 *
 */


//EDIT THIS PATH
$MMDVMINI='/opt/MMDVMHost/MMDVM.ini';
$WPACONFIG='/etc/wpa_supplicant/wpa_supplicant.conf';

/* ********** DO NOT CHANGE BELOW ********** */

//INCLUDES DG9VH STUFF
//include_once("MMDVMHost-Dashboard/config/config.php");
//include_once("MMDVMHost-Dashboard/include/tools.php");


//DEFINE SOME FUNCTIONS
function check_callsign($callsign){
  return preg_match('=^\d?[a-z]{1,2}\d{1,4}[a-z]{1,3}$=i', $callsign);
}

function command_exist($cmd) {
    $returnVal = shell_exec("which $cmd");
    return (empty($returnVal) ? false : true);
}

function getparams($iniF,$toSearch) {
	$inifileparams = file_get_contents($iniF);
	preg_match ('(^'.$toSearch.'=.*)m', $inifileparams, $SearchA);
	$SearchA = preg_replace('(^'.$toSearch.'=)m',"", $SearchA);
	$StrRet=$SearchA[0];
	return($StrRet); 
}

function readini($filename, $section, $var) {
	$array = parse_ini_file($filename, true);
	return $array[$section][$var];
}

function writeini($filename, $section, $var, $Wert) {
	$array = parse_ini_file($filename, true);
	$array[$section][$var] = strval($Wert);
	return $array;
}

function stopservice()   {
	exec('/bin/sleep 3 && sudo systemctl stop mmdvmhost.service > /dev/null 2>&1');
}

#===================================================================================================
function ini_write($_data, $filename, $maxdepth=3)
{
	 //stopservice();
	 	
 	 $fp = @fopen($filename, 'rb+');
   ### Datei zum Lesen und Schreiben sperren ###
    if (!flock($fp, LOCK_EX))
    {
        echo htmlspecialchars(print_r(error_get_last(),1)) . "\r\n";
        exit;
    }

    #--private Funktion -------------------------------------------------------------------------
    $writeparams = function ($_values, $arraykey, $depth) use ($fp, $maxdepth, &$writeparams)
    {
	foreach ($_values as $key => $param)
	{
            if ($depth >= 1)
	    {
		$arraykeytxt = $arraykey . "[$key]";
	    }	
	    else
	    {   
		$arraykeytxt = $key;
	    }
 
	    if (is_array($param))
	    {
		$depth++;
		if ($depth < $maxdepth)
		{
	            if (false === $writeparams ($param, $arraykeytxt, $depth)) return false;
		}	
	    }
	    else
	    {
		if (false === @fwrite ($fp, "$arraykeytxt=$param" . PHP_EOL)) return false;	
	    }
	}
 
	return true;
    };
    #------------------------------------------------------------------------------------------

    if ( 0 !== @fseek($fp, 0, SEEK_SET)) return false;
    if (false === @fwrite ($fp, ';### ' . basename($filename) . ' ### ' . 
        date('Y-m-d H:i:s') . ' ### utf-8 ### ÄÖÜäöü' . PHP_EOL . PHP_EOL)) return false;
 
    $depth = 0;
    $arraykey = '';
 
    foreach ($_data as $section => $_value)
    {
	if (is_array($_value))
	{
            if (false === @fwrite ($fp, PHP_EOL . "[$section]" . PHP_EOL)) return false;
 
            if ($depth < $maxdepth) 
            {
	    	$writeparams ($_value, $section, $depth); 
	    }
	}	
	else
        {
            if (false === @fwrite ($fp, "$section = $_value" . PHP_EOL)) return false;	
        }		
    }
 
    if (false === ($len = @ftell($fp))) return false;
    if (false === @ftruncate($fp, $len)) return false;
    
    fclose($fp);
 
    return true;
}

function geo_location()
    {
       
    $externalContent = file_get_contents('http://checkip.dyndns.com/');
	 preg_match('/\b(?:\d{1,3}\.){3}\d{1,3}\b/', $externalContent, $m);
    $externalIp = $m[0];
   
    $location = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$externalIp));
    
    //print $externalIp;
         
    return $location;
    }

 
#===================================================================================================

//THE RESTART THING
if (isset($_GET['function'])){ $function=$_GET['function']; } else { $function="nofunction"; }
 if ($function=='restart'){
	echo '<div class="alert alert-danger">Service is restarted, <strong>Press button Home!</strong> </div>';
	exec('/bin/sleep 3 && sudo systemctl restart mmdvmhost.service > /dev/null 2>&1');
	echo '<div window.location.href=\'/init.php\' </div>';
 }
 

function restart() {
   echo '<div class="alert alert-danger">Service is restarting, now! </div>';
	exec('/bin/sleep 3 && sudo systemctl restart mmdvmhost.service > /dev/null 2>&1');
}



?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <title>easyBM LIGHT</title>
  </head>
  <body>
<br />
<br />
<br />

<div class="container">
    <div class="jumbotron">
    <div align="center"><img alt="" border="0" src="ebm.jpg" width="300" height="auto"></div>
      <h2>easyBM <small>initalize your DVMega System</small></h2>
      <p><small>Enter some data, and your are ready to go for the digital ham radio network</small> <strong>BrandMeister</strong>.<a href="#" class="" data-toggle="modal" data-target="#myModal"> <small>(Show MMDVM.ini)</small></a></p>
		  	<button onclick="window.location.href='./MMDVMHost-Dashboard/index.php'"  type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;Home</button>
  			<button onclick="window.location.href='./MMDVMHost-Dashboard/scripts/rebootmmdvm.php'"  type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>&nbsp;Reboot MMDVMHost</button>
  			<button onclick="window.location.href='./MMDVMHost-Dashboard/scripts/reboot.php'"  type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>&nbsp;Reboot System</button>
  			<button onclick="window.location.href='./MMDVMHost-Dashboard/scripts/halt.php'"  type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-off" aria-hidden="true"></span>&nbsp;ShutDown System</button>
         
<!-- Show Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Content of MMDVM.ini</h4>
      </div>
      <div class="modal-body">
      <?php echo '<pre>'; echo file_get_contents($MMDVMINI); echo '</pre>'; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php


if (isset($_POST['submited']) && $_POST['submited'] == true) {
	//ALLOW REBOOT	
	$reboot="YES";
   	
	//CHECK INPUT VALUES
	$callsign = ( $_POST['callsign'] ? $_POST['callsign'] : 'N0CALL');
	if (!check_callsign($callsign)){ echo '<div class="alert alert-danger">You have to enter a valid Hamradio Callsign !</div>'; $reboot="NO"; }
	
	$id = ( $_POST['id'] ? $_POST['id'] : 'NoDMRID');
	if (!is_numeric($id)){ echo '<div class="alert alert-danger">You have to enter a valid DMR ID, like 2621234 !</div>'; $reboot="NO"; }

	$location = ( $_POST['location'] ? $_POST['location'] : 'Ham Town');
	$url = ( $_POST['url'] ? $_POST['url'] : 'https://www.qrz.com/db/'.$callsgin);

	$fixedstring = '/^\[easyBM\]/';
	if (isset($_POST['description'])) {
		if (preg_match($fixedstring, $_POST['description'])){
			$description=$_POST['description']; } else { $description='[easyBM] '.$_POST['description']; }
 	} else { 
		$description ='[easyBM] Hotspot by '.$callsign; 
		}
	
	$serveraddress = ( $_POST['serveraddress'] ? $_POST['serveraddress'] : 'master.up4dar.de');
	$serverport = ( $_POST['serverport'] ? $_POST['serverport'] : '62031');
	$serverpassword = ( $_POST['serverpassword'] ? $_POST['serverpassword'] : 'passw0rd');
	$ssid = ( $_POST['ssid'] ? $_POST['ssid'] : 'Dummy');
	$psk = ( $_POST['psk'] ? $_POST['psk'] : 'DummyKey');
	$rxfrequency = ( $_POST['rxfrequency'] ? $_POST['rxfrequency'] : '433612500');
	$txfrequency = ( $_POST['txfrequency'] ? $_POST['txfrequency'] : '433612500');
	
	
		$Latitude = ( $_POST['Latitude'] ? $_POST['Latitude'] : '0.0');
		$Longitude = ( $_POST['Longitude'] ? $_POST['Longitude'] : '0.0');
	
	if (isset($_POST["autogeo"])) {
  		$geoA = geo_location();
		$Latitude=$geoA['geoplugin_latitude'];
   	$Longitude=$geoA['geoplugin_longitude'];
	}
	else {
  		$autogeo=false;
	}	
	
	$dmrtxlevel = ( $_POST['dmrtxlevel'] ? $_POST['dmrtxlevel'] : '50');
	

	$callsign=trim($callsign);
	$id=( is_numeric($id) ? trim($id) : '0000000' );
	$location=trim($location);
	//$url=str_replace("/","\/",trim($url));
	$url=trim($url);
	$description=trim($description);
	$serveraddress=trim($serveraddress);
	$serverport=( is_numeric($serverport) ? trim($serverport) : '62031' );
	$serverpassword=trim($serverpassword);
	$ssid=trim($ssid);
	$psk=trim($psk);
	$rxfrequency=trim($rxfrequency);
	$txfrequency=trim($txfrequency); 
	$dmrtxlevel=trim($dmrtxlevel);
	// Plausi Prüfung frequenz und TX Power
	if ((strlen($rxfrequency) != 9 ) || (strpos ($rxfrequency,',') != false) || (strpos ($rxfrequency,'.') != false)){
		$rxfrequency="433612500";
	}
	if ((strlen($txfrequency) != 9 ) || (strpos ($txfrequency,',') != false) || (strpos ($txfrequency,'.') != false)){
		$txfrequency="433612500";
	}
	if ((intval ($dmrtxlevel) > 100 ) || (intval  ($dmrtxlevel) <= 0)){
		$dmrtxlevel="50";
	}

	//REPLACE THE CONTENT IN MMDVM.INI	
	//$RXFrequency="433612500";
	//$TXFrequency="433612500";
	
	
	$Warr = writeini($MMDVMINI,"DMR","Id",strval($id));
	if (ini_write($Warr, $MMDVMINI, $maxdepth=3) != true) { echo htmlspecialchars(print_r(error_get_last(),1)) . "\r\n"; exit; }
	$Warr = writeini($MMDVMINI,"Info","Location",$location);
	if (ini_write($Warr, $MMDVMINI, $maxdepth=3) != true) { echo htmlspecialchars(print_r(error_get_last(),1)) . "\r\n"; exit; }

	$Warr = writeini($MMDVMINI,"Info","Latitude",$Latitude);
	if (ini_write($Warr, $MMDVMINI, $maxdepth=3) != true) {echo htmlspecialchars(print_r(error_get_last(),1)) . "\r\n"; exit; }
	$Warr = writeini($MMDVMINI,"Info","Longitude",$Longitude);
	if (ini_write($Warr, $MMDVMINI, $maxdepth=3) != true) {echo htmlspecialchars(print_r(error_get_last(),1)) . "\r\n"; exit; }


	$Warr = writeini($MMDVMINI,"Info","URL",$url);
	if (ini_write($Warr, $MMDVMINI, $maxdepth=3) != true) {echo htmlspecialchars(print_r(error_get_last(),1)) . "\r\n"; exit; }
	$Warr = writeini($MMDVMINI,"Info","Description",$description);
	if (ini_write($Warr, $MMDVMINI, $maxdepth=3) != true) { echo htmlspecialchars(print_r(error_get_last(),1)) . "\r\n"; exit; }
	$Warr = writeini($MMDVMINI,"DMR Network","Address",$serveraddress);
	if (ini_write($Warr, $MMDVMINI, $maxdepth=3) != true) {echo htmlspecialchars(print_r(error_get_last(),1)) . "\r\n"; exit; }
	$Warr = writeini($MMDVMINI,"DMR Network","Port",$serverport);
	if (ini_write($Warr, $MMDVMINI, $maxdepth=3) != true) { echo htmlspecialchars(print_r(error_get_last(),1)) . "\r\n"; exit; }
	$Warr = writeini($MMDVMINI,"DMR Network","Password",$serverpassword);
	if (ini_write($Warr, $MMDVMINI, $maxdepth=3) != true) { echo htmlspecialchars(print_r(error_get_last(),1)) . "\r\n"; exit;}	
	$Warr = writeini($MMDVMINI,"Info","RXFrequency",$rxfrequency);
	if (ini_write($Warr, $MMDVMINI, $maxdepth=3) != true) { echo htmlspecialchars(print_r(error_get_last(),1)) . "\r\n"; exit; }
	$Warr = writeini($MMDVMINI,"Info","TXFrequency",$txfrequency);
	if (ini_write($Warr, $MMDVMINI, $maxdepth=3) != true) { echo htmlspecialchars(print_r(error_get_last(),1)) . "\r\n"; exit; }
	$Warr = writeini($MMDVMINI,"General","Callsign",$callsign);
	if (ini_write($Warr, $MMDVMINI, $maxdepth=3) != true) { echo htmlspecialchars(print_r(error_get_last(),1)) . "\r\n"; exit; }
	$Warr = writeini($MMDVMINI,"Modem","DMRTXLevel",$dmrtxlevel);
	if (ini_write($Warr, $MMDVMINI, $maxdepth=3) != true) { echo htmlspecialchars(print_r(error_get_last(),1)) . "\r\n"; exit; }	
	
	// None are deleted by read the ini file. Thats a workaround
	// to Do check why None is deleted after read 
	$Warr = writeini($MMDVMINI,"General","Display","None");
	if (ini_write($Warr, $MMDVMINI, $maxdepth=3) != true) { echo htmlspecialchars(print_r(error_get_last(),1)) . "\r\n"; exit; }	
	//***************************************************************************************************************************
	
	
	//DO THE WIFI CONFIGURATION
	//UPS
	if( strcmp ( $ssid,"Dummy") != 0) {
		system('sudo sed -i -e \'s/psk=.*/psk="'.$psk.'"/g\' /etc/wpa_supplicant/wpa_supplicant.conf',$returncode);
		system('sudo sed -i -e \'s/ssid=.*/ssid="'.$ssid.'"/g\' /etc/wpa_supplicant/wpa_supplicant.conf',$returncode);
	}
	echo '<pre>';
	//system('sudo wpa_cli list_networks',$returncode);
	//system('sudo wpa_cli set_network 0 ssid "'.$ssid.'"',$returncode);
	//system('sudo wpa_cli set_network 0 key_mgmt WPA-PSK', $returncode);
	//system('sudo wpa_cli set_network 0 psk "'.$psk.'"', $returncode);
	//system('sudo wpa_cli enable_network 0', $returncode);
	//system('sudo wpa_cli set update_config 1', $returncode);
	//system('sudo wpa_cli save_config', $returncode);
	echo '</pre>';
	
	//DEBUG
	//echo "<pre>";
	//var_dump($inicontent);
	//echo "</pre>";
	
	?>
		<div class="row"><div class="col-md-8 col-md-offset-2">

	<?php  if ( $reboot== "YES") : ?>
		<div class="alert alert-danger">
		<button onclick="window.location.href='/init.php?function=restart'" type="button" class="btn btn-danger"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>&nbsp;Restart Service</button>&nbsp; Restart!! For WLAN changes, Press Reboot Button !		 
		</div>
		<?php exec('sudo rm -f /var/www/html/UNCONFIGURED'); ?>
	<?php else: ?>
		<center><a href="/init.php" class="btn btn-warning">Sorry, please try again !</a></center><br />
	<?php endif; ?>

		<div class="list-group">
		<a href="#" class="list-group-item active">Your DVMega System settings for BrandMeister:</a>
		<a href="#" class="list-group-item">Configuration File at &nbsp;<?php echo $MMDVMINI;?></a>
		<a href="#" class="list-group-item"><?php print readini($MMDVMINI,"General","Callsign") ?>&nbsp;is your Callsign</a>
		<a href="#" class="list-group-item"><?php print readini($MMDVMINI,"DMR","Id") ?>&nbsp;is your DMR ID</a>
		<a href="#" class="list-group-item"><?php print readini($MMDVMINI,"Info","Location") ?>&nbsp;is your location</a>
		
		<a href="#" class="list-group-item"><?php print readini($MMDVMINI,"Info","Latitude") ?>&nbsp;is your Latitude</a>
		<a href="#" class="list-group-item"><?php print readini($MMDVMINI,"Info","Longitude") ?>&nbsp;is your Longitude</a>
		
		<a href="#" class="list-group-item"><?php print readini($MMDVMINI,"Info","URL") ?>&nbsp;is your website</a>
		<a href="#" class="list-group-item"><?php print readini($MMDVMINI,"Info","Description") ?>&nbsp; is your description</a>
		<a href="#" class="list-group-item"><?php print readini($MMDVMINI,"DMR Network","Address") ?> &nbsp; is your DMR Master</a>
		<a href="#" class="list-group-item"><?php print readini($MMDVMINI,"DMR Network","Password") ?>&nbsp; is the Password</a>
		<a href="#" class="list-group-item"><?php print readini($MMDVMINI,"Info","TXFrequency") ?>&nbsp; is your Hotspot TX frequency</a>
		<a href="#" class="list-group-item"><?php print readini($MMDVMINI,"Info","RXFrequency") ?>&nbsp; is your Hotspot RX frequency</a>
		<a href="#" class="list-group-item"><?php print readini($MMDVMINI,"Modem","DMRTXLevel").'%' ?>&nbsp; is your Hotspot DMR TX Level in %</a>
		</div>
		<p>We believe it makes sense if each hotspot using the same frequency. Therefore, this was set to 433.6125MHz.</p>
		<br />
		<p>Make a Donation, if you like.</p>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
		 <input type="hidden" name="cmd" value="_donations">
		 <input type="hidden" name="business" value="denis.bederov@gmx.de">
		 <input type="hidden" name="lc" value="EN">
		 <input type="hidden" name="item_name" value="BrandMeister">
	 	 <input type="hidden" name="no_note" value="0">
	 	 <input type="hidden" name="currency_code" value="EUR">
		 <input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
		 <input type="image" src="https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal Donation">
		 <img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
		</form>
		</div></div>

	<?php

	} else { ?>
       <form class="form-horizontal" action="" method="post">
       <br />
		<fieldset>
		<legend>MMDVM Configuration</legend>
		<div class="form-group">
		  <label class="col-md-4 control-label" for="callsign">Your Callsign</label>
		  <div class="col-md-4"> 
		  <input id="callsign" name="callsign" type="text" value="<?php print readini($MMDVMINI,"General","Callsign") ?>" placeholder="<?php print readini($MMDVMINI,"General","Callsign") ?>" class="form-control input-md" required="">
		  <span class="help-block">This is your own callsign.</span>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-md-4 control-label" for="id">Your DMR ID</label>
		  <div class="col-md-4">
		  <input id="id" name="id" type="text" value="<?php print readini($MMDVMINI,"DMR","Id") ?>" placeholder="<?php print readini($MMDVMINI,"DMR","Id") ?>" class="form-control input-md" required="">
		  <span class="help-block">This is your own DMR ID.</span>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-md-4 control-label" for="location">Your Location</label>
		  <div class="col-md-4">
		  <input id="location" name="location" maxlength="20" type="text" value="<?php print readini($MMDVMINI,"Info","Location") ?>" placeholder="<?php print readini($MMDVMINI,"Info","Location") ?>" class="form-control input-md" required="">
		  <span class="help-block">Let us know, where your are located.</span>
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="Latitude">Geo Latitude</label>
		  <div class="col-md-4">
		  <input id="Latitude" name="Latitude" maxlength="20" type="text" value="<?php print readini($MMDVMINI,"Info","Latitude") ?>" placeholder="<?php print readini($MMDVMINI,"Info","Latitude") ?>" class="form-control input-md" required="">
		  <span class="help-block">Tell us your Geo Latitude.<br />You can find help at:<br />https://www.laengengrad-breitengrad.de </span>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-md-4 control-label" for="Longitude">Geo Longitude</label>
		  <div class="col-md-4">
		  <input id="Longitude" name="Longitude" maxlength="20" type="text" value="<?php print readini($MMDVMINI,"Info","Longitude") ?>" placeholder="<?php print readini($MMDVMINI,"Info","Longitude") ?>" class="form-control input-md" required="">
		  <span class="help-block">Tell us your Geo Longitude.<br />You can find help at:<br />https://www.laengengrad-breitengrad.de</span>
		  </div>
		</div>		
		
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="autogeo">   </label>
		  <div class="col-md-4">
        <input type="checkbox" id="autogeo" value="false" name="autogeo"> <label for="autogeo">  We try to get your location +-50Km (Beta)</label><br>
		  <span class="help-block"></span>
		  </div>
		</div>
		
		
		
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="url">Your URL</label>
		  <div class="col-md-4">
		  <input id="url" name="url" maxlength="150" type="text" value="<?php print readini($MMDVMINI,"Info","URL") ?>" placeholder="<?php print readini($MMDVMINI,"Info","URL") ?>" class="form-control input-md" required="">
		  <span class="help-block">For example, your QRZ.com webpage.</span>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-md-4 control-label" for="description">Description</label>
		  <div class="col-md-4">
		  <input id="description" name="description" maxlength="40" type="text" value="<?php print readini($MMDVMINI,"Info","Description") ?>" placeholder="<?php print readini($MMDVMINI,"Info","Description") ?>" class="form-control input-md" required="">
		  <span class="help-block">A very short description about your system.</span>
		  </div>
		</div>
		
		
		<div class="form-group">
		  <label class="col-md-4 control-label" for="txfrequency">Your TX QRG</label>
		  <div class="col-md-4">
		  <input id="txfrequency" name="txfrequency" maxlength="124" type="text" value="<?php print readini($MMDVMINI,"Info","TXFrequency") ?>" placeholder="<?php print readini($MMDVMINI,"Info","TXFrequency") ?>" class="form-control input-md" required="">
		  <span class="help-block">For example, 433612500 <- prefered QRG.</span>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-md-4 control-label" for="rxfrequency">Your RX QRG</label>
		  <div class="col-md-4">
		  <input id="rxfrequency" name="rxfrequency" maxlength="20" type="text" value="<?php print readini($MMDVMINI,"Info","RXFrequency") ?>" placeholder="<?php print readini($MMDVMINI,"Info","RXFrequency") ?>" class="form-control input-md" required="">
		  <span class="help-block">For example, 433612500 <- prefered QRG.</span>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-md-4 control-label" for="dmrtxlevel">Your DMR TX Level in %</label>
		  <div class="col-md-4">
		  <input id="dmrtxlevel" name="dmrtxlevel" maxlength="20" type="text" value="<?php print readini($MMDVMINI,"Modem","DMRTXLevel") ?>" placeholder="<?php print readini($MMDVMINI,"Modem","DMRTXLevel") ?>" class="form-control input-md" required="">
		  <span class="help-block">TX Level from 1 to 100%.</span>
		  </div>
		</div>

		<legend>Optional Master Server Settings</legend>
		<div class="form-group">
                  <label class="col-md-4 control-label" for="serveraddress">Server Address</label>
                  <div class="col-md-4">
                  <input id="serveraddress" name="serveraddress" type="text" value="<?php print readini($MMDVMINI,"DMR Network","Address") ?>" placeholder="<?php print readini($MMDVMINI,"DMR Network","Address") ?>" class="form-control input-md">
                  <span class="help-block">The DMR Master server IP-Address or hostname.</span>
                  </div>
                </div>
		<div class="form-group">
                  <label class="col-md-4 control-label" for="serverport">Server Port</label>
                  <div class="col-md-4">
                  <input id="serverport" name="serverport" type="text" value="<?php print readini($MMDVMINI,"DMR Network","Port") ?>" placeholder="<?php print readini($MMDVMINI,"DMR Network","Port") ?>" class="form-control input-md">
                  <span class="help-block">The DMR Master server port.</span>
                  </div>
                </div>
		<div class="form-group">
                  <label class="col-md-4 control-label" for="serverpassword">Server Password</label>
                  <div class="col-md-4">
                  <input id="serverpassword" name="serverpassword" type="text" value="<?php print readini($MMDVMINI,"DMR Network","Password") ?>" placeholder="<?php print readini($MMDVMINI,"DMR Network","Password") ?>" class="form-control input-md">
                  <span class="help-block">The DMR Master server password.</span>
                  </div>
                </div>


		<?php 
			if (command_exist('wpa_cli')){	
			echo '<legend>Optional WiFi Client Settings</legend>';
			   exec('sudo wpa_cli scan',$return_code);
			echo '<h5>Scan Result</h5>';	
			  echo '<pre>';
			   system('sudo wpa_cli scan_result',$return_code);
			  echo '</pre>';
			echo '<h5>Network list</h5>';	
			  echo '<pre>';
		       	   system('sudo wpa_cli list_networks',$returncode);
			  echo '</pre>';
		?>		
			 <div class="form-group">
	                  <label class="col-md-4 control-label" for="ssid">SSID</label>
        	          <div class="col-md-4">
                	  <input id="ssid" name="ssid" type="text" placeholder="MyWiFi-Name" class="form-control input-md">
             		     <span class="help-block">The Name of your WiFi Network.</span>
               		  </div>
                	</div>
                	<div class="form-group">
                  	 <label class="col-md-4 control-label" for="psk">Shared Key</label>
                  	 <div class="col-md-4">
                  	 <input id="psk" name="psk" type="password" placeholder="secret" class="form-control input-md">
                  	 <span class="help-block">Your WPA pre-shared-key.</span>
                  	 </div>
                	</div>
		<?php
			} else { echo '<p>Sorry, no WiFi device found</p>'; }
		?>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="done">Everything done?</label>
		  &nbsp;&nbsp;<button type="submit" class="btn btn-success">Now, save and initalize ....</button>
		  <input name="submited" type="hidden" value="true">
	        </div>

		</form>
      </fieldset>

<?php } //EndOfElse ?>

<hr>
	<footer>
	 <small>For more informations, please have a look at the BrandMeister Webpage. (Version 2017-02-24, by BM-Team Germany)</small><br />
	 <small>Uptime for this host is <?php print(shell_exec('uptime')); ?></small>
	</footer>

    </div>
  </div>
 </div>
  
   </body>
</html>
