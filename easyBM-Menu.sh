#!/bin/bash
#
#by DL5RFK, use it as is....
#

while : ; do
choice=$(whiptail --title "easyBM Service Menu" --menu "\n\nPlease select:\n" 30 70 20 \
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
64 " Update MMDVMHost-Dashboard " \
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
21) /usr/bin/sudo /usr/bin/nano /etc/network/interfaces;;
22) /usr/bin/sudo /usr/bin/nano /opt/MMDVMHost/MMDVM.ini;;
23) /usr/bin/sudo /usr/bin/nano /etc/ircddbgateway;;
24) /usr/bin/sudo /usr/bin/nano /etc/cron.d/easyBM;;
25) /usr/bin/sudo /usr/bin/nano /etc/YSFGateway/YSFGateway.ini ;;
61) /opt/easyBM/easyBM-Update-DStar-Hostfiles.sh;;
62) 
	clear
	sudo apt update && sudo apt upgrade
	echo
	read -p " Update done, press [Enter] to continue..."
 	;;
63) /usr/bin/sudo whiptail --title "Sorry" --msgbox "I am so sorry, but this function is still under construction! \n\n `ip addr show`" 30 70;; 
64) /bin/mv /opt/MMDVMHost/MMDVM.ini /opt/MMDVMHost/MMDVM.ini.backup.`/bin/date -I` && cd /opt/MMDVMHost/ && /usr/bin/git pull ;;
65) cd /var/www/html/MMDVMHost-Dashboard && /usr/bin/git pull && /bin/mv /var/www/html/MMDVMHost-Dashboard/setup.php /var/www/html/MMDVMHost-Dashboard/setup.php.offline ;;
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
