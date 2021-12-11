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

css:
	@docker exec -e APP_ENV=test -it $(PHP) composer css

fcs:
	@docker exec -e APP_ENV=test -it $(PHP) composer fcs

ci:
	@docker exec -e APP_ENV=test -it $(PHP) composer ci

### DATA FIXTURES ###
fixtures:
	@docker exec -e APP_ENV=test -it $(PHP) composer fixtures