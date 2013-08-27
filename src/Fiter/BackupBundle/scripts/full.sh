#!/bin/bash
now=$(date +'%Y-%m-%d:%H-%M-%S')
file=${now}_fullbackup_fiter.tar.bz2

nohup tar jcvf /home/backup/$file --exclude-from=/home/web/fiter/src/Fiter/BackupBundle/scripts/exclude /home/web/fiter/web/uploads /home/web/fiter/web/mcskin/img > /home/backup/$file.output.log 2> /home/backup/$file.errors.log < /dev/null &
