install:
	composer install
lint:
	composer run-script phpcs -- --standard=PSR12 src bin
test:
	./vendor/phpunit/phpunit/phpunit tests
unpublish:
	composer global remove matveevsa/php-project-lvl2
publish:
	composer global require matveevsa/php-project-lvl2:dev-master