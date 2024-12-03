#!/bin/bash

export USERID=$(id -u)
export GID=$(id -g)

./exec -it -u www-data app php "${@:1}"
