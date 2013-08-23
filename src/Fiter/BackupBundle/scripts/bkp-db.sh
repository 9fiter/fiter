db_name=$1
db_user=$2
db_pass=$3
return_file=$4
ignores=$5

echo "Backup fiter DB to $return_file file, please wait..."
#mysqldump -u $db_user -p$db_pass $db_name --ignore-table=$db_name.co_blocks | gzip > $return_mc_db_file
#mysqldump -u $db_user -p$db_pass $db_name $ignores | gzip > $return_file
mysqldump -u $db_user -p$db_pass $db_name | gzip > $return_file
echo "Backup fiter DB to $return_file complete"