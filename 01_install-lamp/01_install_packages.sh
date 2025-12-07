#!/bin/sh
set -eu

if [ "$USER" != "root" ]; then
  echo "$(basename $0): This script needs to be run by sudo."
  exit 1
fi

installpkgs=""
pkgs="apache2 mariadb-server php libapache2-mod-php php-mysql"
for a in $pkgs; do
  if ! dpkg -l "$a" >/dev/null 2>&1; then
    installpkgs="$installpkgs $a"
  fi
done

if [ -n "$installpkgs" ]; then
  echo "Installing packages: $installpkgs"
  apt install $installpkgs
fi
