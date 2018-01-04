# Comment sécurisé au maximum son site Nginx
- Générez un certificat SSL avec letsencrypt
```
apt install letsencrypt
service nginx stop
letsencrypt certonly --standalone --domain [nom de domaine] --email [email alerte] --agree-tos -n
```
- Redirigez le flux http vers https
```
listen 80;
return 301 https://$server_name$request_uri;
```
- Activez le HTTPS avec http2
```
listen 443 ssl http2;
```
- Déclarez les fichier du certificat
```
ssl_certificate /etc/letsencrypt/live/[nom de domaine]/fullchain.pem;
ssl_certificate_key /etc/letsencrypt/live/[nom de domaine]/privkey.pem;
```
- Générez un DHE
```
cd /etc/ssl/certs
openssl dhparam -out dhparam.pem 4096
```
- Voici le fichier finale après paramètrage
```
# Désactivation de gzip et de l'affichage de la version de nginx dans l'entête HTTP

gzip off;
server_tokens off;

# Définition des paramètres du protocole SSL et déclaration du DHE

ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
ssl_ciphers "EECDH+AESGCM:EDH+AESGCM:ECDHE-RSA-AES128-GCM-SHA256:AES256+EECDH:DHE-RSA-AES128-GCM-SHA256:AES256+EDH:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-SHA384:ECDHE-RSA-AES128-SHA256:ECDHE-RSA-AES256-SHA:ECDHE-RSA-AES128-SHA:DHE-RSA-AES256-SHA256:DHE-RSA-AES128-SHA256:DHE-RSA-AES256-SHA:DHE-RSA-AES128-SHA:ECDHE-RSA-DES-CBC3-SHA:EDH-RSA-DES-CBC3-SHA:AES256-GCM-SHA384:AES128-GCM-SHA256:AES256-SHA256:AES128-SHA256:AES256-SHA:AES128-SHA:DES-CBC3-SHA:HIGH:!aNULL:!eNULL:!EXPORT:!DES:!MD5:!PSK:!RC4";
ssl_prefer_server_ciphers on;
ssl_ecdh_curve secp384r1:prime256v1;
ssl_session_tickets off;
ssl_session_timeout 50m;
ssl_session_cache shared:SSL:10m;
ssl_stapling on;
ssl_stapling_verify on;
ssl_dhparam /etc/ssl/certs/dhparam.pem;

# Définition des paramètres d'entête HTTP

add_header Strict-Transport-Security "max-age=31536000; includeSubdomains";
add_header X-Content-Type-Options nosniff;
add_header X-Frame-Options SAMEORIGIN;
add_header X-XSS-Protection "1; mode=block";
add_header X-Robots-Tag none;
add_header X-Download-Options noopen;
add_header X-Permitted-Cross-Domain-Policies none;
```
