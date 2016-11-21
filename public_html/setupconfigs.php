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

function createConfigLines() {
        $out ="";
        foreach($_POST as $key=>$val) {
                if($key != "cmd") {
                        $out .= "define(\"$key\", \"$val\");"."\n";
                }
        }
        return $out;
}

function startsWith($haystack, $needle) {
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}


$configfile = fopen("../config/setupvalues.php", 'w');
fwrite($configfile,"<?php\n");
fwrite($configfile,"# This is an auto-generated config-file!\n");
fwrite($configfile,"# Be careful, when manual editing this!\n\n");
fwrite($configfile, createConfigLines());
fwrite($configfile,"?>\n");
fclose($configfile);

$configfile = fopen("/var/www/html/MMDVMHost-Dashboard/config/config.php", 'w');
fwrite($configfile,"<?php\n");
fwrite($configfile,"# This is an auto-generated config-file!\n");
fwrite($configfile,"# Be careful, when manual editing this!\n\n");
fwrite($configfile, createConfigLines());
fwrite($configfile,"define(\"MMDVMLOGPATH\", \"/mnt/ramdisk/\");\n");
fwrite($configfile,"define(\"MMDVMLOGPREFIX\", \"MMDVM\");\n");
fwrite($configfile,"define(\"MMDVMINIPATH\", \"/etc/mmdvm/\");\n");
fwrite($configfile,"define(\"MMDVMINIFILENAME\", \"MMDVM.ini\");\n");
fwrite($configfile,"define(\"MMDVMHOSTPATH\", \"/usr/local/bin/\");\n");
fwrite($configfile,"define(\"LINKLOGPATH\", \"/var/log/\");\n");
fwrite($configfile,"define(\"IRCDDBGATEWAY\", \"ircddbgatewayd\");\n");
fwrite($configfile,"?>\n");
fclose($configfile);

$lines = file('/etc/ircddbgateway');
$result = '';

foreach($lines as $line) {
	if(startsWith($line, "gatewayCallsign")) {
		$gatewayCallsign = $_POST['CALLSIGN'];
		$gcslen = strlen($gatewayCallsign);
		for ($i = 0; $i < 7 - $gcslen; $i++) {
			$gatewayCallsign .=" ";
		}
		$gatewayCallsign .="G";
		$result .= 'gatewayCallsign='.strtoupper($gatewayCallsign)."\n";
	} else if (startsWith($line, "latitude=")) {
		$result .= 'latitude='.$_POST['LATITUDE']."\n";
	} else if (startsWith($line, "longitude=")) {
		$result .= 'longitude='.$_POST['LONGITUDE']."\n";
	} else if (startsWith($line, "latitude1=")) {
		$result .= 'latitude1='.$_POST['LATITUDE']."\n";
	} else if (startsWith($line, "longitude1=")) {
		$result .= 'longitude1='.$_POST['LONGITUDE']."\n";
	} else if (startsWith($line, "description1=")) {
		$result .= 'description1='.$_POST['QTH']."\n";
	} else if (startsWith($line, "description1_1=")) {
		$result .= 'description1_1='.$_POST['QTH']."\n";
	} else if (startsWith($line, "frequency1")) {
		$result .= 'frequency1='.$_POST['QRG']."\n";
	} else if (startsWith($line, "ircddbUsername=")) {
		$result .= 'ircddbUsername='.strtoupper($_POST['CALLSIGN'])."\n";
	} else if (startsWith($line, "dplusLogin=")) {
		$result .= 'dplusLogin='.strtoupper($_POST['CALLSIGN'])."\n";
	} else {
		$result .= $line;
	}
}
file_put_contents('/etc/ircddbgateway', $result);

$lines = file('/etc/mmdvm/MMDVM.ini');
$result = '';

$section='';
foreach($lines as $line) {
	if(startsWith($line,"[")) {
		$section=trim($line);
	}
	if(startsWith($line, "Callsign=")) {
		$result .= 'Callsign='.strtoupper($_POST['CALLSIGN'])."\n";
	} else if (startsWith($line, "Id=")) {
		$result .= 'Id='.$_POST['ID']."\n";
	} else if (startsWith($line, "RXFrequency=")) {
		$result .= 'RXFrequency='.$_POST['QRG']."\n";
	} else if (startsWith($line, "TXFrequency=")) {
		$result .= 'TXFrequency='.$_POST['QRG']."\n";
	} else if (startsWith($line, "Location=")) {
		$result .= 'Location='.$_POST['QTH']."\n";
	} else if (startsWith($line, "Enable=")) {
		switch ($section) {
		case "[DMR]":
			if ($_POST['ENABLEDMR']===on) {
				$result .= "Enable=1\n";
			} else {
				$result .= "Enable=0\n";
			}
			break;
		case "[D-Star]":
			if ($_POST['ENABLEDSTAR']===on) {
				$result .= "Enable=1\n";
			} else {
				$result .= "Enable=0\n";
			}
			break;
		case "[System Fusion]":
			if ($_POST['ENABLEYSF']===on) {
				$result .= "Enable=1\n";
			} else {
				$result .= "Enable=0\n";
			}
			break;
		case "[DMR Network]":
			if ($_POST['ENABLEDMR']===on) {
				$result .= "Enable=1\n";
			} else {
				$result .= "Enable=0\n";
			}
			break;
		case "[D-Star Network]":
			if ($_POST['ENABLEDSTAR']===on) {
				$result .= "Enable=1\n";
			} else {
				$result .= "Enable=0\n";
			}
			break;
		case "[System Fusion Network]":
			if ($_POST['ENABLEYSF']===on) {
				$result .= "Enable=1\n";
			} else {
				$result .= "Enable=0\n";
			}
			break;
		default:
			$result .= $line;
		}
	} else {
		$result .= $line;
	}
}
file_put_contents('/etc/mmdvm/MMDVM.ini', $result);

if (file_exists ("/var/www/html/unconfigured")) {
	unlink("/var/www/html/unconfigured");
}
?>
<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <!-- Das neueste kompilierte und minimierte CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Optionales Theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <!-- Das neueste kompilierte und minimierte JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <title>easyBrandMeister</title>
  </head>
  <body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Titel und Schalter werden für eine bessere mobile Ansicht zusammengefasst -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Navigation ein-/ausblenden</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">easyBM</a>
    </div>

    <!-- Alle Navigationslinks, Formulare und anderer Inhalt werden hier zusammengefasst und können dann ein- und ausgeblendet werden -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="/MMDVMHost-Dashboard/">Dashboard <span class="sr-only">(aktuell)</span></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/admin/admin.php">Admin</a></li>
            <li><a href="/admin/system.php">System</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="/logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><img src="/images/bmlogo_50.jpg"></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
  <div class="container">
<div class="jumbotron">
  <h1>easyBrandMeister <small>DVMEGA-Hotspot</small></h1>
  <p>Control-Center for easy access to digital voice communication in amateur radio.</p>
  <p>Congratulations! Your Settings has been saved. Please restart services or reboot system with "Admin" - "System"</p>
</div>
  </div>
  </body>
</html>
