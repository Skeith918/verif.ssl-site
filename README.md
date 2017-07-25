# verif.ssl-site
Mini GUI qui permet de vérifier la date d’expiration du certificat SSL de chaque domaine spécifier dans la liste 

# Installation
## Unix
#### Requis 
- Nginx
- php7
- php7-fpm
- php7.0-curl
```
sudo apt install -y php php-fpm php-curl nginx
```

#### Procédure
- Accordez les droits d'accès au répertoire d'installation et répertoire parent de verif.ssl-site à www-data
```
chown -R www-data:www-data /path/to/verif.ssl-site /path/to/it/parent
```
- Dans le fichier /etc/php/7.0/fpm/php.ini , modifiez la ligne suivante comme ci-dessous
```
-;cgi.fix_pathinfo=1
+cgi.fix_pathinfo=0
```
- Modifiez le fichier nginx.conf pour qu'il corresponde avec votre installation
```
-server_name verif.ssl.example.com;
+server_name [le nom de domaine de votre choix];
```
```
-root /path/to/verif.ssl-site/;
+root [le chemin absolu du répertoire d'installation de verif.ssl-site];
```
- Activez le site
```
ln -s /etc/nginx/sites-available/nginx.conf /etc/nginx/sites-enabled/nginx.conf
```
- Vous pouvez modifier la liste dans verif.ssl-site/domainlist ( UN seul domaine par ligne !)
## Windows
TODO
