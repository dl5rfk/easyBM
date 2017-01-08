<?php
/**
 * Use this code for a easyBM Setup
 *
 * @file       /opt/easyBM/public_html/network_vnstat.php
 * @author     DL5RFK <easybm@dl5rfk.org>
 * @copyright  2016 The German BrandMeister Team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3
 * @version    2017-01-08
 * @remarks    WITHOUT ANY WARRANTY OR GUARANTEE
 * @see        http://www.bm262.de
 *
 */
include_once("inc.header.php");
if (isset($_SESSION['angemeldet'])){
?>

 <div class="container">
    <div class="jumbotron">
      <h1>easyBM <small>Network Statistics</small></h1>

     <center>
      <div class="embed-responsive embed-responsive-4by3">
     <iframe class="embed-responsive-item" src="/vnstati/index.html" width="900" height="700" frameborder="0"></iframe>
      </div>
     </center>
     
    </div>
  </div>

<?php 
} else { echo pleaseLogin(); }
include_once("inc.footer.php"); 
?>
