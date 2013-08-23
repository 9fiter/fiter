#!/bin/sh
bkp_path=$1

installpath=$2
. $installpath/getFolder.sh

bkp_path_now=$(getFolder $bkp_path bkp_path_now)

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

fiter_path=${14}
#	 script					1 			  2         3            4             5           6           7        8         9              10             11         12              13              14                       
bash $installpath/backup.sh $bkp_path_now $bkp_path $installpath $minecraft_db $user_mc_db $pass_mc_db $mc_path $fiter_db $user_fiter_db $pass_fiter_db $phpbb3_db $user_phpbb3_db $pass_phpbb3_db $fiter_path> $bkp_path_now/backup.log
#bash $installpath/backup.sh $bkp_path_now $bkp_path $installpath > $bkp_path_now/backup.log




