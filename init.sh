#!/bin/bash

if [[ "$EUID" -ne 0 ]]; then
echo "Error: Please run as root." >&2
exit 1
fi

if ! [ -x "$(command -v docker-compose)" ]; then
echo 'Error: docker-compose is not installed.' >&2
exit 1
fi

if [[ -f ".env" ]]; then
    while true; do
        echo "A .env configuration file already exists"
        read -p "Do you want to overwrite it? " yn
        case $yn in
            [Yy]* )
                cp .env.example .env
                ;;
            [Nn]* )
                break
                ;;
            * )
                echo "Please answer yes or no."
                ;;
        esac
    done
    echo

    else

    cp .env.example .env

fi

"${EDITOR:-vi}" .env

echo "### Installing php dependencies with composer"
docker run --rm --interactive --tty \
  --volume $PWD:/app \
  --volume ${COMPOSER_HOME:-$HOME/.composer}:/tmp \
  --user $(id -u):$(id -g) \
  composer install
echo

echo "### Generating application key"
docker-compose run --rm php artisan key:generate
echo

echo "### Launching services"
docker-compose up -d
echo
