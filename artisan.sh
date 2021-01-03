#!/bin/bash

if [[ "$EUID" -ne 0 ]]; then
echo "Error: Please run as root." >&2
exit 1
fi

if ! [ -x "$(command -v docker-compose)" ]; then
echo 'Error: docker-compose is not installed.' >&2
exit 1
fi

docker-compose exec php artisan "$@"
