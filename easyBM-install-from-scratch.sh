#!/bin/bash 
# by DL5RFK
# it is created for internal use only
# DO NOT USE THIS SCRIPT AS A NORMAL USER
# THIS SCRIPT IS NOT SUPPORTED
# if you have any suggestion, please contact us via www.bm262.de
#

# Define Variables
export PATH=$PATH:/sbin
export DEBIAN_FRONTEND=noninteractive
memory=$(grep 'MemTotal' /proc/meminfo |tr ' ' '\n' |grep [0-9])
arch=$(uname -i)
release=$(cat /etc/debian_version|grep -o [0-9]|head -n1)
codename="$(cat /etc/os-release |grep VERSION= |cut -f 2 -d \(|cut -f 1 -d \))"

# Define functions
function pause(){
 echo
 read -n1 -rsp $" Check the previous printout and press space to continue or Ctrl+C to abort !"
 echo
}

# Defning return code check function
check_result() {
    if [ $1 -ne 0 ]; then
        echo "Error: $2"
        exit $1
    fi
}

#
#START 
#
clear
echo 
echo 
echo " Installing ....................... "
echo "                       ____  __  __ "
echo "   ___  __ _ ___ _   _| __ )|  \/  |"
echo "  / _ \/ _  / __| | | |  _ \| |\/| |"
echo " |  __/ (_| \__ \ |_| | |_) | |  | |"
echo "  \___|\__,_|___/\__| |____/|_|  |_|"
echo "                 |___/              "
echo 
echo "  easyBM is based on an idear of the"
echo "  German BrandMeister Support-Team  "
echo 
echo "  Licenced under the GNU Licence " 
echo "************************************************"
echo "*            FOR INTERNAL USE ONLY             *"
echo "************************************************"
echo
echo " I found.... $arch "
echo " I found.... $release as OS Release"
echo " I found.... $codename as Codename"
echo " You have... $memory KB Memory"
echo
echo " Please relax and watch the screen.............."
echo
echo
echo
pause

echo "  +++ We do some first checks ...."
sleep 1
echo "  ."
sleep 1
echo "  ."
sleep 1
if [ ! $( id -u ) -eq 0 ]; then
  echo "  ERROR: $0 Must be run as user root, Script terminating" 1>&2; exit 1; 
fi
# Checking root permissions
if [ "x$(id -u)" != 'x0' ]; then
    check_error 1 "Script can be run executed only by root"
fi
# check directory
if [ ! -d "/opt/easyBM/" ]; then
  echo "  ERROR: $0 need source direcotry /opt/easyBM"; exit 1;
fi
# check directory
if [ -d "/opt/MMDVMHost/" ]; then 
 echo "  ERROR: MMDVMHost is already there, did you run $0 tice? "; exit 1;
fi
# check directory
if [ -d "/opt/YSFClients/" ]; then 
 echo "  ERROR: MMDVMHost is already there, did you run $0 tice? "; exit 1; 
fi
# Check easybm user account
if [ ! -z "$(grep ^easybm: /etc/passwd)" ] && [ -z "$1" ]; then
    echo "  ERROR: user easybm exists"
    echo
    echo 'Please remove easybm user account before proceeding.'
    #echo 'If you want to do it automatically run installer with -f option:'
    #echo "Example: bash $0 --force"
    exit 1
fi
# Check easybm group account
if [ ! -z "$(grep ^easybm: /etc/group)" ] && [ -z "$1" ]; then
    echo "  ERROR: group easybm exists"
    echo
    echo 'Please remove easybm group before proceeding.'
    #echo 'If you want to do it automatically run installer with -f option:'
    #echo "Example: bash $0 --force"
    exit 1
fi
# Check Internet Access
ping -c 3 google.com
check_result $? '  ERROR, please make sure the Internet is reachable !!!'
# dedect os
case $(head -n1 /etc/issue | cut -f 1 -d ' ') in
    Debian)     ostype="debian" ;;
    Ubuntu)     ostype="ubuntu" ;;
    Raspbian)   ostype="raspbian" ;;
    *)          ostype="rhel" ;;
esac
sleep 1
echo 
echo
echo "  +++ Great, we can continue...."
echo
pause

echo -e "\n\n +++ Update and Upgrade the OS with apt....\n"
sudo apt update && sudo apt upgrade 
check_result $? ' Sorry,..... apt upgrade failed'
pause

echo -e "\n\n +++ installing some Tools, like git gcc make vim wget and more...\n"
# Check wget
if [ ! -e '/usr/bin/wget' ]; then
    apt-get -y install wget
    check_result $? "  Sorry, can't install wget. Please install it."
fi
# Check make
if [ ! -e '/usr/bin/make' ]; then
    apt-get -y install make
    check_result $? "  Sorry, can't install make. Please install it."
fi
# Check screen
if [ ! -e '/usr/bin/screen' ]; then
    apt-get -y install screen
    check_result $? "  Sorry, can't install screen. Please install it."
fi
# Check curl
if [ ! -e '/usr/bin/curl' ]; then
    apt-get -y install curl
    check_result $? "  Sorry, can't install curl. Please install it."
fi
# Check whiptail 
if [ ! -e '/usr/bin/whiptail' ]; then
    apt-get -y install whiptail
    check_result $? "  Sorry, can't install whiptail. Please install it."
fi
# Check gcc
if [ ! -e '/usr/bin/gcc' ]; then
    apt-get -y install gcc
    check_result $? "  Sorry, can't install gcc. Please install it."
fi 
# Check g++
if [ ! -e '/usr/bin/g++' ]; then
    apt-get -y install g++
    check_result $? "  Sorry, can't install g++. Please install it."
fi
# Check ntpdate
if [ ! -e '/usr/sbin/ntpdate' ]; then
    apt-get -y install ntpdate
    check_result $? "  Sorry, can't install ntpdate. Please install it."
fi
# Check git
if [ ! -e '/usr/bin/git' ]; then
    apt-get -y install git
    check_result $? "  Sorry, can't install git. Please install it."
fi
# Check vim
if [ ! -e '/usr/bin/vim' ]; then
    apt-get -y install vim
    check_result $? "  Sorry, can't install vim. Please install it."
fi
# Check nano
if [ ! -e '/usr/bin/nano' ]; then
    apt-get -y install nano
    check_result $? "  Sorry, can't install nano. Please install it."
fi
# Check rrdtool
if [ ! -e '/usr/bin/rrdtool' ]; then
    apt-get -y install rrdtool
    check_result $? "  Sorry, can't install rrdtool. Please install it."
fi
# Check  rsync
if [ ! -e '/usr/bin/rsync' ]; then
    apt-get -y install rsync
    check_result $? "  Sorry, can't install rsync. Please install it."
fi
# Check screenfetch
if [ ! -e '/usr/bin/screenfetch' ]; then
    apt-get -y install screenfetch
    check_result $? "  Sorry, can't install screenfetch Please install it."
fi
# Check nodejs
if [ ! -e '/usr/bin/nodejs' ]; then
    apt-get -y install nodejs
    check_result $? "  Sorry, can't install nodejs. Please install it."
fi
# Check wicd-curses
if [ ! -e '/usr/bin/wicd-curses' ]; then
    apt-get -y install wicd-curses
    check_result $? "  Sorry, can't install wicd-curses. Please install it."
fi
# and some more....
sudo apt-get -y install build-essential net-tools ntp usbutils dnsutils 

pause

echo -e "\n\n +++ disabling  bluetooth\n"
/bin/grep -q -i 'dtoverlay=pi3-disable-bt' /boot/config.txt
if [ $? -gt 0 ]; then 
  sudo bash -c 'echo -e "#Bluetooth deactivation\ndtoverlay=pi3-disable-bt" >> /boot/config.txt'
fi
#AMA0 DVMega 
ls /dev/ttyAMA0
if [ $? -ne 0 ]; then
  echo " *********************************************"
  echo "  ERROR: /dev/ttyAMA0 NOT FOUND ! "
  echo "  DVMega uses ttyAMA0, think a about it......."
  echo " *********************************************"
else 
  sudo systemctl stop serial-getty@ttyAMA0.service
  sudo systemctl disable serial-getty@ttyAMA0.service
  echo -e "\n\n Please check the file permissions, owner has to be root and the group has to be dailout."
  echo " it looks like:"
  echo "                crw-rw---T 1 root dialout 204, 64 Mar 10 13:47 /dev/ttyAMA0"
  echo " otherwise do the following command: sudo usermod –a –G dialout <username>"
  echo " Now, please Check:"
  ls -ls /dev/ttyAMA0
fi
#
pause

echo -e "\n\n +++ installing NTP\n"
sudo apt install ntp ntpdate && sudo systemctl enable ntp && sudo systemctl start ntp
# NTP Synchronization
echo '#!/bin/sh' > /etc/cron.daily/ntpdate
echo "$(which ntpdate) -s pool.ntp.org" >> /etc/cron.daily/ntpdate
chmod 775 /etc/cron.daily/ntpdate
sudo ntpdate -s pool.ntp.org

pause

echo -e "\n\n +++ installing ramdisk\n" 
sudo mkdir /mnt/ramdisk /mnt/pendrive /mnt/diskdrive
/bin/grep -q ramdisk /etc/fstab
if [ $? -gt 0 ]; then
  echo "tmpfs /mnt/ramdisk  tmpfs nodev,nosuid,noexec,nodiratime,size=64M 0 0" >> /etc/fstab
  mount -a
  echo -e "\n\n +++ now, check if ramdrive has 64MB\n\n"
  df -h /mnt/ramdisk
else
  echo -e "\n\n +++ Found ramdisk in fstab, OK. Continue....\n"
  echo -e "\n\n +++ now, check if ramdrive has 64MB\n\n"
  df -h /mnt/ramdisk
fi

pause

echo -e "\n\n +++ installing Webserver lighttpd\n"
sudo apt install lighttpd php5-common php5-cgi php5
sudo lighty-enable-mod fastcgi
sudo lighty-enable-mod fastcgi-php
sudo service lighttpd restart
if [ -f /var/www/html/index.html ]; then 
 sudo rm -f /var/www/html/index.html
fi
if [ -f /var/www/html/index.lighttpd.html ]; then 
 sudo rm -f /var/www/html/index.lighttpd.html
fi
sudo usermod -a -G www-data pi
## FIXME gpio gibts noch garnicht
sudo usermod -a -G gpio www-data
## FIXME, checken ob es schon drin steht##
## evtl mit sed

/bin/grep -q "^www-data" /etc/sudoers
if [ $? -gt 0 ]; then
 echo "www-data ALL=(ALL) NOPASSWD: ALL " >> /etc/sudoers
else
 echo "UPS, www-data found in /etc/sudoers, so whats next? FIXME"
fi
pause 

echo -e "\n\n +++ installing and updating wiringPi\n"
if [ ! -d "/opt/wiringPi/" ]; then
 cd /opt/
 git clone git://git.drogon.net/wiringPi
 cd /opt/wiringPi
 sudo git pull origin
 /opt/wiringPi/build
 if [ $? -gt 0 ]; then
    echo -e "\n\n ERROR, can not build wiringPi. Please check.....\n"
 fi 
else 
 cd /opt/wiringPi
 sudo git pull origin
 /opt/wiringPi/build
 if [ $? -gt 0 ]; then
    echo -e "\n\n ERROR, can not build wiringPi. Please check.....\n"
 fi 
fi
echo -e "\n\n +++ Please check the wiringPi printout...\n"
gpio -v
gpio readall

pause

echo -e "\n\n +++ installing MMDVMCal\n"
cd /opt
sudo git clone https://github.com/g4klx/MMDVMCal.git
cd /opt/MMDVMCal
sudo make all

pause

echo -e "\n\n +++ installing MMDVMHost\n"
cd /opt
sudo git clone https://github.com/g4klx/MMDVMHost.git
cd /opt/MMDVMHost
sudo make clean all
echo
sudo chown -v www-data:www-data /opt/MMDVMHost/MMDVM.ini
echo
sudo cp -b -f /opt/MMDVMHost/MMDVM.ini /opt/MMDVMHost/MMDVM.ini.origin

pause

echo -e "\n\n +++ installing systemd Service MMDVM Host Service\n"
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

echo -e "\n\n +++ installing systemd Timer for MMDVMHost\n"
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

echo -e "\n\n +++ installing MMDVMHost-Dashboard\n"
cd /var/www/html/
sudo git clone https://github.com/dg9vh/MMDVMHost-Dashboard.git 
sudo chown -Rv www-data:www-data /var/www/html/MMDVMHost-Dashboard/*
sudo mv /var/www/html/MMDVMHost-Dashboard/setup.php /var/www/html/MMDVMHost-Dashboard/dashboard.setup.php

pause

##FIXME FIXME 
echo -e "\n\n +++ installing ircddbgateway\n"
cd /tmp
wget http://repo1.ham-digital.net/debian/dl5di.pk 
check_result $? '  ERROR, can not download dl5di key for adding to apt !!!'
sudo apt-key add dl5di.pk     
check_result $? '  ERROR, can not add dl5di apt-key !!!'

##FIXME, das repo ist veraltet, ein neues liegt in files##
sudo curl http://repo1.ham-digital.net/raspbian/opendv.list -o /etc/apt/sources.list.d/opendv.list
sudo apt update && sudo apt upgrade && sudo apt install ircddbgateway

echo -e "\n\n  +++ Please keep in mind to use the command 'sudo ircddbgw_conf' for configuration' "

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
ln -s var/www/html/ircddbgateway/ircddblocal.php /var/www/html/ircddblocal.php
sudo chmod 666 /home/opendv/ircddbgateway/ircddbgateway

pause 

echo -e "\n\n +++ installing C4FM YSF Software\n"
cd /opt
sudo git clone https://github.com/g4klx/YSFClients.git
cd /opt/YSFClients/YSFGateway
make clean all
sudo cp -f /opt/YSFClients/YSFGateway/YSFGateway /usr/local/bin/
sudo mkdir /etc/YSFGateway 
sudo cp -f /opt/YSFClients/YSFGateway/YSFGateway.ini /etc/YSFGateway/
sudo cp -f /opt/YSFClients/YSFGateway/YSFHosts.txt /etc/YSFGateway/
sudo wget -O /etc/YSFGateway/YSFHosts.txt http://register.ysfreflector.de/export_csv.php
#
sudo groupadd mmdvm && sudo useradd mmdvm -g mmdvm -s /sbin/nologin
#
sudo mkdir -p /var/log/YSFGateway
##FIXME, die gurppe gibt es nicht##
sudo chgrp mmdvm /var/log/YSFGateway
sudo chmod g+w /var/log/YSFGateway
#
sudo mkdir -p /mnt/ramdisk/YSFGateway
sudo chgrp mmdvm /mnt/ramdisk/YSFGateway
sudo chmod g+w /mnt/ramdisk/YSFGateway
#
sudo cp -f /opt/easyBM/files/YSFGateway.init /etc/init.d/YSFGateway
sudo chmod 755 /etc/init.d/YSFGateway
sudo update-rc.d YSFGateway defaults
sudo update-rc.d YSFGateway enable

pause

echo -e "\n\n +++ setting up the os system\n"
sudo cp -b -f /opt/easyBM/files/easyBM.cronjob /etc/cron.d/easyBM
sudo cp -b -f /opt/easyBM/files/99-easyBM.conf /etc/lighttpd/conf-enabled/99-easyBM.conf
sudo cp -b -f /opt/easyBM/files/bash_login /home/pi/.bash_login && sudo chown pi:pi /home/pi/.bash_login
sudo cp -b -f /opt/easyBM/files/ircddbgateway.default /etc/default/ircddbgateway
sudo cp -b -f /opt/easyBM/files/easyBM.profile /etc/profile.d/easyBM.sh
#sed -i -e '$i \nohup sh /opt/easyBM/easyBM-send-startup-info.sh\n' rc.local
sudo echo "easybm" > /etc/hostname
sudo systemctl enable ssh.service
sudo systemctl start ssh.service
pause 

echo -e "\n\n +++ prepare for the first use\n"
sudo touch /var/www/html/UNCONFIGURED
echo "<?php if (file_exists('UNCONFIGURED')){ header('Location:/admin/init.php'); } else { header('Location:/MMDVMHost-Dashboard/index.php'); } ?>" > /var/www/html/index.php
sudo apt-get autoclean
sudo apt-get autoremove
sudo systemctl restart lighttpd
sudo systemctl restart cron
pause


echo -e "\n\n +++ creating your login message\n"
echo "
__________________________________________________________________________

  Thank you for using easyBM, a Linux Image made by the German BM Group

  Please do not hesitate to contact us http://easybm.bm262.de 

	Notice: Use the command 'ebm' to start the our service-menu !
	
__________________________________________________________________________

Version `date -I` is ready to start......

" > /etc/motd
echo 
screenfetch
echo 
echo
echo -e "\nCongratulations, you have just successfully installed -easyBM- \n
\n
  We hope that you enjoy your installation of easyBM.\n
  Please feel free to contact us anytime, if you have any questions.\n
\n
  Sincerely yours\n
  bm262.de team\n
\n
"
echo
echo
echo -e "\n\n Please do no a reboot, so all changes can take effect...\n"
echo -e "\n And after the Reboot, please visit the Website http://ip/admin/\n"
echo -e " OR login as user pi again and use the console menu....\n"
echo 

