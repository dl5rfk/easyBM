#/bin/bash 
#
#by DL5RFK, use it as is....no warrenty or support
#
#LATEST CHANGE: 2016-11-09

clear 

if [ ! -d "/opt/backup" ]; then
   /bin/mkdir /opt/backup
fi

if [-w /var/www/html/MMDVMHost-Dashboard/config/config.php ]; then
/bin/cp /var/www/html/MMDVMHost-Dashboard/config/config.php /var/www/html/MMDVMHost-Dashboard/config/config.php.`/bin/date -I`
/bin/cp /var/www/html/MMDVMHost-Dashboard/config/config.php.`/bin/date -I` /opt/backup
fi

if [ -w /opt/MMDVMHost/MMDVM.ini ]; then
/bin/cp /opt/MMDVMHost/MMDVM.ini /opt/MMDVMHost/MMDVM.ini.`/bin/date -I`
/bin/cp /opt/MMDVMHost/MMDVM.ini.`/bin/date -I` /opt/backup
fi

if [ -w /etc/YSFGateway/YSFGateway.ini ]; then
/bin/cp	/etc/YSFGateway/YSFGateway.ini /opt/backup/YSFGateway.ini.`/bin/date -I`
fi

if [ -w /etc/ircddbgateway ];then
/bin/cp /etc/ircddbgateway /opt/backup/ircddbgateway.`/bin/date -I`
fi 



/bin/tar -cvzf /opt/backup/easyBM-Backup-`date -I`.tar.gz /etc /opt/ /var/www/

echo
echo "DONE......................................................................."
echo
echo " YOU CAN FIND THE BACKUP FILE AT /opt/backup/easyBM-Backup-`date -I`.tar.gz"
echo " Please copy the .tar.gz file to your local backup-storage." 
echo
ls  -lsa /opt/backup/

