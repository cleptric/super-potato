#!/bin/bash

# Exit immediately if a command exits with a non-zero status.
set -e

function git_pull() {
    # checkout schema-dump-default.lock
    git checkout config/Migrations/schema-dump-default.lock
    # fetch
    git fetch --all --tags --prune
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

# composer install
composer install -n --no-dev

execute_migration

build_frontend_data

bin/cake cache clear_all