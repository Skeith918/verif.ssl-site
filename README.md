# verif.ssl-site
 Mini GUI qui permet de vérifier la date d’expiration du certificat SSL de chaque domaine spécifier dans la liste du fichier **__domainlist__**

# Installation
#### Requis 
- Nginx
- ssl-cert-check
- php7
- php7-fpm
- php7.0-curl
- [ssllabs-scan](https://github.com/ssllabs/ssllabs-scan/releases)
```
sudo apt install -y php php-fpm php-curl nginx ssl-cert-check
```

#### Procédure
- Accordez les droits d'accès au répertoire d'installation et répertoire parent de verif.ssl-site à **__www-data__**
```
chown -R www-data:www-data /path/to/verif.ssl-site /path/to/it/parent
```
- Accordez les droit sudo à l'utilisateur **__www-data__** dans **__/etc/visudo__**
```
www-data ALL=(ALL:ALL) NOPASSWD: ALL
```
- Dans le fichier **__/etc/php/7.0/fpm/php.ini__**, modifiez la ligne suivante...
```
;cgi.fix_pathinfo=1
```
- ...comme ci-dessous
```
cgi.fix_pathinfo=0
```
- Modifiez le fichier nginx.conf pour qu'il corresponde avec votre installation après l'avoir déplacé dans **__/etc/nginx/sites-available__**
```
server_name [le nom de domaine de votre choix];
root [le chemin absolu du répertoire d'installation de verif.ssl-site];
```
- Activez le site
```
ln -s /etc/nginx/sites-available/nginx.conf /etc/nginx/sites-enabled/nginx.conf
```
# Usages

- Créez le fichier **__domainlist__** à la racine et entrez y la liste des domaines a tester (**UN seul domaine par ligne !**)
- Vous pouvez maintenant consulté le statut de vos certificats sur l'interface!
