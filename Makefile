.DEFAULT_GOAL := help
.PHONY: help build migrate
help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[%a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

docker_file=./.docker/docker-compose.yaml

APP_CONTAINER=php-fpm
MYSQL_CONTAINER=mysql
NGINX_CONTAINER=nginx

up: ## Start all containers (in background) for development
	docker-compose -f ${docker_file} up -d

down: ## Stop all started for development containers
	docker-compose -f ${docker_file} down -v --remove-orphans

init: ## Build container, init db and apply fixtures
	make build up app-init migrate fixtures

restart: ## Restart all started for development containers
	docker-compose -f ${docker_file} restart

build: ## Build all containers
	docker-compose -f ${docker_file} rm -vsf
	docker-compose -f ${docker_file} down -v --remove-orphans
	docker-compose -f ${docker_file} build

fixtures: ## Loads fixtures to database.
	docker-compose -f ${docker_file} exec ${APP_CONTAINER} ./bin/console doctrine:fixtures:load --no-interaction

migrate: ## Runs application migrations.
	docker-compose -f ${docker_file} exec ${APP_CONTAINER} ./bin/console doctrine:migrations:migrate ---no-interaction

app-init: ## Init application (composer install).
	docker-compose -f ${docker_file} exec ${APP_CONTAINER} composer install --no-interaction

jumpin: ## Start shell into application container
	docker-compose -f ${docker_file} exec ${APP_CONTAINER} /bin/bash

run-test: ## Run tests in container
	docker-compose -f ${docker_file} exec ${APP_CONTAINER} php ./bin/phpunit $(param)

make_migration: ## Runs application migrations.
	docker-compose -f ${docker_file} exec ${APP_CONTAINER} ./bin/console make:migration

tail-logs: ## Display all logs from containers
	docker-compose -f ${docker_file} logs -f ${APP_CONTAINER}

dps: ## Status docker containers
	docker-compose -f ${docker_file} ps
