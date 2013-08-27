#!/bin/bash

installpath=$2
. $installpath/getParams.sh

nohup tar jcvf $bkp_path/$file --exclude-from=$installpath/exclude $fiter_uploads_path $mc_skin_path > $bkp_path/$file.output.log 2> $bkp_path/$file.errors.log < /dev/null &
