#!/bin/bash
# by DL5RFK 
# 

if [ ! -L "/opt/easyBM/public_html/latency_graph.png" ]; then 
 if [ -f "/mnt/ramdisk/latency_graph.png" ]; then
 ln -s /mnt/ramdisk/latency_graph.png /opt/easyBM/public_html/latency_graph.png
 fi
fi

/usr/bin/rrdtool graph /mnt/ramdisk/latency_graph.png \
-w 965 -h 140 -a PNG \
--slope-mode \
--start end-5days --end now \
--font DEFAULT:7: \
--title "Internet Ping Time (Target is Google)" \
--watermark "`date`" \
--vertical-label "latency(ms)" \
--right-axis-label "" \
--lower-limit 0 \
--right-axis 1:0 \
--x-grid MINUTE:60:HOUR:6:HOUR:12:0:%a%R \
--alt-y-grid --rigid \
DEF:roundtrip=/mnt/ramdisk/latency_db.rrd:rtt:MAX \
DEF:packetloss=/mnt/ramdisk/latency_db.rrd:pl:MAX \
CDEF:PLNone=packetloss,0,0,LIMIT,UN,UNKN,INF,IF \
CDEF:PL10=packetloss,1,10,LIMIT,UN,UNKN,INF,IF \
CDEF:PL25=packetloss,10,25,LIMIT,UN,UNKN,INF,IF \
CDEF:PL50=packetloss,25,50,LIMIT,UN,UNKN,INF,IF \
CDEF:PL100=packetloss,50,100,LIMIT,UN,UNKN,INF,IF \
LINE2:roundtrip#0000FF:"latency(ms)" \
GPRINT:roundtrip:LAST:"Cur\: %5.2lf" \
GPRINT:roundtrip:AVERAGE:"Avg\: %5.2lf" \
GPRINT:roundtrip:MAX:"Max\: %5.2lf" \
GPRINT:roundtrip:MIN:"Min\: %5.2lf\t\t\t" \
COMMENT:"pkt loss\:" \
AREA:PLNone#FFFFFF:"0%":STACK \
AREA:PL10#FFFF00:"1-10%":STACK \
AREA:PL25#FFCC00:"10-25%":STACK \
AREA:PL50#FF8000:"25-50%":STACK \
AREA:PL100#FF0000:"50-100%":STACK

