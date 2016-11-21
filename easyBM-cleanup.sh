#!/bin/bash
#
#by DL5RFK, use it as is....no warrenty or support 
#
#  USE THIS SCRIPT TO CLEANUP BEFOR YOU MAKE AN SSD-IMAGE
#   (for internal use only)
#
#LAST CHANGE: 2016-11-09

#should be root:dailout
ls -l /dev/ttyAMA0

#should be without a beginning #
grep disable-bt /boot/config.txt

#should be 1
grep uart /boot/config.txt

#disable ttyAMA
sudo systemctl stop serial-getty@ttyAMA0.service
sudo systemctl disable serial-getty@ttyAMA0.service

touch /var/www/html/UNCONFIGURED

cat /dev/null > /var/log/auth.log
cat /dev/null > /var/log/syslog
cat /dev/null > /root/.ssh/known_hosts
cat /dev/null > /home/pi/.ssh/known_hosts
cat /dev/null > /home/pi/.bash_history
cat /dev/null > /root/.bash_history

rm /opt/MMDVMHost/MMDVM-*.log
rm -rf /opt/backup

#order important, first autoclean, then clean
apt-get autoclean
apt-get clean
