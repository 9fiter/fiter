#!/bin/bash -xv
now=$(date +'%Y%m%d%H%M%S')
file=${now}_fullbackup_fiter.tar.bz2

#echo "tar jcvf /home/backup/temp/${now}_fullbackup_fiter.tar.bz2 --exclude-from=/home/web/fiter/src/Fiter/BackupBundle/scripts/exclude /home/web/fiter/web/uploads /home/web/fiter/web/mcskin/img"
#tar jcvf /home/backup/temp/${now}_fullbackup_fiter.tar.bz2 --exclude-from=/home/web/fiter/src/Fiter/BackupBundle/scripts/exclude /home/web/fiter/web/uploads /home/web/fiter/web/mcskin/img

nohup tar cvf /home/backup/temp/${now}_fullbackup_fiter.tar.bz2 /home/juegos/minecraft/craftopia > /home/backup/tar.output.txt 2> /home/backup/tar.errors.txt < /dev/null &

#nohup tar ... > /tmp/tar.output.txt 2> /tmp/tar.errors.txt < /dev/null &'

#echo "mv /home/backup/temp/$file /home/backup/$file"
mv /home/backup/temp/$file /home/backup/$file
#echo "mv /home/backup/temp/$file.log /home/backup/$file.log"
mv /home/backup/temp/$file.log /home/backup/$file.log