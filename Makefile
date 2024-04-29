ifeq ($(shell command -v podman 2> /dev/null),)
    CMD=docker
else
    CMD=podman
endif

.PHONY: up
up:
	$(CMD) compose up -d --remove-orphans

.PHONY: down
down:
	$(CMD) compose down

.PHONY: build
build:
	$(CMD) compose build --pull

.PHONY: enter
enter:
	$(CMD) compose exec app /bin/sh

.PHONY: vite
vite:
	$(CMD) compose exec app npm -- run dev --host