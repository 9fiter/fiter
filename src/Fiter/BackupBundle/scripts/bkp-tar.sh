return_file=$1 
path=$2
file=$3

echo "Backup minecraft folder to $return_file file, please wait..."
#tar -cz --exclude cache/ --exclude server.log -f $return_file $path
tar -cz --exclude-from=$file -f $return_file $path
echo "Backup minecraft folder to $return_file complete"