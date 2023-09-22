#!/bin/bash

importDb() {
	echo "--------- START: IMPORT MYSQL DB $1 < $2 ---------"
	mysql -hmysql -uroot -psecret -e "CREATE DATABASE IF NOT EXISTS $1"
	mysql -hmysql -uroot -psecret $1 < /mysql-dump/$2		
	echo "---------   END: IMPORT MYSQL DB $1 < $2 ---------"
}

init() {				
	sh /usr/local/bin/docker-php-entrypoint php-fpm	&
	chmod -R 777 /socket
	#gulp --gulpfile=/gulp/gulpfile.js watchSass &
    tail -f /var/www/html/project/var/log/dev.log /var/www/html/project/var/log/error.log
}


case "$1" in	
	importDb)
		importDb "$2" "$3"
		;;

	init)
		init
		;;	

	psalm)
#		update_php_dependences

		./vendor/bin/psalm
		;;

	cs)
#		update_php_dependences

		./vendor/bin/phpcs -n
		;;

	csgithub)
#		update_php_dependences

		./vendor/bin/phpcs --report=summary -n -p
		;;

	cbf)
#		update_php_dependences

		./vendor/bin/phpcbf
		;;

	pstan)
		./vendor/bin/phpstan analyse
		;;

	bash)
		/bin/bash
		;;

	*)
		echo "This container accepts the following commands:"
		echo "- importDb <name.sql>"
		echo "- Init"		
		echo "- psalm"
		echo "- cs (CodeSniffer phpcs)"
		echo "- cbf (CodeSniffer phpcbf)"
		echo "- pstan (PHPStan)"
		echo "- bash"
		exit 1
esac