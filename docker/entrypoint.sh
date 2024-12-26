#!/bin/sh

chgrp www-data /dev/video*; \
chmod 775 /dev/video*;

# dockerfile, esp for prod, might have created all laravel files with default uid gid, so I need to check and update them
CURR_OWN=$(ls -ld ./storage | awk '{print $3}');
if [ "$CURR_OWN" != "www-data" ];
then
  echo "changing ownership of all files, pls be patient, this can take a long time";
  chown -R www-data .;
fi;

CURR_GRP=$(ls -ld ./storage | awk '{print $4}');
if [ "$CURR_GRP" != "www-data" ];
then
  echo "changing group on all files, pls be patient, this can take a long time";
  chgrp -R www-data .;
fi;

chown www-data:www-data /database public/timelapse;
gosu www-data touch /database/database.sqlite;

#ONLY NOW I CAN START WRITING INTO THE LARAVEL DIRECTORY
#create empty directories, because in production laravel might complain that paths don't exist even if redis is used

gosu www-data mkdir -p \
  storage/framework/cache/data \
  storage/framework/sessions \
  storage/framework/testing \
  storage/framework/views;

# some of these can't be in dockerfile probably because of .env values being cached too early
gosu www-data php artisan config:clear;
gosu www-data php artisan view:clear;
gosu www-data php artisan route:clear;
gosu www-data php artisan event:clear;

/usr/bin/supervisord -n -c /etc/supervisord.conf;
