#!/bin/sh
set -eu

if [ "$USER" != "root" ]; then
  echo "$(basename $0): This script needs to be run by sudo."
  exit 1
fi

if ! grep -q lamp-public-html /etc/fstab; then
  echo '/home/gabci/projects/lamp/www/public-html /var/www/lamp-public-html none bind 0 0' >>/etc/fstab
fi

if [ ! -e /etc/apache2/sites-available/lamp.conf ]; then
  sed -e 's/\(DocumentRoot\) .*/\1 \/var\/www\/lamp-public-html/' \
    /etc/apache2/sites-available/000-default.conf \
    >/etc/apache2/sites-available/lamp.conf
fi


 az /etc/apache2/sites-enabledben vannak az enabled site-ok.
a2ensite lamp.conf
a2dissite 000-default.conf
apache2ctl configtest
systemctl restart apache2.service
