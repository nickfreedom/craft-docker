FROM wyveo/nginx-php-fpm:latest

RUN rm -rf /usr/share/nginx/* && \
sed -i -e "s/memory_limit\s*=\s*.*/memory_limit = 256M/g" ${php_conf} && \
sed -i -e "s/session.save_handler\s*=\s*.*/session.save_handler = redis/g" ${php_conf} && \
sed -i -e "s/;session.save_path\s*=\s*.*/session.save_path = \"\${REDIS_PORT_6379_TCP}\"/g" ${php_conf} && \
apt-get update && \
apt-get install -y mysql-client

# Setup Craft
ADD ./app /usr/share/nginx
WORKDIR /usr/share/nginx
RUN composer update

# Add default craft cms nginx config
ADD ./default.conf /etc/nginx/conf.d/default.conf

RUN chown -Rf nginx:nginx /usr/share/nginx/

EXPOSE 80
