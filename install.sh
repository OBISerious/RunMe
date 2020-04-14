#!/bin/bash

if [ "$PWD" != "/var/www/html/RunMe" ]
then
    sudo apt-get install apache2 php7.2-cli libapache2-mod-php -y
    cd ..
    sudo cp -pR RunMe /var/www/html/
fi

cd /var/www/html/RunMe
sudo cp -p RunMe.conf /etc/apache2/sites-enabled/RunMe.conf
sudo touch /var/log/runme.log
sudo chown www-data:www-data /var/log/runme.log
user=$(id -un)
sudo chown $user:$user .
sudo chown $user:$user *
sudo mkdir /var/www/.ssh
sudo chown www-data:www-data /var/www/.ssh
sudo chmod 700 /var/www/.ssh

sudo apt-get install sqlite3 -y
sudo apt-get install php-sqlite3 -y
sudo sed -i "s/\[sqlite3\]/\[sqlite3\]\nextension=sqlite.so/" /etc/php/7.2/apache2/php.ini
sudo systemctl restart apache2

echo
echo "Please copy runme.ini.sample to runme.ini and edit it."

