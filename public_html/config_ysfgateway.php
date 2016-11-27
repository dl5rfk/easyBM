<?php 
/**
 * THE EASYMB WEB CONTROL
 *
 * Use this code for a easyBM Setup
 *
 * @file       /var/www/html/admin/config_ysfgateway.php
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
if (isset($_SESSION['angemeldet'])){

	$arr_config = getYSFGATEWAYConfig();

	echo "<pre>";
	print_r($arr_config);
	echo "</pre>";


?>
	<div class="container">
    <div class="jumbotron">
      <h1>easyBM <small>YSFGateway Configuration</small></h1>

	<form class="form-horizontal" action="" method="post">
	<fieldset>
	</fieldset>
	</form>
	</div> <!--/jumbotron-->
	</div> <!--/container-->

<?php
 
} else { echo pleaseLogin(); }
include_once('inc.footer.php');

?>
