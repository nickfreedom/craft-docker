docker container stop nickleguillou_web_1 nickleguillou_redis_1
docker container rm nickleguillou_web_1 nickleguillou_redis_1

docker volume rm nickleguillou_app nickleguillou_craftcms-logs

docker container ls -a
docker volume ls