#!/bin/sh
rsync -avlzC --progress --stats --exclude-from exclude.txt --delete -e 'ssh -p 22' . root@96.126.98.33:/srv/www/wowauthlytics.co
