#!/bin/sh
bkp_path=$1
exclude=$2
mc_path=$3
file=$4

echo tar -jcvf $bkp_path/temp/$file --exclude-from=$exclude $fiter_uploads_path $mc_path $mc_skin_path
tar -jcvf $bkp_path/temp/$file --exclude-from=$exclude $fiter_uploads_path $mc_path $mc_skin_path

mv $bkp_path/temp/$file $bkp_path/$file
mv $bkp_path/temp/$file.log $bkp_path/$file.log