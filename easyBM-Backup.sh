#/bin/bash 
#
#by DL5RFK, use it as is....
#

clear 

if [ ! -d "/opt/backup" ]; then
   /bin/mkdir /opt/backup
fi

/bin/tar -cvzf /opt/backup/easyBM-Backup-`date -I`.tar.gz /etc /opt/ /var/www/

echo
echo "DONE......................................................................."
echo
echo " YOU FIND THE NEW BACKUP TAR-FILE AT /opt/backup/easyBM-Backup-`date -I`.tar.gz"
echo 
echo
