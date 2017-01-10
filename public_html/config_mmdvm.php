<?php 
/**
 * THE EASYMB WEB CONTROL
 *
 * Use this code for a easyBM Setup
 *
 * @file       /var/www/html/admin/config_mmdvm.php
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

	$arr_config = getMMDVMConfig();
	if ( PHPDEBUG == TRUE ){ echo "<pre>"; print_r($arr_config); echo "</pre>"; }
?>
    <div class="container">
    <div class="jumbotron">
      <h1>easyBM <small>MMDVM Configuration</small></h1>

	<form class="form-horizontal" action="" method="post">
	<fieldset>

	<legend>General</legend>
	<div class="form-group">
	  <label class="col-md-4 control-label" for="callsign">Your Callsign</label>
	  <div class="col-md-4">
	  <input id="callsign" name="callsign" type="text" placeholder="DL1ABC" class="form-control input-md" required="" value="<?php echo $arr_config['General']['Callsign']; ?>">
	  <span class="help-block">This is your own callsign.</span>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-md-4 control-label" for="id">Your DMR ID</label>
	  <div class="col-md-4">
	  <input id="id" name="id" type="text" placeholder="2621234" class="form-control input-md" required="" value="<?php echo $arr_config['DMR']['Id']; ?>">
	  <span class="help-block">This is your own DMR ID.</span>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-md-4 control-label" for="location">Your Location</label>
	  <div class="col-md-4">
	  <input id="location" name="location" maxlength="20" type="text" placeholder="HamTown" class="form-control input-md" required="" value="<?php echo $arr_config['Info']['Location']; ?>">
	  <span class="help-block">Let us know, where your are located.</span>
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
	<div class="form-group">
	  <label class="col-md-4 control-label" for="url">Your URL</label>
	  <div class="col-md-4">
	  <input id="url" name="url" maxlength="124" type="text" placeholder="https://www.qrz.com/db/callsign" class="form-control input-md" required="" value="<?php echo $arr_config['Info']['URL']; ?>">
	  <span class="help-block">For example, your QRZ.com webpage.</span>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-md-4 control-label" for="description">Description</label>
	  <div class="col-md-4">
	  <input id="description" name="description" maxlength="20" type="text" placeholder="[easyBM] Hotspot" class="form-control input-md" required="" value="<?php echo $arr_config['Info']['Description']; ?>">
	  <span class="help-block">A very short description about your system.</span>
	  </div>
	</div>
	<div class="form-group">
          <label class="col-md-4 control-label" for="description">RX-Frequency</label>
           <div class="col-md-4">
           <input id="description" name="description" maxlength="20" type="text" placeholder="433612500" class="form-control input-md" required="" value="<?php echo $arr_config['Info']['RXFrequency']; ?>">
           <span class="help-block">Your RX frequency.</span>
           </div>
        </div>
	<div class="form-group">
          <label class="col-md-4 control-label" for="description">TX-Frequency</label>
           <div class="col-md-4">
            <input id="description" name="description" maxlength="20" type="text" placeholder="433612500" class="form-control input-md" required="" value="<?php echo $arr_config['Info']['TXFrequency']; ?>">
            <span class="help-block">Your TX frequency.</span>
           </div>
        </div>

	<legend>DMR Settings</legend>
	<div class="form-group">
          <label class="col-md-4 control-label" for="id">Your DMR ID</label>
           <div class="col-md-4">
           <input id="id" name="id" type="text" placeholder="2621234" class="form-control input-md" required="" value="<?php echo $arr_config['DMR']['Id']; ?>">
           <span class="help-block">This is your own DMR ID.</span>
           </div>
         </div>
	<div class="form-group">
       	  <label class="col-md-4 control-label" for="serveraddress">Server Address</label>
          <div class="col-md-4">
            <input id="serveraddress" name="serveraddress" type="text" value="<?php echo $arr_config['DMR Network']['Address']; ?>" class="form-control input-md">
            <span class="help-block">The DMR Master server IP-Address or hostname.</span>
          </div>
        </div>
	<div class="form-group">
          <label class="col-md-4 control-label" for="serverport">Server Port</label>
           <div class="col-md-4">
           <input id="serverport" name="serverport" type="text" value="<?php echo $arr_config['DMR Network']['Port']; ?>" class="form-control input-md">
           <span class="help-block">The DMR Master server port.</span>
           </div>
        </div>
	<div class="form-group">
          <label class="col-md-4 control-label" for="serverpassword">Server Password</label>
            <div class="col-md-4">
            <input id="serverpassword" name="serverpassword" type="text" value="<?php echo $arr_config['DMR Network']['Password']; ?>" class="form-control input-md">
            <span class="help-block">The DMR Master server password.</span>
            </div>
        </div>
	<legend>D-Star Settings</legend>
	<div class="form-group">
          <label class="col-md-4 control-label" for="id">D-Star Enable</label>
          <div class="col-md-4">
           <label class="radio-inline"> <input type="radio" name="dstar-enable" id="dstar-enable" value="1" selected> Yes </label>
           <label class="radio-inline"> <input type="radio" name="dstar-enable" id="dstar-enable" value="0"> No </label>
           <span class="help-block">Enable or Disable D-Star function.</span>
          </div>
         </div>
	<div class="form-group">
         <label class="col-md-4 control-label" for="id">D-Star Modul</label>
          <div class="col-md-4">
		<label class="radio-inline"> <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="A"> A </label>
		<label class="radio-inline"> <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="B"> B </label>
		<label class="radio-inline"> <input type="radio" name="inlineRadioOptions" id="inlineRadio3" value="C" selected> C </label>
		<label class="radio-inline"> <input type="radio" name="inlineRadioOptions" id="inlineRadio3" value="D"> D </label>
                <span class="help-block">This is for RPT1 settings.</span>
          </div>
	</div>
	<div class="form-group">
         <label class="col-md-4 control-label" for="id">D-Star Network</label>
          <div class="col-md-4">
		<?php echo 'Gateway Address:&nbsp;'. $arr_config['D-Star Network'][GatewayAddress] . '<br />Gateway-Port:&nbsp;'. $arr_config['D-Star Network']['GatewayPort']. '<br />Local-Port:&nbsp;'.$arr_config['D-Star Network']['LocalPort']; ?>
	  </div>
	</div>
	
	<legend>System Fusion Settings</legend>
	<div class="form-group">
           <label class="col-md-4 control-label" for="id">C4FM Enable</label>
            <div class="col-md-4">
               <label class="radio-inline"> <input type="radio" name="c4fm-enable" id="c4fm-enable" value="1"> Yes </label>
               <label class="radio-inline"> <input type="radio" name="c4fm-enable" id="c4fm-enable" value="0"> No </label>
               <span class="help-block">Enable or Disable C4FM System Fusion function.</span>
            </div>
        </div>
	<legend>P25 Settings</legend>
        <div class="form-group">
          <label class="col-md-4 control-label" for="id">P25 Enable</label>
           <div class="col-md-4">
              <label class="radio-inline"> <input type="radio" name="p25-enable" id="p25-enable" value="1"> Yes </label>
              <label class="radio-inline"> <input type="radio" name="p25-enable" id="p25-enable" value="0"> No </label>
                  <span class="help-block">Enable or Disable D-Star Function.</span>
                  </div>
                </div>
	
		<hr>
		 <div class="form-group">
                  <label class="col-md-4 control-label" for="done">Everything done?</label>
                  &nbsp;&nbsp;<button type="submit" class="btn btn-success">Save this setting ...</button>
                  <input name="submited" type="hidden" value="true">
                </div>

		</form>

	</div> <!--/jumbotron-->
	</div> <!--/container-->
<?php 
} else { echo pleaseLogin(); }
include_once('inc.footer.php');
?>
