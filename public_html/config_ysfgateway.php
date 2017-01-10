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

	if ( PHPDEBUG == TRUE ){ echo "<pre>"; var_dump($arr_config); echo "</pre>"; }

?>
    <div class="container">
    <div class="jumbotron">
      <h1>easyBM <small>YSFGateway Configuration</small></h1>

	<form class="form-horizontal" action="" method="post">

	 <legend>General</legend>
         <div class="form-group">
          <label class="col-md-4 control-label" for="callsign">Your Callsign</label>
           <div class="col-md-4">
            <input id="callsign" name="callsign" type="text" placeholder="DL1ABC" class="form-control input-md" required="" value="<?php echo $arr_config['General']['Callsign']; ?>">
            <span class="help-block">This is your own callsign.</span>
           </div>
          </div>
         <div class="form-group">
          <label class="col-md-4 control-label" for="id">Your Suffix</label>
           <div class="col-md-4">
            <input id="id" name="id" type="text" placeholder="2621234" class="form-control input-md" required="" value="<?php echo $arr_config['General']['Suffix']; ?>">
            <span class="help-block">This is your suffix, like RPT or ND.</span>
           </div>
          </div>
	 <legend>Info</legend>
         <div class="form-group">
          <label class="col-md-4 control-label" for="location">RX Frequency</label>
            <div class="col-md-4">
              <input id="location" name="location" maxlength="20" type="text" placeholder="433612500" class="form-control input-md" required="" value="<?php echo $arr_config['Info']['RXFrequency']; ?>">
              <span class="help-block">Set your RX QRG.</span>
             </div>
         </div>
	<div class="form-group">
          <label class="col-md-4 control-label" for="location">TX Frequency</label>
            <div class="col-md-4">
              <input id="location" name="location" maxlength="20" type="text" placeholder="433612500" class="form-control input-md" required="" value="<?php echo $arr_config['Info']['TXFrequency']; ?>">
              <span class="help-block">Set your TX QRG.</span>
             </div>
         </div>
         <div class="form-group">
           <label class="col-md-4 control-label" for="location">Your Latitude</label>
             <div class="col-md-4">
              <input id="location" name="location" maxlength="20" type="text" placeholder="0.0" class="form-control input-md" required="" value="<?php echo $arr_config['Info']['Latitude']; ?>">
              <span class="help-block">Let us know, where your are located.</span>
             </div>
	</div>
         <div class="form-group">
           <label class="col-md-4 control-label" for="location">Your Longitude</label>
            <div class="col-md-4">
             <input id="location" name="location" maxlength="20" type="text" placeholder="0.0" class="form-control input-md" required="" value="<?php echo $arr_config['Info']['Longitude']; ?>">
             <span class="help-block">Let us know, where your are located.</span>
            </div>
         </div>
	 <legend>Logging</legend>
	<div class="form-group">
          <label class="col-md-4 control-label" for="location">Log File Path</label>
            <div class="col-md-4">
              <input id="location" name="location" maxlength="20" type="text" placeholder="/mnt/ramdisk/" class="form-control input-md" required="" value="<?php echo $arr_config['Log']['FilePath']; ?>">
              <span class="help-block">Set the path to the logfile.</span>
             </div>
         </div>
	<legend>APRS</legend>
	<div class="form-group">
          <label class="col-md-4 control-label" for="location">Enable</label>
            <div class="col-md-4">
              <input id="location" name="location" maxlength="20" type="text" placeholder="0" class="form-control input-md" required="" value="<?php echo $arr_config['aprs.fi']['Enable']; ?>">
              <span class="help-block">0=disabled, 1=enabled</span>
             </div>
         </div>
	 <legend>Networking</legend>
	<div class="form-group">
          <label class="col-md-4 control-label" for="location">Enable</label>
            <div class="col-md-4">
              <input id="location" name="location" maxlength="20" type="text" placeholder="0" class="form-control input-md" required="" value="<?php echo $arr_config['Network']['Enable']; ?>">
              <span class="help-block">0=disabled, 1=enabled</span>
             </div>
         </div>

	</form>
	</div> <!--/jumbotron-->
	</div> <!--/container-->

<?php
 
} else { echo pleaseLogin(); }


include_once('inc.footer.php');
?>
