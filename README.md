statusboard-server-load
=======================

PHP script that you can use to display a graph of your serverload with the StatusBoard app for iPad

### Setup

1. Edit the config file and add your MySQL information. Make sure to create the table as shown in _db.sql_
2. Replace mydomain.com in the command below to reflect the location of the script, and add it to the cron job list for each server that you want to get the load info from.


    `&#42; &#42; &#42; &#42; &#42; echo "loadavg=&#96;cat /proc/loadavg&#96;" | curl -d @- http://mydomain.com/status-board/`
    
3. Add http://mydomain.com/status-board/ to statusboard