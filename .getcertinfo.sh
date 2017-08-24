#!/bin/bash

check=$(/usr/bin/ssl-cert-check -b -s $1 -p 443)
valid=$(echo $check | awk '{print $2}')
datexpiry=$(echo $check | awk '{print $4,$3,$5}')
dayleft=$(echo $check | awk '{print $6}')
grade=$(cat .certinfo | grep $1 | awk '{print $8}')
old_line=$(cat .certinfo | grep $1)
new_line=$(echo $1 $2 $valid $datexpiry $dayleft $grade)
sed -i "s/${old_line}/${new_line}/g" .certinfo

while read line; do
  domain=$(echo $line | awk '{print $1}')
  echo $domain
  if grep $domain domainlist
  then
    echo ''
  else
    sed -i '/'$domain'/d' .certinfo
  fi
done <.certinfo
