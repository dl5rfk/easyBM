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

	if ( PHPDEBUG == TRUE ){ echo "<pre>"; print_r($arr_config); echo "</pre>"; }

?>
    <div class="container">
    <div class="jumbotron">
      <h1>easyBM <small>YSFGateway Configuration</small></h1>

	<form class="form-horizontal" action="" method="post">
<?php
/*
[General]
Callsign=DL5RFK
Suffix=RPT
# Suffix=ND
RptAddress=127.0.0.1
RptPort=3200
LocalAddress=127.0.0.1
LocalPort=4200
Daemon=0
[Info]
RXFrequency=433612500
TXFrequency=433612500
Power=1
Latitude=0.0
Longitude=0.0
Height=0
Name=Klaus
Description=[easyBM] Hotspot
[Log]
# Logging levels, 0=No logging
DisplayLevel=1
FileLevel=1
FilePath=/mnt/ramdisk/
FileRoot=YSFGateway
[aprs.fi]
Enable=0
# Server=noam.aprs2.net
Server=euro.aprs2.net
Port=14580
Password=9999

[Network]
Enable=1
Port=42000
Hosts=/etc/YSFGateway/YSFHosts.txt
ReloadTime=60
ParrotAddress=127.0.0.1
ParrotPort=42000
# Startup=
Debug=1
*/
?>

	 <legend>General</legend>
         <div class="form-group">
          <label class="col-md-4 control-label" for="callsign">Your Callsign</label>
           <div class="col-md-4">
            <input id="callsign" name="callsign" type="text" placeholder="DL1ABC" class="form-control input-md" required="" value="<?php echo $arr_config[General][Callsign]; ?>">
            <span class="help-block">This is your own callsign.</span>
           </div>
          </div>
         <div class="form-group">
          <label class="col-md-4 control-label" for="id">Your DMR ID</label>
           <div class="col-md-4">
            <input id="id" name="id" type="text" placeholder="2621234" class="form-control input-md" required="" value="<?php echo $arr_config[DMR][Id]; ?>">
            <span class="help-block">This is your own DMR ID.</span>
           </div>
          </div>
         <div class="form-group">
          <label class="col-md-4 control-label" for="location">Your Location</label>
            <div class="col-md-4">
              <input id="location" name="location" maxlength="20" type="text" placeholder="HamTown" class="form-control input-md" required="" value="<?php echo $arr_config[Info][Location]; ?>">
              <span class="help-block">Let us know, where your are located.</span>
             </div>
         </div>
         <div class="form-group">
           <label class="col-md-4 control-label" for="location">Your Latitude</label>
             <div class="col-md-4">
              <input id="location" name="location" maxlength="20" type="text" placeholder="0.0" class="form-control input-md" required="" value="<?php echo $arr_config[Info][Latitude]; ?>">
              <span class="help-block">Let us know, where your are located.</span>
             </div>
         <div class="form-group">
           <label class="col-md-4 control-label" for="location">Your Longitude</label>
            <div class="col-md-4">
             <input id="location" name="location" maxlength="20" type="text" placeholder="0.0" class="form-control input-md" required="" value="<?php echo $arr_config[Info][Longitude]; ?>">
             <span class="help-block">Let us know, where your are located.</span>
            </div>
         </div>


	</form>
	</div> <!--/jumbotron-->
	</div> <!--/container-->

<?php
 
} else { echo pleaseLogin(); }
include_once('inc.footer.php');

?>
