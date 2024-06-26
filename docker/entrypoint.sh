#!/bin/bash

chgrp developer /dev/video*; \
chmod 775 /dev/video*;

# dockerfile, esp for prod, might have created all laravel files with default uid gid, so I need to check and update them
CURR_OWN=$(ls -ld ./storage | awk '{print $3}');
if [ "$CURR_OWN" != "developer" ];
then
  echo "changing ownership of all files, pls be patient, this can take a long time";
  chown -R developer .;
fi;

CURR_GRP=$(ls -ld ./storage | awk '{print $4}');
if [ "$CURR_GRP" != "developer" ];
then
  echo "changing group on all files, pls be patient, this can take a long time";
  chgrp -R developer .;
fi;

#ONLY NOW I CAN START WRITING INTO THE LARAVEL DIRECTORY
#create empty directories, because in production laravel might complain that paths don't exist even if redis is used

gosu developer mkdir -p \
  /home/developer/apache2 \
  storage/framework/cache/data \
  storage/framework/sessions \
  storage/framework/testing \
  storage/framework/views;

set -a
gosu developer cp /run/secrets/env &BASE_DIR&/.env;

# some of these can't be in dockerfile probably because of .env values being cached too early
gosu developer php artisan config:clear;
gosu developer php artisan view:clear;
gosu developer php artisan route:clear;
gosu developer php artisan event:clear;

/usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf;
