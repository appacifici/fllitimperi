#!/bin/sh

rm pluginActive && ln -s $1 pluginActive
sudo chmod -R 777 var/ && php bin/console   cache:clear -e=dev
sudo chmod -R 777 var/
redis-cli flushall
service apache2 restart
sh createSymlink.sh