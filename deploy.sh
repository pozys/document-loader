make env-prepare

sudo sed -i -- "s|%SERVER_NAME%|$1|g" $2/external/nginx/conf.d/app.conf
sudo sed -i -- "s|%APP_URL%|$3|g" .env
sudo sed -i -- "s|%DB_PASSWORD%|$4|g" .env
sudo sed -i -- "s|%APP_ENV%|$5|g" .env
sudo sed -i -- "s|%APP_DEBUG%|$6|g" .env

make install-prod
make key
make compose-deploy-start
make build-frontend
make db-migrate
make db-seed
make compose-deploy-down
