#!/bin/bash
installpath=$2
. $installpath/getParams.sh

#script                          1         2        3                   4             5        logfile
echo "bash $installpath/bkpdiff.sh $bkp_path $exclude $fiter_uploads_path $mc_skin_path $file2 > $bkp_path/temp/$file2.log"
bash $installpath/bkpdiff.sh $bkp_path $exclude $fiter_uploads_path $mc_skin_path $file2 > /dev/null &
