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

  //$url='https://brandmeister.network/dist/js/bm/groups.js';
  $url='https://api.brandmeister.network/v1.0/groups/';
  $json = file_get_contents($url);
  $json = utf8_encode(ltrim($json, 'var groups='));
  $data = json_decode($json,true);

?>

	<div class="container">
	    <div class="jumbotron">
        	<div class="row">
	        <h1>BrandMeister <small> DMR Talk Groups </small></h1>
	        <table class="table table-hover"><thead><tr><th>Talk Group ID</th><th>Description</th></tr></thead>
	        <tbody>

        <?php
        if ( count($data) > 0){

            foreach($data as $key => $value){
                echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
            }

        } else { echo '<tr><td ><strong>Sorry, but the remote host has no Talk Group informations.</strong></td></tr>'; }

        ?>

        	</tbody>
	        </table>
	 	 </div>
	    </div>
	</div>

<?php

} else { echo pleaseLogin(); }
include_once("inc.footer.php");

?>
