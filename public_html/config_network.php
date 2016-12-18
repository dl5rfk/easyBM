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

exec('/sbin/ifconfig', $ipdata);
$ipdata = implode($ipdata, '\n');

foreach (preg_split("/\n\n/", $ipdata) as $int) {
  preg_match("/^([A-z]*\d)\s+Link\s+encap:([A-z]*)\s+HWaddr\s+([A-z0-9:]*).*" .
    "inet addr:([0-9.]+).*Bcast:([0-9.]+).*Mask:([0-9.]+).*" .
    "inet6 addr:\s([a-f0-9:\/]+).*Scope:Link.*" .
     "MTU:([0-9.]+).*Metric:([0-9.]+).*" .
     "RX packets:([0-9.]+).*errors:([0-9.]+).*dropped:([0-9.]+).*overruns:([0-9.]+).*frame:([0-9.]+).*" .
     "TX packets:([0-9.]+).*errors:([0-9.]+).*dropped:([0-9.]+).*overruns:([0-9.]+).*carrier:([0-9.]+).*" .
     "RX bytes:([0-9.]+).*\((.*)\).*TX bytes:([0-9.]+).*\((.*)\)" .
     "/ims", $int, $regex);

    if (!empty($regex)) {
      $interface = array(); 
      $interface['name'] = $regex[1]; 
      $interface['type'] = $regex[2]; 
      $interface['mac'] = $regex[3]; 
      $interface['ip'] = $regex[4]; 
      $interface['broadcast'] = $regex[5]; 
      $interface['netmask'] = $regex[6]; 
      $interface['ipv6'] = $regex[7]; 
      $interface['mtu'] = $regex[8]; 
      $interface['metric'] = $regex[9]; 
      $interface['rx']['packets'] = $regex[10]; 
      $interface['rx']['errors'] = $regex[11]; 
      $interface['rx']['dropped'] = $regex[12]; 
      $interface['rx']['overruns'] = $regex[13]; 
      $interface['rx']['frame'] = $regex[14]; 
      $interface['rx']['bytes'] = $regex[20]; 
      $interface['rx']['hbytes'] = $regex[21]; 
      $interface['tx']['packets'] = $regex[15]; 
      $interface['tx']['errors'] = $regex[16]; 
      $interface['tx']['dropped'] = $regex[17]; 
      $interface['tx']['overruns'] = $regex[18]; 
      $interface['tx']['carrier'] = $regex[19]; 
      $interface['tx']['bytes'] = $regex[22]; 
      $interface['tx']['hbytes'] = $regex[22];
      $interfaces[] = $interface;
    }
}

?>


  <div class="container">
    <div class="jumbotron">
      <h1>easyBM <small>IP Network settings</small></h1>

<?php
//	echo"<pre>";
//	print_r($interfaces);
//	echo"</pre>";
	echo '<table class="table"></tr><th>Name</th><th>MAC-Addr</th><th>IPv4/Netmask</th><th>IPv6</th><th>RX/TX Errors</th></tr>';
	foreach($interfaces as $interface){
	echo "<tr><td>{$interface[name]}</td><td>{$interface[mac]}</td><td>{$interface[ip]}/{$interface[netmask]}</td><td>{$interface[ipv6]}</td><td>{$interface[rx][errors]}/{$interface[tx][errors]}</td></tr> ";
	} 
	echo '</table><hr>';
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
