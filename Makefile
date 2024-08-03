console:
	docker exec -it application php artisan tinker

db-prepare:
	docker exec application php artisan migrate:fresh --force --seed

db-migrate:
	docker exec application php artisan migrate --force && php artisan db:seed --force

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

install-prod:
	composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

env-prepare:
	cp -n .env.example .env || true

key:
	docker exec application php artisan key:generate --force

test:
	docker exec application php artisan test

start-frontend:
	npm run dev

build-frontend:
	npm install && npm run build

lint:
	composer exec phpcs
