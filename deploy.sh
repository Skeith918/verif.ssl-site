while read line; do
  sed -i '/'$line'/d' .certinfo
  check=$(/usr/bin/ssl-cert-check -b -s $line -p 443)
  ip=$(dig +short $line | awk '{ print ; exit }')
  valid=$(echo $check | awk '{print $2}')
  datexpiry=$(echo $check | awk '{print $4,$3,$5}')
  dayleft=$(echo $check | awk '{print $6}')
#  sslgrade=$(./.ssllabs-scan --quiet --grade $line)
#  grade=$(echo $sslgrade | sed 's|"| |g' | sed 's|:| |g' | awk '{print $2}')
#  echo $line $ip $valid $datexpiry $dayleft $grade >> .certinfo
  echo $line $ip $valid $datexpiry $dayleft >> .certinfo
done <domainlist
