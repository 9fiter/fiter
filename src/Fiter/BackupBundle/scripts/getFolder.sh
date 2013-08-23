#!/bin/sh
getFolder(){
	bkp_path=$1
	now=$(date +"%Y-%m-%d-%T")
	bkp_path_now=$bkp_path/$now

	COUNTER=1
	until [ ! -d $bkp_path_now  ]; do
		bkp_path_now=${bkp_path}/${now}_${COUNTER}
		COUNTER=$(($COUNTER+1))
	done
	mkdir -p $bkp_path_now
	echo "$bkp_path_now"
}