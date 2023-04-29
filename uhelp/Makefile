include .env
export

ifeq ($(SKIP_DOCKER), true)
    DC :=
    FPM :=
    NODE := yarn
    ARTISAN := php artisan
    MYSQL :=
else
    DC := docker-compose exec
    DC_SYNC := CURRENT_USER=${CURRENT_ID}:${CURRENT_GROUP} docker-compose --file docker-compose-sync.yml
    FPM := $(DC) php-fpm
    FPM_SU := $(DC) --user=root php-fpm
    NODE := $(DC) node yarn
    ARTISAN := $(FPM) php artisan
    MYSQL := $(DC) -T mysql
    CURRENT_UID := $(shell id -u)
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

start:
	sudo docker-compose up -d

stop:
	sudo docker-compose stop

# Docker sync for MacOs
start-sync:
	docker volume create --name=px
	@$(DC_SYNC) up -d
	docker-sync start

# Docker sync for MacOs
stop-sync:
	docker-sync stop
	@$(DC_SYNC) down

restart: stop start

build:
	@docker-compose build --no-cache --build-arg USER_ID=$(CURRENT_UID)

env:
	cp ./.env.example ./.env

ssh:
	@$(FPM) bash

ssh-su:
	@$(FPM_SU) bash

ssh-node:
	$(DC) node bash

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

node-install:
	@$(NODE) install

node-build:
	@$(NODE) run build

node-landing:
	@$(NODE) run landing

node-serve:
	@$(NODE) run serve-container

node-watch-poll:
	@$(NODE) run watch-poll

node-dev:
	@$(NODE) run dev

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

phpcs:
	@$(FPM) vendor/bin/phpcs --standard=./phpcs.xml ./

phpcbf:
	@$(FPM) vendor/bin/phpcbf --standard=./phpcs.xml ./

phpmd:
	@$(FPM) vendor/bin/phpmd ./ ansi ./phpmd.xml

deploy: env start composer-install keygen migrate seed frontend-build node-install node-dev

deploy-sync: env start-sync composer-install keygen migrate seed frontend-build node-install node-dev


telescope:
	@$(ARTISAN) telescope:publish

sync-templates:
	@$(ARTISAN) backbone:sync:native

sync-products:
	@$(ARTISAN) backbone:sync:product

sync-custom-fields:
	@$(ARTISAN) backbone:sync:custom-fields

sync-targeting:
	@$(ARTISAN) platform:ad-server:sync:targeting

sync: cache-clear sync-products sync-templates sync-custom-fields sync-targeting

good:
	echo "\e[32mMaking everything GOOD is in progress" \
	&& make composer-install && make frontend-build && make node-install && make node-build && make migrate && make seed \
	&& echo "\e[32mEverything is GOOD now"

setup: env start good permissions

reset: good reset-db sync

dump-autoload:
	@$(FPM) composer dump-autoload

dumpautoload:
	@$(FPM) composer dumpautoload

download-dump:
	$(MYSQL) mysqldump -h $(REMOTE_DB_HOST) -u $(REMOTE_DB_USERNAME) -p$(REMOTE_DB_PASSWORD) $(REMOTE_DB_DATABASE) > storage/database.sql

import-dump:
	cat storage/database.sql | $(MYSQL) mysql -u $(DB_USERNAME) -p$(DB_PASSWORD) $(DB_DATABASE)

import-remote:	download-dump truncate import-dump

reimport: truncate import-dump

update: composer-install node-install frontend-build migrate seed

fix_permissions:
	@$(FPM_SU) chown www-data:www-data -R /home/www-data
	@$(FPM_SU) chown www-data:www-data -R .
	@$(FPM) find . -type d -exec chmod 755 {} \;
	@$(FPM) find . -type f -exec chmod 644 {} \;
	@$(FPM) find ./vendor/bin -type f -exec chmod 755 {} \;

activate-products:
	$(MYSQL) mysql -u $(DB_USERNAME) -p$(DB_PASSWORD) -e "USE core; update products set is_active=1;"

prepare-translations:
	@$(ARTISAN) platform:phrase:generate-translation-files
