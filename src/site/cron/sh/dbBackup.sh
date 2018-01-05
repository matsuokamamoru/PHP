#/bin/sh
DIR="/home/jenkinX072/db/"
YMD=$(date +"%Y%m%d");
PATHYMD=${DIR}${YMD}
mysqldump -u root -psDcX2vW6 projectx > "${PATHYMD}_PROJECTX.dump"