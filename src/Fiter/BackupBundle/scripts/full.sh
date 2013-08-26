#!/bin/bash -xv
now=$(date +'%Y%m%d%H%M%S')
file=${now}_fullbackup_fiter.tar.bz2

tar jcvf /home/backup/temp/${now}_fullbackup_fiter.tar.bz2 --exclude-from=/home/web/fiter/src/Fiter/BackupBundle/scripts/exclude /home/web/fiter/web/uploads /home/web/fiter/web/mcskin/img

mv /home/backup/temp/$file /home/backup/$file
mv /home/backup/temp/$file.log /home/backup/$file.log