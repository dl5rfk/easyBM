<?php 
session_start(); 

if (file_exists ("config.php") ) { include_once('config.php'); } else {  echo "<hr>";  }

include_once('inc.functions.php');

//FOR DEBUG ONLY
if( PHPDEBUG == TRUE){
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
}

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
        session_destroy();
        header('Location: http://'.$_SERVER['SERVER_NAME'].'/admin/logout.php');
 }

//CHECK SESSISION TIME
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
    // last request was more than 900 sec ago
    session_unset('angemeldet');     	// unset $_SESSION variable 
    session_unset('LAST_ACTIVITY');     // unset $_SESSION variable 
    session_unset();     		// unset $_SESSION variable 
    session_destroy();   		// destroy session data in storage
    $_SESSION['angemeldet']=FALSE;

} else {
                $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
                $_SESSION['clientip'] = $_SERVER['REMOTE_ADDR']; //remote ip
                $_SESSION['rpiip'] = $_SERVER['SERVER_ADDR']; //remote ip
                $_SESSION['rpiname'] = $_SERVER['SERVER_NAME']; //remote ip
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <script src="js/bootstrap.min.js"></script>
    
    <style>
		/* Sticky footer styles */
		html { position: relative; min-height: 100%; }
		body { /* Margin bottom by footer height */ margin-bottom: 60px; }
		.footer { position: absolute; bottom: 0; width: 100%; /* Set the fixed height of the footer here */ height: 60px; background-color: #f5f5f5; }
    </style>
    
    <title>easyBM</title>


    <script type="text/javascript">
	function popupwindow (url) {
	   fenster = window.open(url, "window1", "width=800,height=600,status=yes,scrollbars=yes,resizable=yes");
	   fenster.focus();
	}
</script>


  </head>

<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">easyBM <small>(<?php echo $_SERVER['SERVER_ADDR'];?>)</small></a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <?php 
	      if (isset($_SESSION['angemeldet']) && $_SESSION['angemeldet'] == 1 ) { ?>
		<li class="dropdown">
                 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Infos & Tool´s<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                   <li><a href="/admin/status.php">System Status</a></li>
		   <li><a href="network_vnstat.php">Network Statistics</a></li>
        	   <li><a href="/MMDVMHost-Dashboard/">MMDVM Dashboard</a></li>
                   <li><a href="/admin/ircddbgatewaydashboard.php">ircDDB Dashboard</a></li>
                   <li><a href="/admin/bm-groups.php">BrandMeister TalkGroups</a></li>
                   <li class="divider"></li>
                   <li><a href="/admin/tools.php">Net Tools</a></li>
                   <li><a href="/admin/webconsole.php">SSH WebConsole</a></li>
                  </ul>
                </li>		

		<li class="dropdown">
		 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Configuration<b class="caret"></b></a>
                  <ul class="dropdown-menu">
			   <li><a href="/admin/config_system.php">System</a></li>
			   <li><a href="/admin/config_network.php">IP Network</a></li>
			   <li><a href="/admin/gpio.php">GPIO-Ports</a></li>
			   <li class="divider"></li>
			   <li><a href="/admin/config_mmdvm.php">MMDVM (DMR)</a></li>
			   <li><a href="/admin/config_ircddbgateway.php">ircddbgateway (D-Star)</a></li>
			   <li><a href="/admin/config_ysfgateway.php">YSFGateway (C4FM)</a></li>						   
                  </ul>
                </li>
		<li class="dropdown">
            	 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Edit<b class="caret"></b></a>
            	  <ul class="dropdown-menu">
		   <li><a href="/admin/edit_mmdvmini.php">MMDVM.ini</a></li>
		   <li><a href="/admin/edit_ircddbgateway.php">ircddbgateway</a></li>
		   <li><a href="/admin/edit_ysfgateway.php">YSFGateway.ini</a></li>
               	   <li class="divider"></li>
           	  </ul>
         	</li>
                <li class="dropdown">
                 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Services<b class="caret"></b></a>
                  <ul class="dropdown-menu">
			<strong>&nbsp;&nbsp;Optional external Pages</strong>
		   <li><a target="_blank" href="https://register.ysfreflector.de/register">Register a YSF Reflector</a></li>
	           <li><a target="_blank" href="https://register.ham-digital.org/">CCS7 Registration</a></li>
		   <li><a target="_blank" href="https://dmr-marc.net/cgi-bin/trbo-database/register.cgi">DMR-MARC Registration</a></li>
		   <li><a target="_blank" href="http://regsrv.ircddb.net/index.htm">irdDDB Registration</a></li>
                   <li><a target="_blank" href="http://ham-digital.org/dmr-userreg.php">DMR ID Search</a></li>
                   <li class="divider"></li>
                  </ul>
                </li>
		
		<li><a href="/admin/log-viewer.php">Logs</a></li>
		<li><a href="/admin/restart.php">Restart</a></li>
		<li><a href="/admin/about.php">About</a></li>
               	<li><a href="/admin/help.php#editing">Help</a></li>
		<?php } ?>
		
	  </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php 
		if (isset($_SESSION['angemeldet']) && $_SESSION['angemeldet'] == 1 ) {
		 echo '<li><a class="text-success" href="/admin/logout.php"><strong>Logout</strong></a></li>'; 
		} else {
			 echo '<li><a class="text-danger" href="/admin/index.php"><strong>Login</strong></a></li>';
			} 
		 ?>
        <li><img src="/admin/images/bmlogo_50.jpg"></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<?php 

if( PHPDEBUG == TRUE){
	echo "<br />SESSION-CONTENT:<br /><pre>"; 
	print_r($_SESSION); 
	echo "</pre><br />";
}
?>
