#!/bin/bash

check=$(/usr/bin/ssl-cert-check -b -s $1 -p 443)
valid=$(echo $check | awk '{print $2}')
datexpiry=$(echo $check | awk '{print $4,$3,$5}')
dayleft=$(echo $check | awk '{print $6}')

if grep $1 certinfo
then
  sed -i '/'$1'/d' certinfo
  echo $1 $2 $valid $datexpiry $dayleft >> certinfo
else
  echo $1 $2 $valid $datexpiry $dayleft >> certinfo
fi

while read line; do
  domain=$(echo $line | awk '{print $1}')
  if grep $domain domainlist
  then
    echo 'ok'
  else
    sed -i '/'$domain'/d' certinfo
  fi
done <certinfo
