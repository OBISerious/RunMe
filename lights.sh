#!/bin/bash

[ "$1" == "" ] && exit 1

date > /tmp/date.txt 
/usr/local/sbin/dropbox_uploader.sh upload /tmp/date.txt /$1/date.txt
rm /tmp/date.txt
