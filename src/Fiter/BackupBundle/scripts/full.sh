now=$(date +'%Y%m%d%H%M%S')
file=${now}_fullbackup_fiter.tar.bz2

tar jcvf /home/backup/temp/${now}_fullbackup_fiter.tar.bz2 --exclude-from=/home/web/fiter/src/Fiter/BackupBundle/scripts/exclude /home/web/fiter/web/uploads /home/web/fiter/web/mcskin/img

mv $bkp_path/temp/$file $bkp_path/$file
mv $bkp_path/temp/$file.log $bkp_path/$file.log