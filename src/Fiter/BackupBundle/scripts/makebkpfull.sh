#!/bin/bash
installpath=$2
. $installpath/getParams.sh

#script                          1         2        3                   4             5       logfile
echo "bash $installpath/bkpfull.sh $bkp_path $exclude $fiter_uploads_path $mc_skin_path $file > $bkp_path/temp/$file.log"
bash $installpath/bkpfull.sh $bkp_path $exclude $fiter_uploads_path $mc_skin_path $file > $bkp_path/temp/$file.log
