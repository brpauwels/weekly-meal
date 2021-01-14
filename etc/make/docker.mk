DOCKER_COMPOSE ?= docker-compose -f etc/docker/docker-compose.$(ENVIRONMENT).yml
MAIN_CONTAINER ?= app

up: ##dev# Starts up all containers defined in Docker Compose
	$(DOCKER_COMPOSE) up -d

down: ##dev# Takes down all containers defined in Docker Compose
	$(DOCKER_COMPOSE) down --remove-orphans

logs: ##dev# Open a tail to the logs of all containers defined in Docker Compose
	$(DOCKER_COMPOSE) logs -f

ps: ##dev# Show details and status of all containers defined in Docker Compose
	$(DOCKER_COMPOSE) ps

pull: ##dev# Pull Docker images defined in Docker Compose
	$(DOCKER_COMPOSE) pull

exec: ##dev# Exec into the PHP container (search-api service)
	$(DOCKER_COMPOSE) exec ${MAIN_CONTAINER} sh

domains: ##dev# List all registered domains for all containers defined in Docker Compose
	$(DOCKER_COMPOSE) ps -q | xargs -I % docker exec % /bin/sh -c "test -z \$$VIRTUAL_HOST ||echo https://\$$VIRTUAL_HOST"
