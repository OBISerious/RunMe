# RunMe
RunMe web app

To install:

```
git clone https://github.com/OBISerious/RunMe.git
cd RunMe
bash install.sh
```

Then:
```
cd /var/www/html/RunMe
cp -p runme.ini.sample runme.ini
vi servers.list
```

To create an identity file for a specific user:
```
user=<username>
vi $user.id_rsa
chmod 700 $user.id_rsa
sudo chown www-data:www-data $user.id_rsa
```
