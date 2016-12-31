#!/bin/bash 

clear

echo "Starting fetching D-Star Reflector files ..."

#WESTERNDSTAR
/usr/bin/wget http://www.westerndstar.co.uk/KLXstuff/files/DPlus_Hosts.txt  -O /home/opendv/data/DPlus_Hosts.txt
/usr/bin/wget http://www.westerndstar.co.uk/KLXstuff/files/DExtra_Hosts.txt -O /home/opendv/data/DExtra_Hosts.txt
/usr/bin/wget http://www.westerndstar.co.uk/KLXstuff/files/DCS_Hosts.txt -O /home/opendv/data/DCS_Hosts.txt
/usr/bin/wget http://www.westerndstar.co.uk/KLXstuff/files/CCS_Hosts.txt -O /home/opendv/data/CCS_Hosts.txt

#XLX
/usr/bin/wget http://xlxapi.rlx.lu/api.php?do=GetReflectorHostname -O /home/opendv/data/All_Hosts.txt

#W6KD
/usr/bin/wget ftp://dschost2.w6kd.com/DExtra_Hosts.txt -O /home/opendv/data/DExtra_Hosts.txt
/usr/bin/wget ftp://dschost2.w6kd.com/DPlus_Hosts.txt -O /home/opendv/data/DPlus_Hosts.txt

/bin/grep 'DCS[1-9][[:digit:]][[:digit:]]' /home/opendv/data/All_Hosts.txt >> /home/opendv/data/DCS_Hosts.txt

echo "Fetching Reflector files ... Done!"

if [ -f /home/opendv/data/DPlus_Hosts.txt ]
 then
  {
    for ((i = 0 ; i <= 100 ; i+=5)); do
        sleep 0.1
        echo $i
    done
  } | whiptail --gauge "Please wait while we are restarting ircddbgateway..." 6 50 0
 service ircddbgateway restart
else
 echo „Sorry, list of Reflectors NOT updated !!!“
fi

echo
echo
echo "DONE...................................."
read -p "Now, press [Enter] to continue ..."
echo
exit
