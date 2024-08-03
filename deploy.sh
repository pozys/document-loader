set -e
sudo sed -i -- "s|%SERVER_NAME%|$1|g" $2/external/nginx/conf.d/app.conf
sudo sed -i -- "s|%APP_URL%|$2|g" .env
sudo sed -i -- "s|%DB_PASSWORD%|$3|g" .env

make db-migrate
make db-seed
make install-prod
make build-frontend
make compose-restart
