#!/bin/bash

installpath=$2
. $installpath/getParams.sh


mc_path=$3
mc_file=${now}_fullbackup_minecraft.tar.bz2

nohup tar jcvf $bkp_path/$mc_file --exclude-from=$installpath/exclude $mc_path > $bkp_path/$mc_file.output.log 2> $bkp_path/$mc_file.errors.log < /dev/null &
