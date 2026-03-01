# Docker-first workflow for the planning project

COMPOSE ?= docker compose
APP_SERVICE ?= app
DB_SERVICE ?= database
APP_DIR ?= /app

.PHONY: build up down start stop restart ps \
	sh bash \
	composer-install composer-update composer-require yarn-install yarn-add \
	cache-clear migrate fixtures \


build: ## Build all images
	$(COMPOSE) build

up: ## Build (if needed) and start containers in background
	$(COMPOSE) up -d --build

down: ## Stop and remove containers
	$(COMPOSE) down

build-fresh: ## Build all images without cache
	$(COMPOSE) build --no-cache

up-fresh: ## Force clean build and start
	$(COMPOSE) down -v
	$(COMPOSE) build --no-cache
	$(COMPOSE) up -d

start: ## Start existing containers
	$(COMPOSE) start

stop: ## Stop running containers
	$(COMPOSE) stop

restart: ## Restart containers
	$(COMPOSE) restart

ps: ## List containers
	$(COMPOSE) ps

sh: ## Open shell in app container
	$(COMPOSE) exec $(APP_SERVICE) sh

bash: ## Open bash in server container
	$(COMPOSE) exec $(APP_SERVICE) bash

db: ## Open MySQL shell
	$(COMPOSE) exec $(DB_SERVICE) mysql -uroot -proot inspector

composer-install: ## Install PHP dependencies in container
	$(COMPOSE) exec $(APP_SERVICE) sh -lc 'composer install'

composer-update: ## Update PHP dependencies in container
	$(COMPOSE) exec $(APP_SERVICE) sh -lc 'composer update'

composer-require: ## Add package: make composer-require PKG=symfony/orm-pack
	@test -n "$(PKG)" || (echo "Usage: make composer-require PKG=vendor/package" && exit 1)
	$(COMPOSE) exec $(APP_SERVICE) sh -lc 'composer require $(PKG)'

cache-clear: ## Clear Symfony cache
	$(COMPOSE) exec $(APP_SERVICE) sh -lc 'php bin/console cache:clear'

migrate: ## Run database migrations
	$(COMPOSE) exec $(APP_SERVICE) sh -lc 'php bin/console doctrine:migrations:migrate --no-interaction'

fixtures: ## Load sample data fixtures
	$(COMPOSE) exec $(APP_SERVICE) sh -lc 'php bin/console doctrine:fixtures:load --no-interaction'

install: ## Install backend dependencies
	$(MAKE) composer-install

init: ## First-time setup (build, start, install deps)
	$(MAKE) up
	$(MAKE) install

logs: ## Tail app logs
	$(COMPOSE) logs -f $(APP_SERVICE)

clean: ## Remove containers, networks, and volumes
	$(COMPOSE) down -v --remove-orphans
