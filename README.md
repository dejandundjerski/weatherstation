# Simple UI for data retrieved from weather station(s):
- Uses project [rtl_433](https://github.com/merbanan/rtl_433) to sniff the data from weather station
- Mysql/MariaDB to preserve the data
- Plotly.js to present the data

## Use:
- www/index.php displays the data
- www/index.php?output=json return the data in json format for past 7 days
- www/push.php script to receive the data
- jobs/read.php to parse the data retrieved from rtl_433 and send it to the server
- jobs/retention.php removes the data from the DB older than 8 days
- jobs/watchdog.php checks if the data is retrieved (usb dongle can get stuck) and reboots the server
- db/schema.sql simple schema to preserve the data

## Contribution:
- Feel free to contribute or ping me in case you would like to see some improvements.
