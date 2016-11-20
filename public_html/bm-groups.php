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
include_once('inc.auth.php');
include_once('inc.header.php');

$url='https://brandmeister.network/dist/js/bm/groups.js';

$json = file_get_contents($url); 
$json = utf8_encode(ltrim($json, 'var groups=')); 
$data = json_decode($json,true); 

//var_dump($json);
//print_r($data);
?>
<div class="container">
    <div class="jumbotron">
        <div class="row">
        <h1>BrandMeister <small> Talk Groups </small></h1>
<?php
echo '<pre>'.$json.'</pre>';
?>

</div>
</div>
</div>


<?php 
if (isset($_SESSION['angemeldet'])){
	

	echo '<div class="container"><div class="row">';
/*	
	  if (count($data->groups)) {
     	   // Open the table
        	echo "<table>";

          // Cycle through the array
          	foreach ($data->groups as $idx => $stand) {
            	// Output a row
            	echo "<tr>";
            	echo "<td>$stand->afko</td>";
            	echo "<td>$stand->positie</td>";
            	echo "</tr>";
          }
        // Close the table
        echo "</table>";
    	}
*/	 
	echo '</div></div>';

} else { echo pleaseLogin(); }

include_once("inc.footer.php");

?>
