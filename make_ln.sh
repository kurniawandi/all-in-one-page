#!/bin/bash
cp -lf ./index.php /var/www/
cp -lf ./registration.php /var/www/
#cp -lf ./beidanci/functions_for_filter.php /var/www/beidanci/
cp -lf ./beidanci/index.html /var/www/beidanci/
cp -lf ./beidanci/record_difficulty.php /var/www/beidanci/
cp -lf ./beidanci/words_filter.php /var/www/beidanci/ 
#cp -lf ./include/db.php /var/www/include/
cp -lf ./include/email_exists.php /var/www/include/ 
cp -lf ./include/js/jquery-1.4.2.min.js /var/www/include/js/ 
cp -lf ./include/js/common.js /var/www/include/js/ 
cp -lrf ./beidanci/js/ /var/www/beidanci/ 
cp -lrf ./beidanci/css/ /var/www/beidanci/
cp -lrf ./beidanci/self-improvement/ /var/www/beidanci/

