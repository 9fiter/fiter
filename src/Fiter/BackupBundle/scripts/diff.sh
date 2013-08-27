#!/bin/bash

installpath=$2
. $installpath/getParams.sh

fecha=$(date +"%Y-%m-01 00:00:00")

nohup tar jcvf $bkp_path/$file2 --exclude-from=$installpath/exclude $fiter_uploads_path $mc_skin_path -N $fecha > $bkp_path/$file2.output.log 2> $bkp_path/$file2.errors.log < /dev/null &