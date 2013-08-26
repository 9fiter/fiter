#!/bin/sh
bkp_path=$1
exclude=$2
fiter_uploads_path=$3
mc_skin_path=$4
file=$5

echo tar -jcvf $bkp_path/temp/$file --exclude-from=$exclude $fiter_uploads_path $mc_skin_path -N $(date +"%Y-%m-01 00:00:00")
tar -jcvf $bkp_path/temp/$file --exclude-from=$exclude $fiter_uploads_path $mc_skin_path -N $(date +"%Y-%m-01 00:00:00")

mv $bkp_path/temp/$file $bkp_path/$file

echo mv $bkp_path/temp/$file.log $bkp_path/$file.log
mv $bkp_path/temp/$file.log $bkp_path/$file.log
