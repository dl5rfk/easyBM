#!/bin/bash
#
#by DL5RFK, use it as is....
#
#LAST CHANGE: 2017-01-04

/usr/bin/which apt
if  [ $? -gt 0 ]; then 
	echo "Sorry, 'apt' not found ! ... is this a Debian OS ?"
	exit 1;
fi 
/usr/bin/which git
if  [ $? -gt 0 ]; then 
	echo "Sorry, please install 'git' !....OK"
	apt install git
fi 
/usr/bin/which whiptail
if  [ $? -gt 0 ]; then
        echo "Sorry, please install 'whiptail' !...OK"
        apt install whiptail
fi

while : ; do
choice=$(whiptail --title "easyBM Service Menu [Ver. 20170105 by dl5rfk]" --menu "\n\nPlease select:\n" 25 70 15 \
11 " Show IP-Addresses of this host " \
12 " Show todays MMDVMHost Logfile " \
13 " Show todays YSFGateway Logfile " \
21 " Edit 'interfaces' configuration file " \
22 " Edit 'MMDVM.ini' configuration file " \
23 " Edit 'ircddbgateway' configuration file " \
24 " Edit 'easyBM' Cronjobs " \
25 " Edit 'YFSGateway' configuration file " \
26 " Edit WIFI 'wpa_supplicant' file " \
27 " Edit WIFI with wicd-curses " \
31 " Setup ircddbgateway " \
41 " Set File Permission of MMDVM.ini file " \
61 " Update D-Star Reflektor list " \
62 " Update RPi Operating System " \
63 " Update easyBM Scripts " \
64 " Update MMDVMHost Software " \
65 " Update MMDVMHost-Dashboard " \
66 " Update YSFGateway Software " \
71 " Turn off SWAP file " \
72 " Turn off ttyAMA0 service " \
73 " Cleanup .ini Files " \
81 " Backup all files into one tar-File" \
82 " Clone SD-Card with rpi-clone" \
91 " Restart MMDVMHost " \
92 " Restart ircddbgateway " \
93 " Restart YFSGateway " \
94 " Restart lighttpd " \
95 " Restart cron " \
98 " Reboot System" \
99 " Exit this menu "  3>&1 1>&2 2>&3)

exitstatus=$?
if [ $exitstatus = 0 ]; then
    echo "Your chosen option:" $choice
else
    echo "You chose Cancel. Have a nice day. "; break;
fi

case $choice in
11) /usr/bin/sudo whiptail --title "IP Address" --msgbox "A list of all interfaces: \n\n `ip addr show`" 25 70;;
12) [ -w "/mnt/ramdisk/MMDVM-`date -I`.log" ] && /usr/bin/sudo /usr/bin/less /mnt/ramdisk/MMDVM-`date -I`.log || (echo "  Sorry, file not found! Please wait 5 seconds..."; sleep 5);;
13) [ -w "/mnt/ramdisk/YFSGateway-`date -I`.log" ] && /usr/bin/sudo /usr/bin/less /mnt/ramdisk/YFSGateway-`date -I`.log || (echo "  Sorry, file not found! Please wait 5 seconds..."; sleep 5);;
21) [ -w "/etc/network/interfaces" ] && /usr/bin/sudo /usr/bin/nano /etc/network/interfaces || (echo "   Sorry, file not found! Please wait 5 seconds..."; sleep 5) ;;
22) [ -w "/opt/MMDVMHost/MMDVM.ini" ] && /usr/bin/sudo /usr/bin/nano /opt/MMDVMHost/MMDVM.ini || (echo "   Sorry, file not found! Please wait 5 seconds..."; sleep 5) ;;
23) [ -w "/etc/ircddbgateway" ] && /usr/bin/sudo /usr/bin/nano /etc/ircddbgateway || (echo "   Sorry, file not found! Please wait 5 seconds..."; sleep 5) ;;
24) [ -w "/etc/cron.d/easyBM" ] && /usr/bin/sudo /usr/bin/nano /etc/cron.d/easyBM || (echo "   Sorry, file not found! Please wait 5 seconds..."; sleep 5) ;;
25) [ -w "/etc/YSFGateway/YSFGateway.ini" ] && /usr/bin/sudo /usr/bin/nano /etc/YSFGateway/YSFGateway.ini || (echo "Sorry, file not found! Please wait 5 seconds..."; sleep 5) ;;
26) /usr/bin/sudo iwlist wlan0 scan|/bin/egrep "(ESSID|IEEE)" ; echo "Search for your WIFI SSID, remeber it !"; sleep 10 && /usr/bin/sudo nano /etc/wpa_supplicant/wpa_supplicant.conf ;; 
27) [ -x "/usr/bin/wicd-curses" ] && /usr/bin/sudo wicd-curses || (echo "Sorry, Programm not found! Please wait 5 seconds..."; sleep 5);;
31) [ -x "/usr/bin/ircddbgw_conf" ] && /usr/bin/sudo /usr/bin/ircddbgw_conf || (echo "Sorry, Programm not found! Please wait 5 seconds..."; sleep 5) ;;
41) [ -w "/opt/MMDVMHost/MMDVM.ini" ] && chmod 666 /opt/MMDVMHost/MMDVM.ini || (echo "   Sorry, file not found! Please wait 5 seconds..."; sleep 5) ;;
61) /opt/easyBM/easyBM-Update-DStar-Hostfiles.sh ;;
62) 
	clear
	sudo apt update && sudo apt upgrade && sudo apt-get autoremove && sudo apt-get autoclean
	echo
	read -p " Update done, press [Enter] to continue..."
 	;;
63) 
	clear
	cd /opt/easyBM
	/usr/bin/sudo /usr/bin/git pull
	read -p " Update done, press [Enter] to continue..."
	;;
64) 
	clear
	if [ ! -d "/opt/MMDVMHost" ]; then 
	  echo "Sorry, MMDVMHost directory does not exists in /opt/ !" 
	  exit 1;
	fi
	 cd /opt/MMDVMHost/ && /usr/bin/sudo /bin/cp /opt/MMDVMHost/MMDVM.ini /opt/MMDVMHost/MMDVM.ini.`/bin/date -I`
	/usr/bin/sudo /usr/bin/git pull
	# mit SED version ergaenzen um -ebm
	if [ $? -eq 0 ]; then
	 /usr/bin/sudo /usr/bin/make clean all && sudo /bin/systemctl stop mmdvmhost.service && sudo /bin/systemctl start mmdvmhost.service
	else 
	 rm /opt/MMDVMHost/MMDVM.ini && /usr/bin/sudo /usr/bin/git pull 
	 /usr/bin/sudo /usr/bin/make clean all && sudo /bin/systemctl stop mmdvmhost.service && sudo /bin/systemctl start mmdvmhost.service
	fi
	read -p " Update done, press [Enter] to continue..."
	;;
65) 
	clear
	cd /var/www/html/MMDVMHost-Dashboard 
	/bin/cp /var/www/html/MMDVMHost-Dashboard/config/config.php /var/www/html/MMDVMHost-Dashboard/config/config.php.`/bin/date -I` && /usr/bin/git pull 
	if [ -w /var/www/html/MMDVMHost-Dashboard/setup.php ]; then
	/bin/mv /var/www/html/MMDVMHost-Dashboard/setup.php /var/www/html/MMDVMHost-Dashboard/setup.php.offline 
	fi
	read -p " Update done, press [Enter] to continue..."
	;;

66)
	clear
	if [ ! -d "/opt/YSFClients/YSFGateway" ]; then
          echo "Sorry, YSFGateway directory does not exists in /opt/YSFClients !"
          exit 1;
        fi
	cd /opt/YSFClients/YSFGateway/
	/usr/bin/sudo /usr/bin/git pull
	/usr/bin/sudo /usr/bin/make clean all
	echo
	echo "Old Version of YSFGateway is"
	/usr/local/bin/YSFGateway --version
	echo
	/usr/bin/sudo /etc/init.d/YSFGateway stop
	/usr/bin/sudo cp /opt/YSFClients/YSFGateway/YSFGateway /usr/local/bin/YSFGateway
	echo
	echo "New Version of YSFGateway is"
	/usr/local/bin/YSFGateway --version
	echo 
	/usr/bin/sudo /etc/init.de/YSFGateway start
	
	read -p " Update done, press [Enter] to continue..."
;;
71) /usr/bin/sudo dphys-swapfile swapoff; if [ $?=0 ]; then /usr/bin/sudo whiptail --title "SWAP File" --msgbox "\n\nNow swapping is off !\n\n" 30 70; fi;;
72) /usr/bin/sudo systemctl stop serial-getty@ttyAMA0.service && /usr/bin/sudo systemctl disable serial-getty@ttyAMA0.service && /usr/bin/sudo whiptail --title "ttyAMA0 Status" --msgbox "Please check the file permissions, owner has to be root and the group has to be dailout.\n\n\ `ls -ls /dev/ttyAMA0`" 30 70;;
73) 
	/usr/bin/find /opt/MMDVM/ -name "*.ini" -exec sed -i -re 's/^(\s*)#(.*)/\1;\2/g' {} \; 
	/usr/bin/find /etc/YSFGateway/ -name "*.ini" -exec sed -i -re 's/^(\s*)#(.*)/\1;\2/g' {} \;
	;;
81)
	clear
	if [ ! -d "/opt/backup" ]; then
   	 /usr/bin/sudo /bin/mkdir /opt/backup
	fi

	if [-w /var/www/html/MMDVMHost-Dashboard/config/config.php ]; then
	 /usr/bin/sudo /bin/cp /var/www/html/MMDVMHost-Dashboard/config/config.php /var/www/html/MMDVMHost-Dashboard/config/config.php.`/bin/date -I`
	 /usr/bin/sudo /bin/cp /var/www/html/MMDVMHost-Dashboard/config/config.php.`/bin/date -I` /opt/backup
	fi

	if [ -w /opt/MMDVMHost/MMDVM.ini ]; then
	 /usr/bin/sudo /bin/cp /opt/MMDVMHost/MMDVM.ini /opt/MMDVMHost/MMDVM.ini.`/bin/date -I`
	 /usr/bin/sudo /bin/cp /opt/MMDVMHost/MMDVM.ini.`/bin/date -I` /opt/backup
	fi

	if [ -w /etc/YSFGateway/YSFGateway.ini ]; then
	 /usr/bin/sudo /bin/cp /etc/YSFGateway/YSFGateway.ini /opt/backup/YSFGateway.ini.`/bin/date -I`
	fi

	if [ -w /etc/ircddbgateway ];then
	 /usr/bin/sudo /bin/cp /etc/ircddbgateway /opt/backup/ircddbgateway.`/bin/date -I`
	fi
	
	 /usr/bin/sudo /bin/tar -cvzf /opt/backup/easyBM-Backup-`date -I`.tar.gz /etc /opt/ /var/www/

	echo
	echo "DONE......................................................................."
	echo
	echo " YOU CAN FIND THE BACKUP FILE AT /opt/backup/easyBM-Backup-`date -I`.tar.gz"
	echo " Please copy the .tar.gz file to your local backup-storage, now."
	echo
	echo "Content of your Backup directory: "
	
	ls -lsa /opt/backup/
	echo 
	echo
	read -p " Backup done, press [Enter] to continue..."
;;
82) clear; echo; /usr/local/sbin/rpi-clone; read -p " Clone created, press [Enter] to continue...";;
91) clear; echo; /usr/bin/sudo systemctl restart mmdvmhost.service && /usr/bin/sudo systemctl status mmdvmhost.service; read -p " Restart done, press [Enter] to continue...";;
92) clear; echo; /usr/bin/sudo systemctl restart ircddbgateway.service; read -p " Restart done, press [Enter] to continue...";;
93) clear; echo; /etc/init.de/YSFgateway stop && /etc/init.d/YSFGateway start; read -p " Restart done, press [Enter] to continue...";;
94) clear; echo; /usr/bin/sudo systemctl restart lighttpd.service && /usr/bin/sudo systemctl status lighttpd.service; read -p " Restart done, press [Enter] to continue...";;
95) clear; echo; /usr/bin/sudo systemctl restart cron.service; read -p " Restart done, press [Enter] to continue...";;
98) clear; echo; /usr/bin/sudo reboot;;
99) clear; echo; /bin/cat /etc/motd && exit;;
esac

done

clear
cat /etc/motd
exit 0
