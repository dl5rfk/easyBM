#!/bin/bash 
# Install Script by DL5RFK
#
# DO NOT USE THIS SCRIPT AS A ORDINARY USER
# THIS SCRIPT IS NOT SUPPORTED
#
# if you have any suggestion, please contact me info@bm262.de
#

# -e option instructs bash to immediately exit if any command [1] has a non-zero exit status
# We do not want users to end up with a partially working install, so we exit the script
# instead of continuing the installation with something broken
#set -e
#set -x



# Define Variables
export PATH=$PATH:/sbin
export DEBIAN_FRONTEND=noninteractive
memory=$(grep 'MemTotal' /proc/meminfo |tr ' ' '\n' |grep [0-9])
arch=$(uname -i)
release=$(cat /etc/debian_version|grep -o [0-9]|head -n1)
codename="$(cat /etc/os-release |grep VERSION= |cut -f 2 -d \(|cut -f 1 -d \))"
localipaddr=`ifconfig eth0 | grep "inet addr" | cut -d ':' -f 2 | cut -d ' ' -f 1`

# Define functions
function pause(){
 echo
 echo " # >>>>> Please, check the printout, now! <<<<< "
 echo 
 sleep 5
}

# Defning return code check function
check_result() {
    if [ $1 -ne 0 ]; then
        echo " # >>>>> Error: $2 <<<<< "
        exit $1
    fi
}

#
#START 
#
clear
screenfetch
echo -e "\e[48;5;220m                                      "
echo "                                      "
echo "                       ____  __  __   "
echo "   ___  __ _ ___ _   _| __ )|  \/  |  "
echo "  / _ \/ _  / __| | | |  _ \| |\/| |  "
echo " |  __/ (_| \__ \ |_| | |_) | |  | |  "
echo "  \___|\__,_|___/\__| |____/|_|  |_|  "
echo "                 |___/                "
echo "                                      "
echo -e "\e[48;5;208m                                      "
echo "                                      "
echo "  easyBM is based on an idear of the  "
echo "  German BrandMeister Support-Team    "
echo "                                      " 
echo "   Licenced under the GNU Licence     " 
echo " ************************************ "
echo " *   FOR INTERNAL USE ONLY          * "
echo " ************************************ "
echo "                                      "
echo -e "\e[48;5;196m                                      "
echo "                                      "
echo " easyBM is a community effort of      "
echo " 3 radio amateurs from Germany who    "
echo " have created this solution out of    "
echo " joy in the hobby                     "
echo "                                      "
echo " Support this BM project at           "
echo " github.com/dl5rfk/easyBM.git         "
echo "                                      "
echo -e "\e[0m                                              "
echo
echo -e "\n\n # >>>>> We do some checks ...."
sleep 1
if [ ! $( id -u ) -eq 0 ]; then
  echo " # >>>>> ERROR: $0 Must be run as user root, Script terminating" 1>&2; exit 1; 
fi
# Checking root permissions
if [ "x$(id -u)" != 'x0' ]; then
    check_error 1 "Script can be run executed only by root"
fi
# check directory
if [ ! -d "/opt/easyBM/" ]; then
  echo " # >>>>> ERROR: $0 need source direcotry /opt/easyBM"; exit 1;
fi
# check apt
if command -v apt-get &> /dev/null; then
  echo " # >>>>> apt found..."
else
  echo " # >>>>> ERROR: apt not found !"
  exit 0;
fi 
# Check easybm user account
if [ ! -z "$(grep ^easybm: /etc/passwd)" ] && [ -z "$1" ]; then
    echo " # >>>>> ERROR: user easybm exists"
    echo '     Please remove easybm user account before proceeding.'
    exit 1
fi
# Check easybm group account
if [ ! -z "$(grep ^easybm: /etc/group)" ] && [ -z "$1" ]; then
    echo " # >>>>> ERROR: group easybm exists"
    echo '     Please remove easybm group before proceeding.'
    exit 1
fi

# chech interfaces
availableInterfaces=$(ip --oneline link show up | grep -v "lo" | awk '{print $2}' | cut -d':' -f1 | cut -d'@' -f1)
 echo " # >>>>> Interface(s) "
 echo "  ${availableInterfaces}"
 echo "  are up an running"

# Check Internet Access
ping -c 3 google.com
check_result $? '  ERROR, please make sure the Internet is reachable !!!'
echo -e "\n\n # >>>>> Great, we have internet....lets continue...."

# dedect os
case $(head -n1 /etc/issue | cut -f 1 -d ' ') in
    Debian)     ostype="debian" ;;
    Ubuntu)     ostype="ubuntu" ;;
    Raspbian)   ostype="raspbian" ;;
    *)          ostype="rhel" ;;
esac
echo  " # >>>>> ${ostype} detected <<<<< "
pause

echo -e "\n\n # >>>>> Update and Upgrade the OS \n"
/usr/bin/sudo /usr/bin/apt update && /usr/bin/sudo /usr/bin/apt -y upgrade 
check_result $? ' Sorry,..... /usr/bin/apt upgrade failed'


echo -e "\n\n # >>>>> Update rpi software \n"
TEST_URL=$(grep "UPDATE_URI=" /usr/bin/rpi-update | awk -F '=' '{print $2}' | sed -e 's/^"//' -e 's/"$//')
urlstatus=$(curl -o /dev/null --silent --head --write-out '%{http_code}' ${TEST_URL} )
if [ ${urlstatus} -eq 200 ]; then
	/usr/bin/sudo /usr/bin/rpi-update
fi

echo -e "\n\n # >>>>> installing some Tools...\n"
# Check wget
if [ ! $(command -v wget) ]; then
    /usr/bin/apt -y install wget
    check_result $? "  Sorry, can't install wget. "
fi
# Check make
if [ ! $(command -v make) ]; then
    /usr/bin/apt -y install make
    check_result $? "  Sorry, can't install make. "
fi
# Check screen
if [ ! $(command -v screen) ]; then
    /usr/bin/apt -y install screen
    check_result $? "  Sorry, can't install screen."
fi
# Check curl
if [ ! $(command -v curl) ]; then
    /usr/bin/apt -y install curl
    check_result $? "  Sorry, can't install curl. "
fi
# Check whiptail 
if [ ! $(command -v whiptail) ]; then
    /usr/bin/apt -y install whiptail
    check_result $? "  Sorry, can't install whiptail. "
fi
# Check gcc
if [ ! $(command -v gcc) ]; then
    /usr/bin/apt -y install gcc
    check_result $? "  Sorry, can't install gcc."
fi 
# Check g++
if [ ! $(command -v g++) ]; then
    /usr/bin/apt -y install g++
    check_result $? "  Sorry, can't install g++. "
fi
# Check git
if [ ! $(command -v git) ]; then
    /usr/bin/apt -y install git
    check_result $? "  Sorry, can't install git. "
fi
# Check vim
if [ ! $(command -v vim) ]; then
    /usr/bin/apt -y install vim
    check_result $? "  Sorry, can't install vim. "
fi
# Check nano
if [ ! $(command -v nano) ]; then
    /usr/bin/apt -y install nano
    check_result $? "  Sorry, can't install nano. "
fi
# Check rrdtool
if [ ! $(command -v rrdtool) ]; then
    /usr/bin/apt -y install rrdtool
    check_result $? "  Sorry, can't install rrdtool. "
fi
# Check  rsync
if [ ! $(command -v rsync) ]; then
    /usr/bin/apt -y install rsync
    check_result $? "  Sorry, can't install rsync. "
fi
# Check screenfetch
if [ ! $(command -v screenfetch) ]; then
    /usr/bin/apt -y install screenfetch
    check_result $? "  Sorry, can't install screenfetch. "
fi
# Check wicd-curses
if [ ! $(command -v wicd-curses) ]; then
    /usr/bin/apt -y install wicd-curses
    check_result $? "  Sorry, can't install wicd-curses. "
fi
# and some more....
/usr/bin/sudo /usr/bin/apt -y install build-essential net-tools ntp usbutils dnsutils 

pause

echo -e "\n\n # >>>>> disabling  bluetooth\n"
# /bin/grep -i -q "dtoverlay=pi3-disable-bt" /boot/config.txt
# if [[ $? -eq 0 ]]; then
#   echo "...found, bluetooth is disabled"
# else
#   echo "...not.found, we have to disable blootooth"
#   /usr/bin/sudo bash -c 'echo -e "#Bluetooth deactivation\ndtoverlay=pi3-disable-bt" >> /boot/config.txt'
# fi
   /usr/bin/sudo bash -c 'echo -e "#Bluetooth deactivation\ndtoverlay=pi3-disable-bt" >> /boot/config.txt'



echo -e "\n\n # >>>>> checking /dev/ttyAMA0\n"
ls /dev/ttyAMA0
if [ $? -ne 0 ]; then
  echo " *********************************************"
  echo "  ERROR: /dev/ttyAMA0 NOT FOUND ! "
  echo "  DVMega uses ttyAMA0, think a about it......."
  echo " *********************************************"
  exit 0;
else 
  /usr/bin/sudo systemctl stop serial-getty@ttyAMA0.service
  /usr/bin/sudo systemctl disable serial-getty@ttyAMA0.service
  echo -e "\n\n Please check the file permissions, owner has to be root and the group has to be dailout."
  echo " it looks like:    crw-rw---T 1 root dialout 204, 64 Mar 10 13:47 /dev/ttyAMA0"
  echo " otherwise do the following command: /usr/bin/sudo usermod –a –G dialout <username>"
  echo 
  echo " Now, please Check:"
  chmod 1660  /dev/ttyAMA0
  ls -ls /dev/ttyAMA0
 pause
fi


if [ ! -d '/opt/rpi-clone' ]; then
echo " # >>>>> installing rpi-clone"
 cd /opt/
 git clone https://github.com/billw2/rpi-clone.git
 cd rpi-clone
 /usr/bin/sudo cp rpi-clone /usr/local/sbin/
 /usr/bin/sudo mkdir /mnt/clone /mnt/sda /mnt/sdb /mnt/sdc
pause
fi

if [ ! -e '/usr/bin/sntp' ]; then
echo " # >>>>> installing sntp"
 /usr/bin/sudo /usr/bin/apt -y install sntp 
 echo "#!/bin/sh" > /etc/cron.daily/sntp
 echo "$(command -v sntp) -s pool.ntp.org" >> /etc/cron.daily/sntp
 chmod 755 /etc/cron.daily/sntp
 /usr/bin/sudo $(command -v sntp) -s pool.ntp.org
 #/usr/bin/sudo /bin/systemctl enable systemd-timesyncd
 #/usr/bin/sudo /bin/systemctl restart systemd-timesyncd
 #/usr/bin/sudo /bin/systemctl status systemd-timesyncd
pause
fi

#RAMDISK
if [ ! -d '/mnt/ramdisk' ]; then
  echo " # >>>>> installing ramdisk" 
   /usr/bin/sudo mkdir /mnt/ramdisk /mnt/pendrive /mnt/diskdrive

fi

if [ -z "$(grep -q ramdisk /etc/fstab)" ]; then
    echo " # >>>>> Found ramdisk in fstab, OK"
 else
    echo "tmpfs /mnt/ramdisk  tmpfs nodev,nosuid,noexec,nodiratime,size=256M 0 0" >> /etc/fstab
    mount -a
fi
pause

#MMDVMCall
if  [ ! -d '/opt/MMDVMCal' ]; then
 echo " # >>>>> installing MMDVMCal"
 cd /opt
  /usr/bin/sudo git clone https://github.com/g4klx/MMDVMCal.git
 cd /opt/MMDVMCal
  /usr/bin/sudo make all
 pause
fi

#MMDVMHost
if  [ ! -d "/opt/MMDVMHost" ]; then
 echo " # >>>>> installing MMDVMHost"
  cd /opt
   /usr/bin/sudo git clone https://github.com/g4klx/MMDVMHost.git
  cd /opt/MMDVMHost
   /usr/bin/sudo make clean all
   /usr/bin/sudo chown -v www-data:www-data /opt/MMDVMHost/MMDVM.ini
   /usr/bin/sudo cp -b -f /opt/MMDVMHost/MMDVM.ini /opt/MMDVMHost/MMDVM.ini.`/bin/date -I`
   /usr/bin/sudo ln -s /opt/MMDVMHost/MMDVM.ini /etc/MMDVM.ini
 echo -e "\n\n # >>>>> installing MMDVMHost systemd Service \n"
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
/usr/bin/sudo chmod 644 /lib/systemd/system/mmdvmhost.service
/usr/bin/sudo ln -s /lib/systemd/system/mmdvmhost.service /etc/systemd/system/mmdvmhost.service

echo -e "\n\n # >>>>> installing MMDVMHost systemd Timer \n"
echo "
[Timer]
OnStartupSec=60

[Install]
WantedBy=multi-user.target
" > /lib/systemd/system/mmdvmhost.timer

/usr/bin/sudo chmod 644 /lib/systemd/system/mmdvmhost.timer
/usr/bin/sudo ln -s /lib/systemd/system/mmdvmhost.timer /etc/systemd/system/mmdvmhost.timer

/usr/bin/sudo systemctl daemon-reload 
/usr/bin/sudo systemctl enable mmdvmhost.timer

pause 
fi

if [ ! -d '/opt/YSFClients/']; then 
 echo -e "\n\n # >>>>> installing C4FM YSF Software\n"
  cd /opt
   /usr/bin/sudo git clone https://github.com/g4klx/YSFClients.git
  cd /opt/YSFClients/YSFGateway
   /usr/bin/sudo make clean all
   /usr/bin/sudo cp -f /opt/YSFClients/YSFGateway/YSFGateway /usr/local/bin/
   /usr/bin/sudo mkdir /etc/YSFGateway 
   /usr/bin/sudo cp -f /opt/YSFClients/YSFGateway/YSFGateway.ini /etc/YSFGateway/
   /usr/bin/sudo cp -f /opt/YSFClients/YSFGateway/YSFHosts.txt /etc/YSFGateway/
   /usr/bin/sudo wget -O /etc/YSFGateway/YSFHosts.txt http://register.ysfreflector.de/export_csv.php
   /usr/bin/sudo groupadd mmdvm && /usr/bin/sudo useradd mmdvm -g mmdvm -s /sbin/nologin
   #
   /usr/bin/sudo mkdir -p /var/log/YSFGateway
   ##FIXME, die gurppe gibt es nicht##
   /usr/bin/sudo chgrp mmdvm /var/log/YSFGateway
   /usr/bin/sudo chmod g+w /var/log/YSFGateway
   #
   /usr/bin/sudo mkdir -p /mnt/ramdisk/YSFGateway
   /usr/bin/sudo chgrp mmdvm /mnt/ramdisk/YSFGateway
   /usr/bin/sudo chmod g+w /mnt/ramdisk/YSFGateway
   #
   /usr/bin/sudo cp -f /opt/easyBM/files/YSFGateway.init /etc/init.d/YSFGateway
   /usr/bin/sudo chmod 755 /etc/init.d/YSFGateway
   /usr/bin/sudo update-rc.d YSFGateway defaults
   /usr/bin/sudo update-rc.d YSFGateway enable
pause
fi

echo -e "\n\n # >>>>> installing Webserver lighttpd\n"
 /usr/bin/sudo /usr/bin/apt -y install lighttpd php-cgi php
 /usr/bin/sudo lighty-enable-mod fastcgi
 /usr/bin/sudo lighty-enable-mod fastcgi-php
 /usr/bin/sudo service lighttpd restart
if [ -f /var/www/html/index.html ]; then 
 /usr/bin/sudo rm -f /var/www/html/index.html
fi
if [ -f /var/www/html/index.lighttpd.html ]; then 
 /usr/bin/sudo rm -f /var/www/html/index.lighttpd.html
fi
 /usr/bin/sudo usermod -a -G www-data pi
## FIXME gpio gibts noch garnicht
/usr/bin/sudo usermod -a -G gpio www-data
## FIXME, checken ob es schon drin steht##
## evtl mit sed

if ! /bin/grep -q "^www-data" /etc/sudoers; then
 echo "www-data ALL=(ALL) NOPASSWD: ALL " >> /etc/sudoers
else
 echo " # >>>>> UPS, www-data found in /etc/sudoers, so whats next?"
fi

echo -e "\n\n # >>>>> installing vnstat and vnstati\n"
echo -e "         based on https://j0hn.uk/vnstati/vnstati_howto.php\n"
 /usr/bin/sudo /usr/bin/apt -y install vnstat vnstati php-gd
 /usr/bin/sudo mkdir /var/www/html/vnstati
 /usr/bin/sudo wget http://j0hn.uk/vnstati/template.html -O /var/www/html/vnstati/index.html
pause


echo -e "\n\n # >>>>> prepare for the first use\n"
/usr/bin/sudo /bin/cp -b -f /opt/easyBM/files/easyBM.cronjob /etc/cron.d/easyBM
/usr/bin/sudo /bin/cp -b -f /opt/easyBM/files/99-easyBM.conf /etc/lighttpd/conf-enabled/99-easyBM.conf
/usr/bin/sudo /bin/cp -b -f /opt/easyBM/files/bash_login /home/pi/.bash_login && /usr/bin/sudo chown pi:pi /home/pi/.bash_login
/usr/bin/sudo /bin/cp -b -f /opt/easyBM/files/easyBM.profile /etc/profile.d/easyBM.sh
/usr/bin/sudo echo "easybm" > /etc/hostname
#edit rsyslog.conf
/usr/bin/sudo /bin/sed -i '/news/s/^/#/' /etc/rsyslog.conf
/usr/bin/sudo /bin/sed -i '/mail/s/^/#/' /etc/rsyslog.conf
/usr/bin/sudo /bin/sed -i '/kern/s/^/#/' /etc/rsyslog.conf
/usr/bin/sudo /bin/sed -i '/user/s/^/#/' /etc/rsyslog.conf
/usr/bin/sudo /bin/sed -i '/daemon/s/^/#/' /etc/rsyslog.conf
/usr/bin/sudo /bin/sed -i '/lpr/s/^/#/' /etc/rsyslog.conf
/usr/bin/sudo /bin/sed -i '/cron/s/^/#/' /etc/rsyslog.conf
/usr/bin/sudo /bin/sed -i '/rotate/s/[0-9]/2/' /etc/logrotate.conf
#
/usr/bin/sudo /usr/bin/apt-get -y autoclean
/usr/bin/sudo /usr/bin/apt-get -y autoremove
/usr/bin/sudo /bin/systemctl enable lighttpd
/usr/bin/sudo /bin/systemctl restart lighttpd
/usr/bin/sudo /bin/systemctl enable cron
/usr/bin/sudo /bin/systemctl restart cron
/usr/bin/sudo /bin/systemctl enable  rsyslog.service
/usr/bin/sudo /bin/systemctl restart rsyslog.service
/usr/bin/sudo /bin/systemctl enable ssh.service
/usr/bin/sudo /bin/systemctl start ssh.service
pause 

echo -e "\n\n # >>>>> setting up Firewall\n"
$(command -v iptables) -C INPUT -p tcp -m tcp --dport 80 -j ACCEPT

/usr/bin/sudo touch /var/www/html/UNCONFIGURED
echo "<?php if (file_exists('UNCONFIGURED')){ header('Location:/admin/init.php'); } else { header('Location:/MMDVMHost-Dashboard/index.php'); } ?>" > /var/www/html/index.php


echo -e "\n\n # >>>>> creating your login message\n"
echo "
__________________________________________________________________________

  Thank you for using easyBM, a Linux Image made by the German BM Group

  Please do not hesitate to contact us http://easybm.bm262.de 

Installation Date: `date -I` 
__________________________________________________________________________

" > /etc/motd
echo 
echo
clear 
echo -e "\nCongratulations, you have just successfully installed -easyBM- \n
\n
  We hope that you enjoy your installation of easyBM.\n
  Please feel free to contact us anytime, if you have any questions.\n
  Sincerely yours\n
  bm262.de team\n
\n
"
echo -e "\n And after the Reboot, please visit the Website http://`ifconfig eth0 | grep "inet addr" | cut -d ':' -f 2 | cut -d ' ' -f 1`/admin/\n"
echo -e " OR login via SSH as user pi and the default password raspberry.\n"
echo -e "\n\n Please type reboot and hit enter, now!\n"
echo 
