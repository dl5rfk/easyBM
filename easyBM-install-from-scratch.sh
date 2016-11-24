#!/bin/bash 

#define functions
function pause(){
 echo
 read -n1 -rsp $" Press space to continue or Ctrl+C to exit..."
 echo
}

# Defning return code check function
check_result() {
    if [ $1 -ne 0 ]; then
        echo "Error: $2"
        exit $1
    fi
}

clear
echo 
echo 
echo
echo 
echo " Installing .......... "
echo "                       ____  __  __ "
echo "   ___  __ _ ___ _   _| __ )|  \/  |"
echo "  / _ \/ _  / __| | | |  _ \| |\/| |"
echo " |  __/ (_| \__ \ |_| | |_) | |  | |"
echo "  \___|\__,_|___/\__| |____/|_|  |_|"
echo "                 |___/              "
echo 
echo 
echo "************************************************"
echo "*      FOR INTERNAL USE ONLY                   *"
echo "************************************************"

if [ ! $( id -u ) -eq 0 ]; then
  echo "  ERROR: $0 Must be run as root, Script terminating" 1>&2; exit 7; 
fi

# Checking root permissions
if [ "x$(id -u)" != 'x0' ]; then
    check_error 1 "Script can be run executed only by root"
fi

if [ ! -d "/opt/easyBM/" ]; then
  echo "  ERROR: $0 need source direcotry /opt/easyBM"; exit 7;
fi

# Detect OS
case $(head -n1 /etc/issue | cut -f 1 -d ' ') in
    Debian)     type="debian" ;;
    Ubuntu)     type="ubuntu" ;;
    Raspbian)   type="raspbian" ;;
    *)          type="rhel" ;;
esac

echo -e "\n\n + first time update and upgrade\n"
sudo apt update && sudo apt upgrade 
check_result $? 'apt upgrade failed'

pause

echo -e "\n\n + installing Tools\n"
sudo apt install git screen vim  rrdtool curl whiptail g++ gcc make nano net-tools rsync build-essential

# Checking wget
if [ ! -e '/usr/bin/wget' ]; then
    apt-get -y install wget
    check_result $? "Can't install wget"
fi

pause

echo -e "\n\n + diable bluetooth\n"
sudo bash -c 'echo "dtoverlay=pi3-disable-bt" >> /boot/config.txt'
sudo systemctl stop serial-getty@ttyAMA0.service
sudo systemctl disable serial-getty@ttyAMA0.service 
echo -e "\n\n Please check the file permissions, owner has to be root and the group has to be dailout."
ls -ls /dev/ttyAMA0

echo -e "\n\n Add group dailout and change owner to root:dailout\n"

pause

echo -e "\n\n + installing NTP\n"
sudo apt install ntp ntpdate && sudo systemctl enable ntp && sudo systemctl start ntp
# NTP Synchronization
echo '#!/bin/sh' > /etc/cron.daily/ntpdate
echo "$(which ntpdate) -s pool.ntp.org" >> /etc/cron.daily/ntpdate
chmod 775 /etc/cron.daily/ntpdate
ntpdate -s pool.ntp.org

pause

echo -e "\n\n + installing ramdisk\n" 
sudo mkdir /mnt/ramdisk /mnt/pendrive /mnt/diskdrive
##FIXME, checken ob es schon dirn steht##
echo "tmpfs /mnt/ramdisk  tmpfs nodev,nosuid,noexec,nodiratime,size=64M 0 0" >> /etc/fstab
mount -a
echo -e "\n\n + now, check if ramdrive has 64MB\n\n"
df -h

pause

echo -e "\n\n + installing Webserver lighttpd\n"
sudo apt install lighttpd php5-common php5-cgi php5
sudo lighty-enable-mod fastcgi
sudo lighty-enable-mod fastcgi-php
sudo service lighttpd restart
sudo rm /var/www/html/index.html
sudo rm /var/www/html/index.lighttpd.html
sudo usermod -a -G www-data pi
sudo usermod -a -G gpio www-data
## FIXME, checken ob es schon drin steht##
echo "www-data ALL=(ALL) NOPASSWD: ALL " >> /etc/sudoers

pause 

echo -e "\n\n + installing and updating wiringPi\n"
if [ ! -d "/opt/wiringPi/" ]; then
 cd /opt/
 git clone git://git.drogon.net/wiringPi
else 
 cd /opt/wiringPi
 git pull origin
fi
bash -c '/opt/wiringPi/build'
gpio -v
gpio readall

pause

echo -e "\n\n + installing MMDVMCal\n"
cd /opt
sudo git clone https://github.com/g4klx/MMDVMCal.git
sudo cd /opt/MMDVMCal
sudo make

pause

echo -e "\n\n + installing MMDVMHost\n"
cd /opt
sudo git clone https://github.com/g4klx/MMDVMHost.git
cd /opt/MMDVMHost
sudo make clean
sudo make
sudo chown -v www-data:www-data /opt/MMDVMHost/MMDVM.ini
sudo cp -f /opt/MMDVMHost/MMDVM.ini /opt/MMDVMHost/MMDVM.ini.origin

pause

echo -e "\n\n + installing systemd Service for MMDVMHost\n"
echo " 
[Unit]
Description=MMDVM Host Service
After=syslog.target network.target

[Service]
User=root
WorkingDirectory=/opt/MMDVMHost
ExecStart=/usr/bin/screen -S MMDVMHost -D -m /opt/MMDVMHost/MMDVMHost /opt/MMDVMHost/MMDVM.ini
ExecStop=/usr/bin/screen -S MMDVMHost -X quit

[Install]
WantedBy=multi-user.target

" > /lib/systemd/system/mmdvmhost.service

sudo chmod 644 /lib/systemd/system/mmdvmhost.service
sudo ln -s /lib/systemd/system/mmdvmhost.service /etc/systemd/system/mmdvmhost.service

pause

echo -e "\n\n + installing systemd Timer for MMDVMHost\n"
echo "
[Timer]
OnStartupSec=60

[Install]
WantedBy=multi-user.target
" > /lib/systemd/system/mmdvmhost.timer

sudo chmod 644 /lib/systemd/system/mmdvmhost.timer
sudo ln -s /lib/systemd/system/mmdvmhost.timer /etc/systemd/system/mmdvmhost.timer

sudo systemctl daemon-reload 
sudo systemctl enable mmdvmhost.timer

pause 

echo -e "\n\n + installing MMDVMHost-Dashboard\n"
cd /var/www/html/
sudo git clone https://github.com/dg9vh/MMDVMHost-Dashboard.git 
sudo chown -Rv www-data:www-data /var/www/html/MMDVMHost-Dashboard/*
sudo mv /var/www/html/MMDVMHost-Dashboard/setup.php /var/www/html/MMDVMHost-Dashboard/dashboard.setup.php


pause

echo -e "\n\n + installing ircddbgateway\n"
cd /tmp
wget http://repo1.ham-digital.net/debian/dl5di.pk 
sudo apt-key add dl5di.pk     
##FIXME, das repo ist veraltet, ein neues liegt in files##
sudo curl http://repo1.ham-digital.net/raspbian/opendv.list -o /etc/apt/sources.list.d/opendv.list
sudo apt update && sudo apt upgrade && sudo apt install ircddbgateway

#Passe die Pfade an, z.B. auf /mnt/ramdisk/opendv
# vim /etc/default/ircddbgateway
# vim /var/www/html/ircddbgateway/ircddblocal.php 

sudo mv /ircddbgw_conf.README /home/opendv/
sudo mkdir /var/www/html/ircddbgateway
sudo mv /var/www/css/ /var/www/html/ircddbgateway/
sudo mv /var/www/dashboard_stn.php /var/www/html/ircddbgateway/
sudo mv /var/www/dhcpfunctions.php /var/www/html/ircddbgateway/
sudo mv /var/www/dhcpleases.php /var/www/html/ircddbgateway/
sudo mv /var/www/images/ /var/www/html/ircddbgateway/
sudo mv /var/www/ircddbgateway.php /var/www/html/ircddbgateway/
sudo mv /var/www/ircddblocal.php.sample /var/www/html/ircddbgateway/
sudo cp /var/www/html/ircddbgateway/ircddblocal.php.sample /var/www/html/ircddbgateway/ircddblocal.php
sudo mv /var/www/nmap-mac-prefixes /var/www/html/ircddbgateway/
sudo mv /var/www/opendv-1.hlp /var/www/html/ircddbgateway/
sudo mv /var/www/opendvconfig.php /var/www/html/ircddbgateway/
sudo echo "<?php header('Location: ircddbgateway.php'); ?>" > /var/www/html/ircddbgateway/index.php
sudo chown -R www-data:www-data /var/www/html/ircddbgateway/

ls -lsa /etc/ircddbgateway
ls -lsa /home/opendv/ircddbgateway/ircddbgateway
chmod 666 /home/opendv/ircddbgateway/ircddbgateway

pause 

echo -e "\n\n + installing C4FM YSF Software\n"
cd /opt
git clone https://github.com/g4klx/YSFClients.git
cd /opt/YSFClients/YSFGateway
make clean all
sudo cp /opt/YSFClients/YSFGateway/YSFGateway /usr/local/bin/
sudo mkdir /etc/YSFGateway 
sudo cp -f /opt/YSFClients/YSFGateway/YSFGateway.ini /etc/YSFGateway/
sudo cp -f /opt/YSFClients/YSFGateway/YSFHosts.txt /etc/YSFGateway/
sudo mkdir -p /var/log/YSFGateway
##FIXME, die gurppe gibt es nicht##
sudo chgrp mmdvm /var/log/YSFGateway
sudo chmod g+w /var/log/YSFGateway

pause

echo -e "\n\n + copying files\n"
sudo cp -f /opt/easyBM/files/easyBM.cronjob /etc/cron.d/easyBM.cronjob
sudo cp -f /opt/easyBM/files/99-easyBM.conf /etc/lighttpd/conf-enabled/99-easyBM.conf
sudo cp -f /opt/easyBM/files/.bash_login /home/pi/.bash_login && sudo chown pi:pi /home/pi/.bash_login

echo -e "\n\n + restarting services\n"
sudo systemctl restart lighttpd
sudo systemctl restart cron

pause 

echo -e "\n\n + Setup for first use\n"
sudo touch /var/www/html/UNCONFIGURED
echo "<?php if (file_exists('UNCONFIGURED')){ header('Location:/admin/init.php'); } else { header('Location:/MMDVMHost-Dashboard/index.php'); } ?>" > /var/www/html/index.php

echo -e "\n\n + clean up...\n"
sudo apt-get autoclean
sudo apt-get autoremove

pause


echo -e "\n\n + creating login message\n"
echo "
__________________________________________________________________________

  Thank you for using easyBM, a Linux Image made by the German BM Group

  Start the Service-Menu by running  /opt/easyBM/easyBM-Menu.sh

  Please do not hesitate to contact us http://easybm.bm262.de 

	Notice:	
		 Check Service Status with
		 # sudo systemctl status mmdvmhost.service

		 Restart Service with
		 # sudo systemctl restart mmdvmhost.service
__________________________________________________________________________

Version `date -I` is ready to start......

" > /etc/motd

pause

echo -e "\n\n + Disk usage\n"
df -h 
echo -e "\n\n + ALL DONE ......\n" 
echo 
echo 
echo
echo -e "Congratulations, you have just successfully installed \

 easyBM

We hope that you enjoy your installation of easyBM. Please \
feel free to contact us anytime if you have any questions.
Thank you.

--
Sincerely yours
bm262.de team
"
