#/bin/bash 
#
#by DL5RFK, use it as is....no warrenty or support
#
#LATEST CHANGE: 2016-11-09

clear 

if [ ! -d "/opt/backup" ]; then
   /bin/mkdir /opt/backup
fi

/bin/tar -cvzf /opt/backup/easyBM-Backup-`date -I`.tar.gz /etc /opt/ /var/www/

echo
echo "DONE......................................................................."
echo
echo " YOU CAN FIND THE BACKUP FILE AT /opt/backup/easyBM-Backup-`date -I`.tar.gz"
echo " Please copy the .tar.gz file to your local backup-storage." 
echo
