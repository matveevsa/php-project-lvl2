install:
	composer install
lint:
	composer run-script phpcs -- --standard=PSR12 src bin
unpublish:
	composer global remove matveevsa/php-project-lvl2
publish:
	composer global require matveevsa/php-project-lvl2:dev-master