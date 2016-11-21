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

//INCLUDES
include_once('inc.header.php');

//VALUES
$hdGnu = disk_free_space('/');

	$content = file_get_contents('http://ip.jsontest.com/');
	//SOMETHING WRONG if(isset($content)) { $result=json_decode($content); }else{ //$result->ip = 'Unkown'; }
	$result=json_decode($content);
	$publicip = $result->ip;

if (isset($_SESSION['angemeldet'])){
?>

<div class="container"><div class="row">

<h1>System Status</h1>
<?php
if (!file_exists($MMDVMINI)){ echo '<div class="alert alert-danger"> <strong>Danger!</strong> MMDVM.ini is missing. </div></p>'; }
if (!file_exists($WPACONFIG)){ echo '<div class="alert alert-danger"> <strong>Danger!</strong> WIFI wpa_supplicant.conf is missing.</div></p>'; }
if (!file_exists($IRCDDBCFG)){ echo '<div class="alert alert-danger"> <strong>Danger!</strong> ircddbgateway config file is missing.</div></p>'; }
?>
<table class="table">
	<tr><td>Hostname</td><td><?php print(shell_exec("hostname")); ?></td></tr>
	<tr><td>Kernel Version</td><td><?php print(shell_exec("uname -r")); ?></td></tr>
	<tr><td>System Type</td><td><?php print(shell_exec("gpio -v |grep Type")); ?></td></tr>
	<tr><td>System Uptime</td><td><?php print(shell_exec("uptime")); ?></td></tr>
	<tr><td>System Time</td><td><?php print(shell_exec("date")); ?></td></tr>
	<tr><td>Free Memory</td><td><?php echo getSymbolByQuantity($hdGnu); ?></td></tr>
	<tr><td>Ramdisk</td><td><pre><?php print(shell_exec("ls -sh /mnt/ramdisk")); ?></pre></td></tr>
	<tr><td>MMDVM.ini File</td><td>Found at : <?php print(shell_exec("find / -name MMDVM.ini")); ?></td></tr>
	<tr><td>DMRIds.dat</td><td>Found at : <?php print(shell_exec("find / -name DMRIds.dat")); ?></td></tr>
	<tr><td>ARP</td><td><pre><?php print(shell_exec("arp -a")); ?></pre></td></tr>
	<tr><td>IP Route</td><td><pre><?php print(shell_exec("ip route")); ?></pre></td></tr>
	<tr><td>Public IP-Address</td><td><?php echo $publicip; ?></td></tr>
</table>

<br />
<h2>Internet Latency Graph</h2>
<img src="/admin/latency_graph.png" class="img-responsive" alt="Latency Graph for your Internet Access">

<br /> <br />
<p class="text-danger"><strong>Note:</strong>&nbsp;It is essential that the easyBM Hotspot has a connection to the Internet, otherwise this Website will not work properly.</p>

</div></div>


<?php 
} else { echo pleaseLogin(); }
include_once("inc.footer.php"); 
?>
