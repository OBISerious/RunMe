#!/bin/bash

sudo apt-get install apache2 php7.2-cli libapache2-mod-php -y
cd /var/www/html
sudo git clone https://github.com/OBISerious/RunMe.git
cd RunMe
sudo cp -p RunMe.conf /etc/apache2/sites-enabled/RunMe.conf
sudo touch /var/log/runme.log
sudo chown www-data:www-data /var/log/runme.log

echo "Please copy runme.ini.sample to runme.ini and edit it."

