# RunMe
RunMe web app

You will need the following files:
* .htaccess
* .htpasswd
* servers.list

For lack of an installer app:

* Install apache2
* Install php7 for apache2
* Create site in apache for destination directory (see config example below)
* Create a logfile at /var/log/runme.log writable by the apache2 process (usually www-data)

Example .htaccess
```
AuthUserFile /var/www/html/RunMe/.htpasswd
AuthGroupFile /dev/null
AuthName "Please Enter Password"
AuthType Basic
Require valid-user
```
To create a .htpasswd file:
```
htpasswd -c .htpasswd <user>
```
To add a user to a .htpasswd file:
```
htpasswd .htpasswd <user>
```
Example apache conf
```
<VirtualHost *:80>
    ServerName runme.obiserious.com
    ServerAdmin obi@obiserious.com

    DocumentRoot /var/www/html/RunMe
    <Directory />
        Options FollowSymLinks
        AllowOverride All
    </Directory>
    <Directory /var/www/html/RunMe/>
        Options Indexes FollowSymLinks MultiViews ExecCGI
        AllowOverride All
        Order allow,deny
        allow from all
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/runme.obiserious.error.log

    # Possible values include: debug, info, notice, warn, error, crit,
    # alert, emerg.
    LogLevel warn

    CustomLog ${APACHE_LOG_DIR}/runme.obiserious.access.log combined

</VirtualHost>
```

