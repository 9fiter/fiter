#!/bin/bash
bkp_path=$1
installpath=$2
mc_path=$3

now=$(date +'%Y%m%d%H%M%S')
exclude=$installpath/exclude
file=${now}_fullbackup_minecraft.tar.bz2

#    script                  1         2        3        4       logfile
echo "bash $installpath/bkpfullmc.sh $bkp_path $exclude $mc_path $file > $bkp_path/temp/$file.log"
bash $installpath/bkpfullmc.sh $bkp_path $exclude $mc_path $file > $bkp_path/temp/$file.log 
