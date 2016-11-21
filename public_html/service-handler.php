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

include_once('inc.header.php');
?>

  <div class="container">
    <div class="jumbotron">
      <h1>easyBrandMeister <small>DVMEGA-Hotspot</small></h1>
      <p>Control-Center for easy access to digital voice communication in amateur radio.</p>
<?php
$cmd=$_GET['cmd'];

switch ($cmd) {
    case "restart-mmdvm":
        echo "<p>MMDVMHost is restarting in background</p>";
        break;
    case "restart-ircddbgateway":
        echo "<p>ircddbgateway is restarting in background</p>";
        break;
    case "restart-system":
        echo "System rebooting now!";
        break;
    case "shutdown-system":
        echo "System shutdown now!";
        break;
}

?>
    </div>
  </div>
  </div>
  </body>
</html>
<?php
switch ($cmd) {
    case "restart-mmdvm":
	echo exec('sudo service mmdvmhost restart');
        break;
    case "restart-ircddbgateway":
	echo exec('sudo service start_ircddbgateway restart');
        break;
    case "restart-system":
        echo exec('sudo reboot');
        break;
    case "shutdown-system":
        echo exec('sudo halt');
        break;
}


include_once('inc.footer.php');
?>
