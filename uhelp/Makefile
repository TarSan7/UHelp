include .env
export

ifeq ($(SKIP_DOCKER), true)
	DOCKER_COMPOSE :=
    NODE := npm
    ARTISAN := php artisan
    MYSQL :=
else
	DOCKER_COMPOSE := sudo docker-compose
    NODE := $(DOCKER_COMPOSE) exec node yarn
    ARTISAN := sudo docker-compose exec app php artisan
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

ps:
	@$(DOCKER_COMPOSE) ps

start:
	@$(DOCKER_COMPOSE) up -d

stop:
	@$(DOCKER_COMPOSE) stop

migrate:
	@$(ARTISAN) migrate

cache-clear:
	@$(ARTISAN) cache:clear

seed:
	@$(ARTISAN) db:seed

node-install:
	@$(NODE) update

node-build:
	@$(NODE) run build

node-watch:
	@$(NODE) run watch

node-dev:
	@$(NODE) run dev
