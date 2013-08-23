do_bkp_mc_db=true
do_bkp_mc_folder=true
do_bkp_fiter_db=true
do_bkp_fiter_uploads=true
do_bkp_phpbb_db=true
do_bkp_mcskins=true

bkp_path_now=$1
bkp_path=$2
installpath=$3

#. $installpath/config.sh

minecraft_db=$4
user_mc_db=$5
pass_mc_db=$6
mc_path=$7

fiter_db=$8
user_fiter_db=$9
pass_fiter_db=${10}

phpbb3_db=${11}
user_phpbb3_db=${12}
pass_phpbb3_db=${13}

return_mc_db_file=$bkp_path_now/$minecraft_db.sql.gz	
return_mc_folder_file=$bkp_path_now/minecraft.tar.gz
return_fiter_db_file=$bkp_path_now/$fiter_db.sql.gz
return_fiter_uploads_file=$bkp_path_now/uploads.tar.gz
return_phpbb_db_file=$bkp_path_now/${phpbb3_db}.sql.gz
return_mcskin_file=$bkp_path_now/mcskin_img.zip

fiter_path=${14}
phpbb3_path=$fiter_path/web/phpbb3
mcskins_path=$fiter_path/web/mcskin/img

echo "Backup to $bkp_path_now"

if $do_bkp_fiter_db ; then
	sh $installpath/bkp-db.sh $fiter_db $user_fiter_db $pass_fiter_db $return_fiter_db_file
fi

if $do_bkp_fiter_uploads ; then
	#sh $installpath/bkp-zip.sh $bkp_path_now/uploads.zip $fiter_path/web/uploads
	sh $installpath/bkp-tar.sh $return_fiter_uploads_file $fiter_path/web/uploads $installpath/fiter_uploads/exclude_fiter_uploads
fi

if $do_bkp_phpbb_db ; then
	sh $installpath/bkp-db.sh $phpbb3_db $user_phpbb3_db $pass_phpbb3 $return_phpbb_db_file
fi

if $do_bkp_mcskins ; then
	sh $installpath/bkp-zip.sh $return_mcskin_file $mcskins_path
fi

if $do_bkp_mc_db ; then
	sh $installpath/bkp-db.sh $minecraft_db $user_mc_db $pass_mc_db $return_mc_db_file "--ignore-table=$minecraft_db.co_blocks"
fi

if $do_bkp_mc_folder ; then
	sh $installpath/bkp-tar.sh $return_mc_folder_file $mc_path $installpath/mc_folder/exclude_mc_folder
fi

