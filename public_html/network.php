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

include_once("inc.auth.php");
include_once("inc.header.php");
if (isset($_SESSION['angemeldet'])){

?>


  <div class="container">
    <div class="jumbotron">
      <h1>easyBM <small>under contruction</small></h1>
		
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
