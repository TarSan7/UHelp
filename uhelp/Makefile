include .env
export

ifeq ($(SKIP_DOCKER), true)
    NODE := yarn
    ARTISAN := php artisan
    MYSQL :=
else
    NODE := node yarn
    ARTISAN := php artisan
    MYSQL :=  -T mysql
endif

.PHONY: start stop restart build \
	ssh env \
	truncate migrate seed reset-db \
	node-dev node-install node-test node-watch \
	composer-install dump-autoload \
	keygen \
	deploy phpunit frontend-build good \
	telescope

OS := $(shell uname)

env:
	cp ./.env.example ./.env

permissions:
	@$(FPM) chmod -R 777 storage

keygen:
	@$(ARTISAN) key:generate

cache-clear:
	@$(ARTISAN) cache:clear
	@$(ARTISAN) view:clear

clear:
	@$(ARTISAN) optimize:clear

truncate:
	@$(ARTISAN) db:wipe

migrate:
	@$(ARTISAN) migrate

migrate-test:
	@$(ARTISAN) migrate --env=testing

rollback:
	@$(ARTISAN) migrate:rollback

create-test-db:
	@$(ARTISAN) test:clean-test-database --env=testing

test-db: clear create-test-db

fresh:
	@$(ARTISAN) migrate:fresh

fresh-test:
	@$(ARTISAN) migrate:fresh --env=testing

seed:
	@$(ARTISAN) db:seed

seed-test:
	@$(ARTISAN) db:seed --env=testing

frontend-build:
	@$(ARTISAN) platform:frontend

tinker:
	@$(ARTISAN) tinker

reset-db: truncate migrate seed

reset-db-test: fresh-test seed-test

npm-install:
	npm install

npm-build:
	npm run build

npm-serve:
	npm run serve-container

node-watch-poll:
	@$(NODE) run watch-poll

npm-dev:
	npm run dev

node-test:
	@$(NODE) run test

e2e-ci:
	@$(NODE) -T run e2e:headless

ui:
	@$(NODE) run serve:mockups

eslint:
	@$(NODE) run lint

composer-install:
	@$(FPM) composer install

phpunit:
	@$(FPM) vendor/bin/phpunit

phpunit-coverage:
	@$(FPM) vendor/bin/phpunit -c phpunit.xml --log-junit public/reports/phpunit.xml --coverage-html public/reports/coverage --coverage-clover public/reports/coverage.xml

test: node-test phpunit

deploy: env start composer-install keygen migrate seed frontend-build node-install node-dev

deploy-sync: env start-sync composer-install keygen migrate seed frontend-build node-install node-dev

telescope:
	@$(ARTISAN) telescope:publish

dump-autoload:
	@$(FPM) composer dump-autoload

dumpautoload:
	@$(FPM) composer dumpautoload

download-dump:
	$(MYSQL) mysqldump -h $(REMOTE_DB_HOST) -u $(REMOTE_DB_USERNAME) -p$(REMOTE_DB_PASSWORD) $(REMOTE_DB_DATABASE) > storage/database.sql

import-dump:
	cat storage/database.sql | $(MYSQL) mysql -u $(DB_USERNAME) -p$(DB_PASSWORD) $(DB_DATABASE)

reimport: truncate import-dump

update: composer-install node-install frontend-build migrate seed

fix_permissions:
	@$(FPM_SU) chown www-data:www-data -R /home/www-data
	@$(FPM_SU) chown www-data:www-data -R .
	@$(FPM) find . -type d -exec chmod 755 {} \;
	@$(FPM) find . -type f -exec chmod 644 {} \;
	@$(FPM) find ./vendor/bin -type f -exec chmod 755 {} \;
