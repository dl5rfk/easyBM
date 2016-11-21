<?php
/**
 * THE EASYMB WEB CONTROL
 *
 * Use this code for a easyBM Setup
 *
 * @file       /var/www/html/admin/system.php
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
        <div class="row">
        <h1>Ping <small>Check host response time</small></h1>

<?php 
//  This script was writen by webmaster@theworldsend.net, Aug.2001 
//  http://www.theworldsend.net  
// Get Variable from form via register globals on/off 
//------------------------- 
$max_count = 10; //maximum count for ping command 
$unix      =  1; //set this to 1 if you are on a *unix system       
$windows   =  0; //set this to 1 if you are on a windows system 
// ------------------------- 
// nothing more to be done. 
// ------------------------- 
//globals on or off ? 
$register_globals = (bool) ini_get('register_gobals'); 
$system = ini_get('system'); 
$unix = (bool) $unix; 
$win  = (bool)  $windows; 
// 
If ($register_globals) 
{ 
   $ip = getenv(REMOTE_ADDR); 
   $self = $PHP_SELF; 
}  
else  
{ 
   if (isset($_GET['submit'])){ $submit = $_GET['submit']; } else { $submit=""; }
   if (isset($_GET['count'])){ $count=$_GET['count']; } else { $count=4; }
   if (isset($_GET['host'])){ $host = $_GET['host']; } else { $host='localhost'; }
   $ip     = $_SERVER['REMOTE_ADDR']; 
   $self   = $_SERVER['PHP_SELF']; 
}; 
// form submitted ? 
if ($submit == "Ping!")  
{ 
   // over count ? 
   if ($count > $max_count)  
   { 
      echo '<p class="bg-danger"> Maximum for count is: '.$max_count . '</p>'; 
      echo '<p><a href="'.$self.'">OK, go back</a></p>'; 
   } 
   else  
   { 
      // replace bad chars 
      $host= preg_replace ("/[^A-Za-z0-9.-]/","",$host); 
      $count= preg_replace ("/[^0-9.]/","",$count); 
      echo '<p class="bg-info">Ping Output:<br /></p>';  
      echo '<pre>';            
      //check target IP or domain 
      if ($unix)  
      { 
         system ("ping -c$count -w$count $host"); 
         system("killall ping");// kill all ping processes in case there are some stalled ones or use echo 'ping' to execute ping without shell 
      } 
      else 
      { 
         system("ping -n $count $host"); 
      } 
      echo '</pre>'; 
    } 
}  
else  
{ 
    echo '<p><font size="2">Your IP is: '.$ip.'</font></p>'; 
    echo '<form methode="post" action="'.$self.'">'; 
    echo '   Enter IP-Addr or Hostname <input type="text" name="host" value="'.$ip.'"></input>'; 
    echo '   Enter Count <input type="text" name="count" size="2" value="4"></input>'; 
    echo '   <input type="submit" name="submit" value="Ping!"></input>'; 
    echo '</form>'; 
    echo '<br><b>'.$system.'</b>'; 
    echo '</body></html>'; 
} 
?> 
</div></div></div>

<div class="container">
    <div class="jumbotron">
        <div class="row">
        <h1>Traceroute <small>Check response time of a path</small></h1>
<?php 
//  This script was writen by webmaster@theworldsend.net, Aug.2001 
//  http://www.theworldsend.net  
//  This is my first script. Enjoy. 
//   
// Put it into whatever directory and call it. That's all. 
// Updated to 4.2 code in 2002 
// Get Variable from form via register globals on/off 
//------------------------- 
$unix      =  1; //set this to 1 if you are on a *unix system       
$windows   =  0; //set this to 1 if you are on a windows system 
// ------------------------- 
// nothing more to be done. 
// ------------------------- 
//globals on or off ? 
$register_globals = (bool) ini_get('register_gobals'); 
$system = ini_get('system'); 
$unix = (bool) $unix; 
$win  = (bool)  $windows; 
// 
If ($register_globals) 
{ 
   $ip = getenv(REMOTE_ADDR); 
   $self = $PHP_SELF; 
}  
else  
{ 
   if (isset($_GET['submit'])){ $submit = $_GET['submit']; } else { $submit=""; }
   if (isset($_GET['host'])) { $host = $_GET['host']; } else { $host='localhost'; }
   $ip     = $_SERVER['REMOTE_ADDR']; 
   $self   = $_SERVER['PHP_SELF']; 
}; 
// form submitted ? 
if ($submit == "Traceroute!")  
{ 
      // replace bad chars 
      $host= preg_replace ("/[^A-Za-z0-9.]/","",$host); 
      echo '<p class="bg-info">Trace Output:<br /></p>';  
      echo '<pre>';            
      //check target IP or domain 
      if ($unix)  
      { 
         system ("traceroute $host"); 
         system("killall -q traceroute");// kill all traceroute processes in case there are some stalled ones or use echo 'traceroute' to execute without shell 
      } 
      else 
      { 
         system("tracert $host"); 
      } 
      echo '</pre>';  
}  
else  
{ 
    echo '<p><font size="2">Your IP is: '.$ip.'</font></p>'; 
    echo '<form methode="post" action="'.$self.'">'; 
    echo '   Enter IP-Addr or Hostname <input type="text" name="host" value="'.$ip.'"></input>'; 
    echo '   <input type="submit" name="submit" value="Traceroute!"></input>'; 
    echo '</form>'; 
    echo '<br><b>'.$system.'</b>'; 
} 
?> 
</div></div></div>




<?php 

} else { echo pleaseLogin(); }
include_once("inc.footer.php"); 
?>
