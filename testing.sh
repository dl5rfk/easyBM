#!/bin/bash 






# Checking wget
if [ ! -e '/usr/bin/wget' ]; then
    apt-get -y install wget
    check_result $? "Can't install wget"
fi


