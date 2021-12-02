#!/bin/bash

# Exit immediately if a command exits with a non-zero status.
set -e

function git_pull() {
    # checkout schema-dump-default.lock
    git checkout config/Migrations/schema-dump-default.lock
    # pull
    git pull
}

function execute_migration() {
    # migrate
    bin/cake migrations migrate
    # checkout schema-dump-default.lock
    git checkout config/Migrations/schema-dump-default.lock
}

function build_frontend_data() {
    yarn install --frozen-lock
    yarn prod
}

function stop_supervisor() {
    sudo systemctl stop supervisor
}

function start_supervisor() {
    sudo systemctl start supervisor
}

function set_folder_permissions() {
    sudo chown -R deployer:www-data /var/www/super-potato
    sudo chmod -R 770 /var/www/super-potato
}

stop_supervisor

git_pull

set_folder_permissions

composer install -n --no-dev

execute_migration

start_supervisor

build_frontend_data

bin/cake cache clear_all