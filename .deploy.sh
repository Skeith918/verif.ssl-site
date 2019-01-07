cp /dev/null .certinfo
while read line; do
  check=$(/usr/bin/ssl-cert-check -b -s $line -p 443)
  ip=$(dig +short $line | awk '{ print ; exit }')
  valid=$(echo $check | awk '{print $2}')
  datexpiry=$(echo $check | awk '{print $4,$3,$5}')
  dayleft=$(echo $check | awk '{print $6}')
  echo $line $ip $valid $datexpiry $dayleft >> .certinfo
done <domainlist
