<?php
/**
 * THE EASYMB WEB CONTROL
 *
 * Use this code for a easyBM Setup
 *
 * @file       /var/www/html/admin/index.php
 * @author     DL5RFK <easybm@dl5rfk.org>
 * @copyright  2016 The German BrandMeister Team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3
 * @version    2016-09-30
 * @remarks    WITHOUT ANY WARRANTY OR GUARANTEE
 * @see        http://www.bm262.de
 *
 */

include_once("inc.header.php");
if (isset($_SESSION['angemeldet'])){

?>


  <div class="container">
    <div class="jumbotron">
      <h1>easyBM <small>under contruction</small></h1>


<?php

  $submask = exec("ifconfig eth0 | grep inet", $out);
    $submask = str_ireplace("inet addr:", "", $submask);
    $submask = str_ireplace("Mask:", "", $submask);
    $submask = trim($submask);
    $submask = explode(" ", $submask);
   $ip_adress=$submask[0];
   $mask=$submask[4];
   
   $gatewayType = shell_exec("route -n");
   $gatewayTypeRaw = explode(" ", $gatewayType);
   $gateway=$gatewayTypeRaw[42];
   
   $dnsType = file('/etc/resolv.conf');
   $dnsType = str_ireplace("nameserver ", "", $dnsType);
   $dns1 = $dnsType[2];
   $dns2 = $dnsType[3];
   $dns3 = $dnsType[4];

   $hostname = GETHOSTNAME();

	echo $submask;
	echo $ip_adress;
	echo $mask;
	echo $gateway;
	echo $dns1;
	echo $dns2;
	echo $dns3;
	echo $hostname;
?>
		
		<div class="row"><div class="col-md-6">
		<h2> List of Wifi Networks</h2>
		<?php
			$output = shell_exec('sudo nmcli device wifi list');
			echo "<pre>$output</pre>";
		?>
		</div><div class="col-md-6">
		<h2> Saved Wifi Connections </h2>
		<?php
			$output = shell_exec('sudo nmcli con show');
			echo "<pre>$output</pre>";
		?>
		</div></div>
		
		<h2> Add a new Wifi connection</h2>
		<form class="form-horizontal">
		<div class="form-group">
		 <label for="i" class="col-sm-2 control-label">Name</label>
		 <div class="col-sm-4"><input type="text" class="form-control" id="iName" placeholder="MyPlace"></div>
		</div>
		<div class="form-group">
		 <label for="inputPassword3" class="col-sm-2 control-label">SSID</label>
		 <div class="col-sm-4"><input type="text" class="form-control" id="inputPassword3" placeholder="WifiSSID"></div>
		</div>
		<div class="form-group">
		 <label for="inputPassword3" class="col-sm-2 control-label">Key:</label>
		 <div class="col-sm-4"><input type="text" class="form-control" id="inputPassword3" placeholder="SECRETKEY123"></div>
		</div>
		<div class="form-group">
		 <label for="inputPassword3" class="col-sm-2 control-label">IP-Address</label>
		 <div class="col-sm-4"><input type="text" class="form-control" id="inputPassword3" placeholder="192.168.1.200"></div>
		</div>
		<div class="form-group">
		 <label for="inputPassword3" class="col-sm-2 control-label">Gateway IP-Addr</label>
		 <div class="col-sm-4"><input type="text" class="form-control" id="inputPassword3" placeholder="192.168.1.1"></div>
		</div>
 
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Save Connection</button>
    </div>
  </div>
</form>
    </div>
  </div>



<?php 
} else { echo pleaseLogin(); }
include_once("inc.footer.php");
?>
