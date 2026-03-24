install:
	composer install

lint:
	composer lint

test:
	composer test

test-coverage:
	composer exec -- phpunit tests --coverage-clover build/logs/clover.xml

validate:
	composer validate