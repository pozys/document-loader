console:
	docker exec -it application php artisan tinker

db-prepare:
	php artisan migrate:fresh --force --seed

compose: compose-clear compose-setup compose-start

compose-start:
	docker compose up --abort-on-container-exit

compose-restart:
	docker compose restart

compose-setup: compose-build
	docker compose run --rm application make setup

compose-stop:
	docker compose stop || true

compose-down:
	docker compose down --remove-orphans || true

compose-clear:
	docker compose down -v --remove-orphans || true

compose-build:
	docker compose build

setup: env-prepare install key db-prepare build-frontend

install:
	composer install

env-prepare:
	cp -n .env.example .env || true

key:
	php artisan key:generate --force

test:
	php artisan test

start-frontend:
	npm run dev

build-frontend:
	npm install && npm run build

lint:
	composer exec phpcs
