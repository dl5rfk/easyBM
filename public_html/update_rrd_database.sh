#!/bin/bash

#by DL5RFK, use it at is
#This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see http://www.gnu.org/licenses/.

#settings
pcommand="/bin/ping -q -n -c 5"
hosttoping="google.com"
dbfile="/mnt/ramdisk/latency_db.rrd"
#
#
/usr/bin/which gawk > /dev/null
if [ $? -ne 0 ]; then 
 /usr/bin/apt install gawk
fi
gawk="/usr/bin/gawk"

/usr/bin/which rrdtool > /dev/null
if [ $? -ne 0 ]; then
 /usr/bin/apt install rrdtool
fi 
rrdtool="/usr/bin/rrdtool"

#initialize rrd database
if [ ! -f "$dbfile" ]; then
 echo "Creating a RRD File at /mnt/ramdisk/ for the latency testresult database"
 $rrdtool create $dbfile --step 180 \
 DS:pl:GAUGE:550:0:100 \
 DS:rtt:GAUGE:550:0:10000000 \
 RRA:MAX:0.5:1:3360 \
 RRA:MAX:0.5:20:4032 
fi

#data collection routine 
get_data() {
    local output=$($pcommand $1 2>&1)
    local method=$(echo "$output" | $gawk '
        BEGIN {pl=100; rtt=0.1}
        /packets transmitted/ {
            match($0, /([0-9]+)% packet loss/, datapl)
            pl=datapl[1]
        }
        /min\/avg\/max/ {
            match($4, /(.*)\/(.*)\/(.*)\/(.*)/, datartt)
            rtt=datartt[2]
        }
        END {print pl ":" rtt}
        ')
    RETURN_DATA=${method}
}
 
#change to the script directory
cd /mnt/ramdisk/
#collect the data
get_data $hosttoping
#update the database
$rrdtool update $dbfile --template pl:rtt N:$RETURN_DATA
