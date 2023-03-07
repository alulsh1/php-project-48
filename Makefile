install:
	composer install
test:
	composer exec --verbose phpunit tests
lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin tests
test-coverage:
	composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml