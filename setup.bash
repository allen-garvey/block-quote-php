#initialize environment file
if [ ! -f ./inc/environment.json ]; then 
	cp -n ./inc/environment_example.json ./inc/environment.json; 
fi

#initialize database file
if [ ! -f ./inc/db.php ]; then 
	cp -n ./inc/db_example.php ./inc/db.php;
fi