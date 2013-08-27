#!/bin/bash -xv
now=$(date +'%Y%m%d%H%M%S')
file=${now}_fullbackup_fiter.tar.bz2

#echo "tar jcvf /home/backup/temp/${now}_fullbackup_fiter.tar.bz2 --exclude-from=/home/web/fiter/src/Fiter/BackupBundle/scripts/exclude /home/web/fiter/web/uploads /home/web/fiter/web/mcskin/img"
##tar jcvf /home/backup/temp/${now}_fullbackup_fiter.tar.bz2 --exclude-from=/home/web/fiter/src/Fiter/BackupBundle/scripts/exclude /home/web/fiter/web/uploads /home/web/fiter/web/mcskin/img

### este funciona
#nohup tar jcvf /home/backup/temp/${now}_fullbackup_fiter.tar.bz2 --exclude-from=/home/web/fiter/src/Fiter/BackupBundle/scripts/exclude /home/web/fiter/web/uploads /home/web/fiter/web/mcskin/img > /home/backup/tar.output.txt 2> /home/backup/tar.errors.txt < /dev/null &


nohup tar jcvf /home/backup/temp/${now}_fullbackup_fiter.tar.bz2 --exclude-from=/home/web/fiter/src/Fiter/BackupBundle/scripts/exclude /home/web/fiter/web/uploads /home/web/fiter/web/mcskin/img > /home/backup/logs/$file.output.log 2> /home/backup/logs/$file.errors.log < /dev/null &
