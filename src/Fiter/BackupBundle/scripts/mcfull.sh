#!/bin/bash

installpath=$2
. $installpath/getParams.sh


mc_path=$3

$file=${now}_fullbackup_minecraft.tar.bz2

nohup tar jcvf $bkp_path/$file --exclude-from=$installpath/exclude $mc_path > $bkp_path/$file.output.log 2> $bkp_path/$file.errors.log < /dev/null &
