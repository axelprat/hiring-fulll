DOCKER_COMPOSE=cd docker && docker-compose

build: ## Build Docker containers
	$(DOCKER_COMPOSE) build

build-full: ## Build Docker containers (without cache)
	$(DOCKER_COMPOSE) build --pull --no-cache

up: ## Start Docker containers
	$(DOCKER_COMPOSE) up -d
	$(DOCKER_COMPOSE) run waiter

up-full: ## First launch: start containers + install dependencies
	$(DOCKER_COMPOSE) up -d --force-recreate
	$(DOCKER_COMPOSE) exec -T php composer install
	$(DOCKER_COMPOSE) run waiter

down: ## Stop Docker containers
	$(DOCKER_COMPOSE) down

bash: ## Open bash in PHP container
	$(DOCKER_COMPOSE) exec php bash

cache-clear: ## Clear Symfony cache
	$(DOCKER_COMPOSE) exec -T php php bin/console cache:clear

.DEFAULT_GOAL := help
help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.PHONY: help
