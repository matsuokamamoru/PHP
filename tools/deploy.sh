#!/bin/bash

# バックアップを行う。
DIR_SITE='/var/www/matomes.net/site' 
if [ -e ${DIR_SITE} ]; then
  DIR_DATE=`/bin/date '+%Y%m%d-%H%M%S'`
  mkdir -p /home/jenkinX072/snapshots/$DIR_DATE
  sudo mv /var/www/matomes.net/arc /home/jenkinX072/snapshots/$DIR_DATE
  sudo mv /var/www/matomes.net/site /home/jenkinX072/snapshots/$DIR_DATE  
fi

# 最新ソースを配置する。
sudo /bin/cp -rfp /home/jenkinX072/workspace/src/* /var/www/matomes.net/
sudo chown -R apache.apache /var/www/matomes.net/*
sudo chmod -R 700 /var/www/matomes.net/site/cron/

# cron処理を実行する。
sudo /usr/bin/php /var/www/matomes.net/site/cron/newVideosCron.php
sudo /usr/bin/php /var/www/matomes.net/site/cron/viewsCron.php
#sudo /usr/bin/php /var/www/matomes.net/site/cron/viewsRssCron.php Hatebu http://feeds.feedburner.com/hatena/b/hotentry
sudo /usr/bin/php /var/www/matomes.net/site/cron/viewsRssCron.php Eropon http://d-eropon.ldblog.jp/index.rdf