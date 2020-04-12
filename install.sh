#!/bin/bash

if [ "$PWD" != "/var/www/html/RunMe" ]
then
    sudo apt-get install apache2 php7.2-cli libapache2-mod-php -y
    cd ..
    cp -pR RunMe /var/www/html/
    cd /var/www/html/RunMe
fi

sudo cp -p RunMe.conf /etc/apache2/sites-enabled/RunMe.conf
sudo touch /var/log/runme.log
sudo chown www-data:www-data /var/log/runme.log
user=$(id -un)
sudo chown $user:$user .
sudo chown $user:$user *

echo
echo "Please copy runme.ini.sample to runme.ini and edit it."

