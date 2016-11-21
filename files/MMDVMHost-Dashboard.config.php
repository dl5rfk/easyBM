<?php
# This is an auto-generated config-file!
# Be careful, when manual editing this!

date_default_timezone_set('UTC');
define("MMDVMLOGPATH", "/mnt/ramdisk/");
define("MMDVMINIPATH", "/opt/MMDVMHost/");
define("MMDVMINIFILENAME", "MMDVM.ini");
define("MMDVMHOSTPATH", "/opt/MMDVMHost/");
define("ENABLEXTDLOOKUP", "on");
define("DMRIDDATPATH", "/opt/MMDVMHost/DMRIds.dat");
define("ENABLEYSFGATEWAY", "on");
define("YSFGATEWAYLOGPATH", "/var/log/YSFGateway/");
define("YSFGATEWAYLOGPREFIX", "YFSGateway");
define("YSFGATEWAYINIPATH", "/etc/YFSGateway/");
define("YSFGATEWAYINIFILENAME", "YFSGateway.ini");
define("YSFHOSTSPATH", "/etc/YFSGateway/");
define("YSFHOSTSFILENAME", "YSFHosts.txt");
define("LINKLOGPATH", "/var/log");
define("IRCDDBGATEWAY", "ircddbgatewayd");
define("TIMEZONE", "UTC");
define("LOGO", "http://bm262.de/wp-content/uploads/2016/04/brandmeister.png");
define("DMRPLUSLOGO", "https://pbs.twimg.com/profile_images/584055514180386817/sxEbpw8n.jpg");
define("BRANDMEISTERLOGO", "http://bm262.de/wp-content/uploads/2016/04/brandmeister.png");
define("REFRESHAFTER", "30");
define("SHOWPROGRESSBARS", "on");
define("TEMPERATUREALERT", "on");
define("TEMPERATUREHIGHLEVEL", "60");
define("ENABLENETWORKSWITCHING", "on");
define("SWITCHNETWORKUSER", "root");
define("SWITCHNETWORKPW", "raspberry");
define("ENABLEMANAGEMENT", "on");
define("VIEWLOGUSER", "root");
define("VIEWLOGPW", "raspberry");
define("HALTUSER", "root");
define("HALTPW", "raspberry");
define("REBOOTUSER", "root");
define("REBOOTPW", "raspberry");
define("RESTARTUSER", "root");
define("RESTARTPW", "raspberry");
define("REBOOTMMDVM", "sudo systemctl restart mmdvmhost.service");
define("REBOOTSYS", "sudo reboot");
define("HALTSYS", "sudo halt");
define("POWERONLINEPIN", "18");
define("POWERONLINESTATE", "1");
define("SHOWQRZ", "on");
?>
