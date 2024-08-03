set -e
sudo sed -i -- "s|%SERVER_NAME%|$1|g" $2/external/nginx/conf.d/app.conf
make compose-restart
