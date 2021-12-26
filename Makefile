PHP := todo-list-php
DATABASE := todo-list-database

### DOCKER ###
build:
	@docker-compose build

up:
	@docker-compose up -d

down:
	@docker-compose down

clean:
	@docker system prune --force

php:
	@docker exec -it $(PHP) sh

db:
	@docker exec -it $(DATABASE) sh

### COMPOSER ###
composer:
	@docker exec -e APP_ENV=test -it $(PHP) composer install

### ANALYSIS ###
phpstan:
	@docker exec -e APP_ENV=test -it $(PHP) composer phpstan

parallel-lint:
	@docker exec -e APP_ENV=test -it $(PHP) composer parallel-lint

ccs:
	@docker exec -e APP_ENV=test -it $(PHP) composer ccs

fcs:
	@docker exec -e APP_ENV=test -it $(PHP) composer fcs

test:
	@docker exec -e APP_ENV=test -it $(PHP) composer test

ci:
	@docker exec -e APP_ENV=test -it $(PHP) composer ci