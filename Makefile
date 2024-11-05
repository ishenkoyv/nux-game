#!/usr/bin/make
# Makefile readme: <https://www.gnu.org/software/make/manual/html_node/index.html#SEC_Contents>

cwd = $(shell pwd)

SHELL = /bin/sh

APP_CONTAINER_NAME := php
NODE_CONTAINER_NAME := php

docker_bin := $(shell command -v docker 2> /dev/null)
docker_compose_bin := $(shell command -v docker-compose 2> /dev/null)

# --- [ Development tasks ] -------------------------------------------------------------------------------------------

---------------: ## ---------------

logs: ## Show docker logs
	$(docker_compose_bin) logs --follow

up: ## Start all containers (in background) for development
	$(docker_compose_bin) up --no-recreate -d

down: ## Stop all started for development containers
	$(docker_compose_bin) down

restart: up ## Restart all started for development containers
	$(docker_compose_bin) restart

shell: up ## Start shell into application container
	$(docker_compose_bin) exec "$(APP_CONTAINER_NAME)" /bin/sh

install: up ## Install application dependencies into application container
	$(docker_compose_bin) up --build --no-recreate -d
	$(docker_compose_bin) exec "$(APP_CONTAINER_NAME)" chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
	$(docker_compose_bin) exec "$(APP_CONTAINER_NAME)" chmod -R 775 /var/www/storage /var/www/bootstrap/cache
	$(docker_compose_bin) exec "$(APP_CONTAINER_NAME)" composer setup --no-interaction --ansi --no-suggest

init: install ## Make full application initialization (install, seed, build assets, etc)
	$(docker_compose_bin) exec "$(APP_CONTAINER_NAME)" php artisan migrate --force --no-interaction -vvv
	$(docker_compose_bin) exec "$(APP_CONTAINER_NAME)" php artisan db:seed --force -vvv
	$(docker_compose_bin) run --rm "$(NODE_CONTAINER_NAME)" npm run dev

test: up ## Execute application tests
	$(docker_compose_bin) exec -T "$(APP_CONTAINER_NAME)" composer test
