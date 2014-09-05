#!/usr/bin/env bash

echo "==> Downloading the package lists from the repositories and updating them to get information on the newest versions of packages and their dependencies..."
sudo apt-get update > /dev/null

echo "==> Fetching new versions of packages existing on the machine..."
sudo apt-get upgrade -y > /dev/null 2>&1

echo "==> Installing system packages..."
sudo apt-get install -y git > /dev/null 2>&1

echo "==> Installing WEB server Apache..."
sudo apt-get install -y apache2 > /dev/null 2>&1

echo "==> Installing PHP..."
sudo apt-get install -y php5 > /dev/null 2>&1

echo "==> Installing PostgreSQL and administration interface..."
sudo apt-get install -y postgresql phppgadmin > /dev/null 2>&1

echo "==> Installing MySQL and administration interface..."
sudo DEBIAN_FRONTEND=noninteractive apt-get install -q -y mysql-server phpmyadmin > /dev/null 2>&1

echo "==> Setting up project root..."
sudo rm -rf /var/www/html/
sudo ln -s /vagrant/public/ /var/www/html

echo "===> Preparing configuration for phpMyAdmin..."
wget https://raw.githubusercontent.com/gyKa/setup/master/vagrant/etc/phpmyadmin/config.inc.php > /dev/null 2>&1
sudo mv config.inc.php /etc/phpmyadmin/

echo "===> Preparing configuration for Apache..."
wget https://raw.githubusercontent.com/gyKa/setup/master/vagrant/etc/apache2/apache2.conf > /dev/null 2>&1
sudo mv apache2.conf /etc/apache2/
wget https://raw.githubusercontent.com/gyKa/setup/master/vagrant/etc/apache2/sites-available/000-default.conf > /dev/null 2>&1
sudo mv 000-default.conf /etc/apache2/sites-available/
sudo a2enmod rewrite
sudo service apache2 restart > /dev/null 2>&1

echo "===> Preparing configuration for phpPgAdmin..."
wget https://raw.githubusercontent.com/gyKa/setup/master/vagrant/etc/apache2/conf.d/phppgadmin > /dev/null 2>&1
sudo mv phppgadmin /etc/apache2/conf.d/
wget https://raw.githubusercontent.com/gyKa/setup/master/vagrant/usr/share/phppgadmin/conf/config.inc.php > /dev/null 2>&1
sudo mv config.inc.php /usr/share/phppgadmin/conf/

echo "===> Preparing configuration for PostgreSQL..."
wget https://raw.githubusercontent.com/gyKa/setup/master/vagrant/etc/postgresql/9.3/main/pg_hba.conf > /dev/null 2>&1
sudo mv pg_hba.conf /etc/postgresql/9.3/main/
sudo /etc/init.d/postgresql restart
sudo -u postgres psql -c "ALTER USER postgres PASSWORD 'postgres';" > /dev/null
psql -c 'create database transi' -U postgres > /dev/null

echo "===> Preparing configuration for MySQL..."
mysql -u root -e "create database transi"

make dev-install -C /vagrant
