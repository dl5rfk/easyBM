<?php

//http://www.dmr-marc.net/cgi-bin/trbo-database/datadump.cgi?table=users&format=json&id=123456
//http://dmr.darc.de/dmr-userreg.php?usrid=2620014



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

include_once("inc.header.php");
if (isset($_SESSION['angemeldet'])){
?>

 <div class="container">
    <div class="jumbotron">
      <h1>easyBM <small>external Support Page</small></h1>

     <center>
      <div class="embed-responsive embed-responsive-4by3">
     <iframe class="embed-responsive-item" src="http://dmr.darc.de/dmr-userreg.php?usrid=" width="900" height="700" frameborder="0"></iframe>
      </div>
     </center>
     
    </div>
  </div>

<?php 
} else { echo pleaseLogin(); }
include_once("inc.footer.php"); 
?>
