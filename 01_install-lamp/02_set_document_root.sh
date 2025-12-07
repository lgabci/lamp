#!/bin/sh
set -eu

if [ "$USER" != "root" ]; then
  echo "$(basename $0): This script needs to be run by sudo."
  exit 1
fi

if ! grep -q lamp-public-html /etc/fstab; then
  mkdir -p /var/www/lamp-public-html
  echo '/home/gabci/projects/lamp/www/public-html /var/www/lamp-public-html none bind 0 0' >>/etc/fstab
  systemctl daemon-reload
  mount /home/gabci/projects/lamp/www/public-html
fi

if [ ! -e /etc/apache2/sites-available/lamp.conf ]; then
  sed -e 's/\(DocumentRoot\) .*/\1 \/var\/www\/lamp-public-html/' \
    /etc/apache2/sites-available/000-default.conf \
    >/etc/apache2/sites-available/lamp.conf
fi

restart=""

if [ ! -e /etc/apache2/sites-enabled/lamp.conf ]; then
  a2ensite lamp.conf
  restart="Y"
fi

if [ -e /etc/apache2/sites-enabled/000-default.conf ]; then
  a2dissite 000-default.conf
  restart="Y"
fi

if [ "$restart" = "Y" ]; then
  systemctl restart apache2.service
fi
