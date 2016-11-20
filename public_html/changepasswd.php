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

//include("auth.php");

//if ( $_SERVER['HTTP_REFERER'] == '/admin/index.php' && isset($_POST['password']) && isset($_POST['password2']) ){
if ( isset($_POST['password']) && isset($_POST['password2']) ){
 $passwd = $_POST['password'];
 $passwd2 = $_POST['password2'];
} else { header('Location: /admin/index.php'); }

if ($passwd === $passwd2) {

	$configfile = fopen("config.php", 'w');
	fwrite($configfile,"<?php\n");
	fwrite($configfile,"# This is an auto-generated config-file by easyBM-Control Center!\n");
	fwrite($configfile,"# Be careful, when you manual editing this!\n\n");
	fwrite($configfile,"define(\"ADMINPASSWORD\", \"$passwd\");"."\n");
	fwrite($configfile,"define(\"ADMINPASSWORDCHANGED\", TRUE);"."\n");
	fwrite($configfile,"?>\n");
	fclose($configfile);

	$file = file_get_contents("config.php");
	echo $file;

	include_once("inc.header.php");

	echo $_SERVER['HTTP_REFERER'];

?>
	  <div class="container">
	   <div class="jumbotron">
	    <h1>easyBM <small>Web Control Center</small></h1>
	    <p>Control-Center for easy access to digital voice communication in amateur radio.</p>
	    <p>Congratulations! Your Password is changed!</p>
	   </div>
	  </div>
  
<?php

	include_once("inc.footer.php");
	
} else { echo "Sorry, can not update the config file, because password is not equal."; }
?>
