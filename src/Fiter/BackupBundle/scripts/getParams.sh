bkp_path=$1
installpath=$2
fiter_path=$3

now=$(date +'%Y%m%d%H%M%S')
exclude=$installpath/exclude

mc_skin_path=$fiter_path/web/mcskin/img
fiter_uploads_path=$fiter_path/web/uploads

file=${now}_fullbackup_fiter.tar.bz2
file2=${now}_diffbackup_fiter_from_01`date +%b%y`.tar.bz2