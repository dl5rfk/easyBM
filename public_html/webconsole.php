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

if (isset($_SESSION['angemeldet'])){

?>

	<div class="container">
	    <div class="jumbotron">
        	<div class="row">
	        <h1>easyBM <small> Webconsole</small></h1>
		<p>Web Console is a web-based application that allows to execute shell commands on a server directly from a browser (web-based SSH).</p>
		<p>Fore more information, please visit http://web-console.org/ </p>
		<p></p>
		<p>...use it at your own risk and think before you type...</p>
		


		<a class="btn btn-danger btn-lg btn-block" href="/admin/webconsole/webconsole.php" onclick="popupwindow(this.href); return false">Open WebConsole<a>

	 	</div>
	    </div>
	</div>

<?php

} else { echo pleaseLogin(); }
include_once("inc.footer.php");

?>
