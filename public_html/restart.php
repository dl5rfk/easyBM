<?php
/**
 * THE EASYMB WEB CONTROL
 *
 * Use this code for a easyBM Setup
 *
 * @file       /var/www/html/admin/system.php
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

	<div class="row">
      	<h1>easyBM <small>System Restart</small></h1>
         <p>Sometimes or after config changes, it is a good idear to restart.</p>
         <p>The System is <?php print(shell_exec("uptime -p")); ?>.</p>
         <div class="btn-group">
           <a href="/admin/service-handler.php?cmd=restart-mmdvm"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>&nbsp;Restart MMDVMHost</button></a>
           <a href="/admin/service-handler.php?cmd=restart-ircddbgateway"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>&nbsp;Restart ircddbgateway</button></a>
           <a href="/admin/service-handler.php?cmd=restart-ysfgateway"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>&nbsp;Restart YSFGateway</button></a>
           <a href="/admin/service-handler.php?cmd=restart-system"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>&nbsp;Reboot System</button></a>
           <a href="/admin/service-handler.php?cmd=shutdown-system"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-off" aria-hidden="true"></span>&nbsp;Shutdown System</button></a>
	 </div>
	</div>
   </div>
  </div>
  
<?php 

} else { echo pleaseLogin(); }
include_once("inc.footer.php"); 
?>
