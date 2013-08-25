bkp_path=$1
installpath=$2
mc_path=$3
fiter_path=$4

now=$(date +'%Y-%m-%d-%T')
exclude=$installpath/exclude

mc_skin_path=$fiter_path/web/mcskin/img
fiter_uploads_path=$fiter_path/web/uploads

file=${now}_fullbackup.tar.bz2
file2=${now}_diffbackup_from_01`date +%b%y`.tar.bz2