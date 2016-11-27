<?php
/*
 * mmdvmini.php
 * 
 * Copyright 2016 root <root@easybm>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
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
 * 
 */

include_once("inc.header.php");

// configuration
$url = 'setup.php';
$url = $_SERVER['HTTP_HOST'];
$filename= '/opt/MMDVMHost/MMDVM.ini';
if (file_exists($filename)) {
        $file = trim($filename,'\r');
        //$fp = file($filename, FILE_SKIP_EMPTY_LINES);
        $linecount = count( file($file)) + 5;
        $text = file_get_contents($file);
        } else {
                $text='Sorry, file '.$filename.' was not found!';
                $linecount=5;
}

// check if form has been submitted
if (isset($_POST['text']))
{
    // save the text contents
    file_put_contents($file, $_POST['text']);

    // redirect to form again
    header(sprintf('Location: %s', $url));
    printf('<a href="%s">Moved</a>.', htmlspecialchars($url));
    exit();
}

// read the textfile
$text = file_get_contents($file);

if (isset($_SESSION['angemeldet'])){
?>

<div class="container">
 <div class="row">
   <div class="col-md-1"></div>
   <div class="col-md-5">
	<h1>MMDVM.ini</h1>
	<form action="" method="post">
	 <textarea class="form-control" cols="50" rows="<?php echo $linecount; ?>" name="text" size="100"><?php echo htmlspecialchars($text) ?></textarea>
	 <br /><input class="form-control btn-success"  value="Save this Configuration" type="submit" />&nbsp;
	</form>
   </div>
   <div class="col-md-5">
	  <h2>Remarks:</h2>
	  <p class="text-primary">
	  Please do not forget to save the configuration and to restart MMDVM Software.<br />
	  Now, edit only the following values:<br/><br/>
	  <ul class="text-primary">
		<li>Callsign</li>
		<li>RXFrequency</li>
		<li>TXFrequency</li>
		<li>Location</li>
		<li>Description</li>
		<li>URL</li>
		<li>DMRId</li>
	  </ul>
	  </p>
	  <p class="text-danger">Leave Latitude, Longitude and Height untouched, if this is a Hotspot!</p>
	  <br /><a href="/admin/service-handler.php?cmd=restart-mmdvm" class="btn btn-danger">Restart MMDVM</a>
   </div>
   <div class="col-md-1"></div>
</div>
</div>


<?php 

} else { echo pleaseLogin(); }
include_once("inc.footer.php"); 

?>
