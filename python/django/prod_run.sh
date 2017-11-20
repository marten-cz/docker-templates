#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR

# Run database migration
./manage.py migrate

# Run application
uwsgi --ini ./uwsgi.ini
