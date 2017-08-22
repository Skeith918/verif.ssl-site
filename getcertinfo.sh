#!/bin/bash

#Execute ssl-cert-check binarie to check certificate of domain input in parameters of script
check=$(/usr/bin/ssl-cert-check -b -s $1 -p 443)
valid=$(echo $check | awk '{print $2}')
datexpiry=$(echo $check | awk '{print $4,$3,$5}')
dayleft=$(echo $check | awk '{print $6}')

#Check if the domain entry exist in certinfo file: if exist delete the old line and input a new line with new informations from last check.
if grep $1 certinfo
then
  sed -i '/'$1'/d' certinfo
  echo $1 $2 $valid $datexpiry $dayleft >> certinfo
else
  echo $1 $2 $valid $datexpiry $dayleft >> certinfo
fi

#Check if all domain in certinfo are required for check by a match with the domainlist what we explicitly check
while read line; do
  domain=$(echo $line | awk '{print $1}')
  if grep $domain domainlist
  then
    echo 'ok'
  else
    sed -i '/'$domain'/d' certinfo
  fi
done <certinfo
