#!/bin/bash
# Intall the required packages
sudo apt-get install php5-common libapache2-mod-php5 php5-cli php5-xsl GraphViz curl gettext poedit git
# Active mod_rewrite
sudo a2enmod rewrite
# Restart apache
sudo service apache2 restart
# If .htaccess is not being used, check grep /etc/apache2/apache2.conf | AllowOverride, and change the conf of the html dir to AllowOverride All
