.PHONY: up
up:
	podman compose up -d --remove-orphans

.PHONY: down
down:
	podman compose down

.PHONY: build
build:
	podman compose build --pull

.PHONY: enter
enter:
	podman compose exec app /bin/sh

.PHONY: vite
vite:
	podman compose exec app npm -- run dev --host