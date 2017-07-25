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
- Accordez les droits d'accès au répertoire d'installation et répertoire parent de verif.ssl-site à **__www-data__**
```
chown -R www-data:www-data /path/to/verif.ssl-site /path/to/it/parent
```
- Dans le fichier **__/etc/php/7.0/fpm/php.ini__**, modifiez la ligne suivante...
```
;cgi.fix_pathinfo=1
```
- ...comme ci-dessous
```
cgi.fix_pathinfo=0
```
- Modifiez le fichier nginx.conf pour qu'il corresponde avec votre installation
```
server_name [le nom de domaine de votre choix];
root [le chemin absolu du répertoire d'installation de verif.ssl-site];
```
- Activez le site
```
ln -s /etc/nginx/sites-available/nginx.conf /etc/nginx/sites-enabled/nginx.conf
```
- Vous pouvez modifier la liste des domaines à verifier dans **__~/verif.ssl-site/domainlist__** (**UN seul domaine par ligne !**)
## Windows
TODO
