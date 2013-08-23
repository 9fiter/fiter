return_file=$1 
path=$2

echo "Backup mcskin/img folder to $return_file file, please wait..."
zip -r $return_file $path
echo "Backup mcskin/img folder to $return_file complete"