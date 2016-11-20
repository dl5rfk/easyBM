<?php
session_start();

/**
 * THE EASYMB LITE INIT WEBSITE
 *
 * Use this code for a initial easyBM Setup 
 *
 * @file       /var/www/html/init.php
 * @author     DL5RFK <easybm@dl5rfk.org>
 * @copyright  2016 The German BrandMeister Team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3
 * @version    2016-08-10
 * @remarks    WITHOUT ANY WARRANTY OR GUARANTEE
 * @see        http://www.bm262.de
 *
 */


//EDIT THIS PATH
$MMDVMINI='/opt/MMDVMHost/MMDVM.ini';
$WPACONFIG='/etc/wpa_supplicant/wpa_supplicant.conf';
$IRCDDBCFG='/etc/ircddbgateway';



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



//THE REBOOT THING
if (isset($_GET['function'])){ $function=$_GET['function']; } else { $function="nofunction"; }
 if ($function=='reboot'){
	echo '<div class="alert alert-danger">System is going down for reboot, now! </div>';
	exec('/bin/sleep 3 && sudo /sbin/reboot > /dev/null 2>&1');
 }

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <title>easyBM LIGHT</title>
  </head>
  <body>
<br />
<br />
<br />
<div class="container">
    <div class="jumbotron">
      <h1>easyBM <small>initalize your DVMega System</small></h1>
      <p>Enter some data, and your are ready to go for the digital ham radio network <strong>BrandMeister</strong>.<a href="#" class="" data-toggle="modal" data-target="#myModal"> <small>(Show MMDVM.ini)</small> </a></p>
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

	//REPLACE THE CONTENT IN MMDVM.INI	
	$inicontent = file_get_contents($MMDVMINI);
	$inicontent = preg_replace('(^Callsign=.*)m',"Callsign=$callsign", $inicontent);
	$inicontent = preg_replace('(^Id=.*)m',"Id=$id", $inicontent);
	$inicontent = preg_replace('(^Location=.*)m',"Location=$location", $inicontent);
	$inicontent = preg_replace('(^URL=.*)m',"URL=$url", $inicontent);
	$inicontent = preg_replace('(^Description=.*)m',"Description=$description", $inicontent);
	$inicontent = preg_replace('(^Address=.*)m',"Address=$serveraddress", $inicontent);
	//$inicontent = preg_replace('/(^Port=.*)m',"Port=$serverport", $inicontent); //Problem, found Port= a serveral times
	$inicontent = preg_replace('(^Password=.*)m',"Password=$serverpassword", $inicontent);
	//Fixed QRG
	$inicontent = preg_replace('(^TXFrequency=.*)m',"TXFrequency=433612500", $inicontent);
	$inicontent = preg_replace('(^RXFrequency=.*)m',"RXFrequency=433612500", $inicontent);


	//WRITE CONTENT INTO FILE MMDVM.INI	
	if (is_writable($MMDVMINI) && isset($inicontent) ) {
                $fh = fopen($MMDVMINI, 'w');
                fwrite($fh,$inicontent);
                fwrite($fh,"\n");
                fclose($fh);
	} else { echo '<div class="alert alert-danger">Sorry, /opt/MMDVMHost/MMDVM.ini is not writeable !</div>'; }

	//REPLACE THE CONTENT OF IRCDDBGATEWAY
	$irccontent = file_get_contents($IRCDDBCFG); 
	$irccontent = preg_replace('(^gatewayCallsign=.*)m',"gatewayCallsign=$callsign", $irccontent);
	$irccontent = preg_replace('(^description1=.*)m',"description1=[easyBM]", $irccontent);
	$irccontent = preg_replace('(^description2=.*)m',"description2=$description", $irccontent);
	$irccontent = preg_replace('(php?call=.*)m',"php\?call=$callsign", $irccontent);
	$irccontent = preg_replace('(^frequency1=.*)m',"frequency1=433.6125", $irccontent);
	$irccontent = preg_replace('(^frequency1=.*)m',"frequency1=433.6125", $irccontent);
	$irccontent = preg_replace('(^ircddbUsername=.*)m',"ircddbUsername=$callsign", $irccontent);
	$irccontent = preg_replace('(^dplusLogin=.*)m',"dplusLogin=$callsign", $irccontent);

	//WRITE CONTENT INTO FILE IRCDDBGATEWAY
        if (is_writable($IRCDDBCFG) && isset($irccontent) ) {
                $fh = fopen($IRCDDBCFG, 'w');
                fwrite($fh,$irccontent);
                fwrite($fh,"\n");
                fclose($fh);
        } else { echo '<div class="alert alert-danger">Sorry, /etc/ircddbgateway is not writeable !</div>'; }	
	
	
	//DO THE WIFI CONFIGURATION
	//UPS
	system('sudo sed -i -e \'s/psk=.*/psk="'.$psk.'"/g\' /etc/wpa_supplicant/wpa_supplicant.conf',$returncode);
	system('sudo sed -i -e \'s/ssid=.*/ssid="'.$ssid.'"/g\' /etc/wpa_supplicant/wpa_supplicant.conf',$returncode);
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
		 <button onclick="window.location.href='/init.php?function=reboot'" type="button" class="btn btn-danger"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>&nbsp;Perform a system reboot </button>&nbsp;To activate the changes, please restart your new easyBM Hotspot!
        <!-- <button onclick="window.location.href='/MMDVMHost-Dashboard/scripts/reboot.php'" type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>&nbsp;Reboot your system, now!</button> -->

		</div>
		<?php exec('sudo rm -f /var/www/html/UNCONFIGURED'); ?>

	<?php else: ?>
		<center><a href="/init.php" class="btn btn-warning">Sorry, please try again !</a></center><br />
	<?php endif; ?>

		<div class="list-group">
		<a href="#" class="list-group-item active">Your DVMega System settings:</a>
		<a href="#" class="list-group-item">Configuration File at &nbsp;<?php echo $MMDVMINI;?></a>
		<a href="#" class="list-group-item"><?php echo explode('=',exec("/bin/sed -n '/^Callsign=.*$/p' $MMDVMINI " ))[1]; ?>&nbsp;is your Callsign</a>
		<a href="#" class="list-group-item"><?php echo explode('=',exec("/bin/sed -n '/^Id=.*$/p' $MMDVMINI " ))[1]; ?>&nbsp;is your DMR ID</a>
		<a href="#" class="list-group-item"><?php echo explode('=',exec("/bin/sed -n '/^Location=.*$/p' $MMDVMINI " ))[1]; ?>&nbsp;is your location</a>
		<a href="#" class="list-group-item"><?php echo explode('=',exec("/bin/sed -n '/^URL=.*$/p' $MMDVMINI " ))[1]; ?>&nbsp;is your website</a>
		<a href="#" class="list-group-item"><?php echo explode('=',exec("/bin/sed -n '/^Description=.*$/p' $MMDVMINI " ))[1]; ?>&nbsp; is your description</a>
		<a href="#" class="list-group-item"><?php echo explode('=',exec("/bin/sed -n '/^Address=.*$/p' $MMDVMINI " ))[1]; ?>&nbsp; is your DMR Master Server</a>
		<a href="#" class="list-group-item"><?php echo explode('=',exec("/bin/sed -n '/^Password=.*$/p' $MMDVMINI " ))[1]; ?>&nbsp; is the Password</a>
		<a href="#" class="list-group-item"><?php echo explode('=',exec("/bin/sed -n '/^TXFrequency=.*$/p' $MMDVMINI " ))[1]; ?>&nbsp; is your Hotspot frequency</a>
		<a href="#" class="list-group-item"><?php echo explode('=',exec("/bin/sed -n '/^gatewayCallsign=.*$/p' $IRCDDBCFG " ))[1]; ?>_G &nbsp; is your D-Star Gateway Callsign</a>
		<a href="<?php echo explode('=',exec("/bin/sed -n '/^url=.*$/p' $IRCDDBCFG " ))[1]; ?>" class="list-group-item" target="_blank">&nbsp; Check your ircddb Status</a>
		</div>
		<p>We believe it makes sense if each hotspot using the same frequency. Therefore, this was set to 433.6125MHz.</p>
		<br />

		<p class="text-center text-muted">Thank´s for using easyBM, it is a BrandMeister Germany Project. Please make a Donation, if you would like.</p>
		<center>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
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
		</center>
		</div></div>

	<?php

	} else { ?>

   	 <form class="form-horizontal" action="" method="post">
		<fieldset>

		<legend>MMDVM Configuration</legend>
		<div class="form-group">
		  <label class="col-md-4 control-label" for="callsign">Your Callsign</label>
		  <div class="col-md-4">
		  <input id="callsign" name="callsign" type="text" placeholder="DL0ABC" class="form-control input-md" required="">
		  <span class="help-block">This is your own callsign.</span>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-md-4 control-label" for="id">Your DMR ID</label>
		  <div class="col-md-4">
		  <input id="id" name="id" type="text" placeholder="2621234" class="form-control input-md" required="">
		  <span class="help-block">This is your own DMR ID.</span>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-md-4 control-label" for="location">Your Location</label>
		  <div class="col-md-4">
		  <input id="location" name="location" maxlength="20" type="text" placeholder="HamTown" class="form-control input-md" required="">
		  <span class="help-block">Let us know, where your are located.</span>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-md-4 control-label" for="url">Your URL</label>
		  <div class="col-md-4">
		  <input id="url" name="url" maxlength="124" type="text" placeholder="https://www.qrz.com/db/callsign" class="form-control input-md" required="">
		  <span class="help-block">For example, your QRZ.com webpage.</span>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-md-4 control-label" for="description">Description</label>
		  <div class="col-md-4">
		  <input id="description" name="description" maxlength="20" type="text" placeholder="[easyBM] Hotspot" class="form-control input-md" required="">
		  <span class="help-block">A very short description about your system.</span>
		  </div>
		</div>

		<legend>Optional Master Server Settings</legend>
		<div class="form-group">
                  <label class="col-md-4 control-label" for="serveraddress">Server Address</label>
                  <div class="col-md-4">
                  <input id="serveraddress" name="serveraddress" type="text" value="master.up4dar.de" class="form-control input-md">
                  <span class="help-block">The DMR Master server IP-Address or hostname.</span>
                  </div>
                </div>
		<div class="form-group">
                  <label class="col-md-4 control-label" for="serverport">Server Port</label>
                  <div class="col-md-4">
                  <input id="serverport" name="serverport" type="text" value="62031" class="form-control input-md">
                  <span class="help-block">The DMR Master server port.</span>
                  </div>
                </div>
		<div class="form-group">
                  <label class="col-md-4 control-label" for="serverpassword">Server Password</label>
                  <div class="col-md-4">
                  <input id="serverpassword" name="serverpassword" type="text" value="passw0rd" class="form-control input-md">
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
	 <small>For more informations, please have a look at the BrandMeister Webpage. (Version 2016-08-10, by BM-Team Germany)</small><br />
	 <small>Uptime for this host is <?php print(shell_exec('uptime')); ?></small>
	</footer>

    </div>
  </div>
 </div>
  
   </body>
</html>
