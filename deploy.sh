make env-prepare
sudo sed -i -- "s|%SERVER_NAME%|$1|g" $2/external/nginx/conf.d/app.conf
sudo sed -i -- "s|%APP_URL%|$3|g" .env
sudo sed -i -- "s|%DB_PASSWORD%|$4|g" .env

make install-prod
make compose-restart
make db-migrate
make db-seed
make build-frontend
