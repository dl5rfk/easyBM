#!/bin/bash
#
#by DL5RFK, use it as is....
#
#LAST CHANGE: 2016-11-15


/usr/bin/which apt
if  [ $? -gt 0 ]; then 
	echo "Sorry, please install 'apt' !"
	exit 1;
fi 
/usr/bin/which git
if  [ $? -gt 0 ]; then 
	echo "Sorry, please install 'git' !"
	apt install git
fi 
/usr/bin/which whiptail
if  [ $? -gt 0 ]; then
        echo "Sorry, please install 'whiptail' !"
        apt install whiptail
fi

while : ; do
choice=$(whiptail --title "easyBM Service Menu [Ver. 20161119]" --menu "\n\nPlease select:\n" 30 70 20 \
11 " Show IP-Addresses of this host " \
12 " Show todays MMDVMHost Logfile " \
21 " Edit Network 'interfaces' configuration file " \
22 " Edit 'MMDVM.ini' configuration file " \
23 " Edit 'ircddbgateway' configuration file " \
24 " Edit easyBM Cronjobs " \
25 " Edit YFSGateway configuration file " \
61 " Update D-Star Reflektor list " \
62 " Update RPi Operating System " \
63 " Update easyBM Scripts " \
64 " Update MMDVMHost Software " \
65 " Update MMDVMHost-Dashboard " \
71 " Turn off SWAP file " \
72 " Turn off ttyAMA0 service " \
91 " Restart MMDVM deamon " \
92 " Restart ircddbgateway deamon " \
93 " Restart Webserver lighttpd " \
98 " Reboot System" \
99 " Exit this menu "  3>&1 1>&2 2>&3)

exitstatus=$?
if [ $exitstatus = 0 ]; then
    echo "Your chosen option:" $choice
else
    echo "You chose Cancel. Have a nice day. "; break;
fi


case $choice in
11) /usr/bin/sudo whiptail --title "IP Address" --msgbox "A list of all interfaces: \n\n `ip addr show`" 30 70;;
12) /usr/bin/sudo /usr/bin/less /mnt/ramdisk/MMDVM-`date -I`.log;;
21) [ -w "/etc/network/interfaces" ] && /usr/bin/sudo /usr/bin/nano /etc/network/interfaces || (echo "   Sorry, file not found! Please wait..."; sleep 15) ;;
22) [ -w "/opt/MMDVMHost/MMDVM.ini" ] && /usr/bin/sudo /usr/bin/nano /opt/MMDVMHost/MMDVM.ini || (echo "   Sorry, file not found! Please wait..."; sleep 15) ;;
23) [ -w "/etc/ircddbgateway" ] && /usr/bin/sudo /usr/bin/nano /etc/ircddbgateway || (echo "   Sorry, file not found! Please wait..."; sleep 15) ;;
24) [ -w "/etc/cron.d/easyBM" ] && /usr/bin/sudo /usr/bin/nano /etc/cron.d/easyBM || (echo "   Sorry, file not found! Please wait..."; sleep 15) ;;
25) [ -w "/etc/YSFGateway/YSFGateway.ini" ] && /usr/bin/sudo /usr/bin/nano /etc/YSFGateway/YSFGateway.ini || (echo "Sorry, file not found"; sleep 15) ;;
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
	git pull
	read -p " Update done, press [Enter] to continue..."
	;;
64) 
	clear
	if [ ! -d "/opt/MMDVMHost" ]; then 
	  echo "Sorry, MMDVMHost directory not exists in /opt/ !" 
	  exit 1;
	fi
	cd /opt/MMDVMHost/ && /bin/cp /opt/MMDVMHost/MMDVM.ini /opt/MMDVMHost/MMDVM.ini.`/bin/date -I` && /usr/bin/git pull
	if [ $? -eq 0 ]; then
	  /usr/bin/make && /bin/systemctl stop mmdvmhost.service && /bin/systemctl start mmdvmhost.service
	fi
	read -p " Update done, press [Enter] to continue..."
	;;
65) 
	clear
	cd /var/www/html/MMDVMHost-Dashboard 
	/bin/cp /var/www/html/MMDVMHost-Dashboard/config/config.php /var/www/html/MMDVMHost-Dashboard/config/config.php.`/bin/date -I` && /usr/bin/git pull 
	/bin/mv /var/www/html/MMDVMHost-Dashboard/setup.php /var/www/html/MMDVMHost-Dashboard/setup.php.offline 
	read -p " Update done, press [Enter] to continue..."
	;;
71) /usr/bin/sudo dphys-swapfile swapoff; if [ $?=0 ]; then /usr/bin/sudo whiptail --title "SWAP File" --msgbox "\n\nNow swapping is off !\n\n" 30 70; fi;;
72) /usr/bin/sudo systemctl stop serial-getty@ttyAMA0.service && /usr/bin/sudo systemctl disable serial-getty@ttyAMA0.service && /usr/bin/sudo whiptail --title "ttyAMA0 Status" --msgbox "Please check the file permissions, owner has to be root and the group has to be dailout.\n\n\ `ls -ls /dev/ttyAMA0`" 30 70;;
91) /usr/bin/sudo systemctl restart mmdvmhost.service;;
92) /usr/bin/sudo systemctl restart ircddbgateway.service;;
93) /usr/bin/sudo systemctl restart lighttpd.service;;
98) /usr/bin/sudo reboot;;
99) /bin/cat /etc/motd && exit;;
esac

done

clear
cat /etc/motd
exit 0
