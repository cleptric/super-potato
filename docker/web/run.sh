#!/bin/bash

# wait until db is ready
# https://selahattinunlu.medium.com/how-to-wait-for-a-container-to-be-ready-757bc1a86468
# bin/cake migrations migrate

service apache2 start
service php8.1-fpm start

/bin/sh -c bash

# Important: This keeps the docker instance alive
exec supervisord -n