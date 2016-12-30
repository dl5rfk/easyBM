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
echo " easyBM is based on an idear of the"
echo " German BrandMeister Team, a hamradio Group "
echo 
echo "************************************************"
echo "*      FOR INTERNAL USE ONLY                   *"
echo "************************************************"
echo
echo
pause

echo "  Some first checks ...."
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
# dedect os
case $(head -n1 /etc/issue | cut -f 1 -d ' ') in
    Debian)     ostype="debian" ;;
    Ubuntu)     ostype="ubuntu" ;;
    Raspbian)   ostype="raspbian" ;;
    *)          ostype="rhel" ;;
esac
echo "  Great, we can continue...."
pause

echo -e "\n\n + at first, update and upgrade debian jessie\n"
sudo apt update && sudo apt upgrade 
check_result $? ' Sorry,..... apt upgrade failed'

pause

echo -e "\n\n + installing some Tools, like git gcc make vim wget and more...\n"
sudo apt install git screen vim  rrdtool curl whiptail g++ gcc make nano net-tools rsync build-essential nodejs wget ntpdate ntp usbutils dnsutils

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
if [ ! -e '/usr/bin/make' ]; then
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
# Check nano
if [ ! -e '/usr/bin/nano' ]; then
    apt-get -y install nano
    check_result $? "  Sorry, can't install nano. Please install it."
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


pause

echo -e "\n\n + diable bluetooth\n"
grep -i 'dtoverlay=pi3-disable-bt' /boot/config.txt
if [ $? -gt 0 ]; then 
  sudo bash -c 'echo -e "#Bluetooth deactivation\ndtoverlay=pi3-disable-bt" >> /boot/config.txt'
fi
#AMA0 DVMega 
ls /dev/ttyAMA0
if [ $? -ne 0 ]; then
  echo "  ERROR: /dev/ttyAMA0 NOT FOUND ! Aborting....";
  exit 1; 
else 
  sudo systemctl stop serial-getty@ttyAMA0.service
  sudo systemctl disable serial-getty@ttyAMA0.service
  echo -e "\n\n Please check the file permissions, owner has to be root and the group has to be dailout."
  ls -ls /dev/ttyAMA0
fi
#

echo -e "\n\n FIXME: Add group dailout and change owner to root:dailout\n"

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
ln -s var/www/html/ircddbgateway/ircddblocal.php /var/www/html/ircddblocal.php


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
echo "
#!/bin/bash
### BEGIN INIT INFO
#
# Provides:             YSFGateway
# Required-Start:       $all
# Required-Stop:        
# Default-Start:        2 3 4 5
# Default-Stop:         0 1 6
# Short-Description:    Example startscript YSFGateway

#
### END INIT INFO
## Fill in name of program here.
PROG="YSFGateway"
PROG_PATH="/usr/local/bin/"
PROG_ARGS="/etc/YSFGateway/YSFGateway.ini"
PIDFILE="/var/run/YSFGateway.pid"
USER="root"

start() {
      if [ -e $PIDFILE ]; then
          ## Program is running, exit with error.
          echo "Error! $PROG is currently running!" 1>&2
          exit 1
      else
          ## Change from /dev/null to something like /var/log/$PROG if you want to save output.
      sleep 20
          cd $PROG_PATH
          ./$PROG $PROG_ARGS
          echo "$PROG started"
          touch $PIDFILE
      fi
}

stop() {
      if [ -e $PIDFILE ]; then
          ## Program is running, so stop it
         echo "$PROG is running"
         rm -f $PIDFILE
         killall $PROG
         echo "$PROG stopped"
      else
          ## Program is not running, exit with error.
          echo "Error! $PROG not started!" 1>&2
          exit 1
      fi
}

## Check to see if we are running as root first.
## Found at http://www.cyberciti.biz/tips/shell-root-user-check-script.html
if [ "$(id -u)" != "0" ]; then
      echo "This script must be run as root" 1>&2
      exit 1
fi

case "$1" in
      start)
          start
          exit 0
      ;;
      stop)
          stop
          exit 0
      ;;
      reload|restart|force-reload)
          stop
          sleep 5
          start
          exit 0
      ;;
      **)
          echo "Usage: $0 {start|stop|reload}" 1>&2
          exit 1
      ;;
esac
exit 0
### END

" > /etc/init.d/YSFGateway
#
sudo chmod 755 /etc/init.d/YSFGateway
sudo update-rc.d YSFGateway defaults
sudo update-rc.d YSFGateway enable

pause

echo -e "\n\n + copying files\n"
sudo cp -f /opt/easyBM/files/easyBM.cronjob /etc/cron.d/easyBM
sudo cp -f /opt/easyBM/files/99-easyBM.conf /etc/lighttpd/conf-enabled/99-easyBM.conf
sudo cp -f /opt/easyBM/files/.bash_login /home/pi/.bash_login && sudo chown pi:pi /home/pi/.bash_login

echo -e "\n\n + restarting services\n"
sudo systemctl restart lighttpd
sudo /etc/init.d/cron restart
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
