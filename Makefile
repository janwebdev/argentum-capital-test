-include .env

DOCKER ?= docker
DOCKER_COMPOSE ?= docker compose
#EXECUTE_NGINX ?= $(DOCKER_COMPOSE) exec nginx
EXECUTE_FPM ?= $(DOCKER_COMPOSE) exec php-fpm

# target: [ps] - ps docker
ps:
	$(DOCKER_COMPOSE) ps
.PHONY: ps

# target: [up] - UP docker
up:
	$(DOCKER_COMPOSE) up --remove-orphans -d
.PHONY: up

# target: [down] - Down Docker
down:
	$(DOCKER_COMPOSE) down --remove-orphans
.PHONY: down

# target: [ssh] - Open SSH connection with erp-php container
ssh:
	$(EXECUTE_FPM) bash
.PHONY: ssh

# target: [restart] - Restart docker
restart:
	$(DOCKER_COMPOSE) restart
.PHONY: restart

# target: [start] - Stop docker
start:
	$(DOCKER_COMPOSE) start
.PHONY: start

# target: [stop] - Stop docker
stop:
	$(DOCKER_COMPOSE) stop
.PHONY: stop

# target: [logs] - Show docker logs
logs:
	$(DOCKER_COMPOSE) logs -f
.PHONY: logs

# target: [composer-update] - Composer update
composer-update:
	$(EXECUTE_PFM) composer update
.PHONY: composer-update

# target: [composer-install] - Composer install
composer-install:
	$(EXECUTE_PFM) composer install
.PHONY: composer-install