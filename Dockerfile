FROM wyveo/nginx-php-fpm:latest

RUN rm -rf /usr/share/nginx/* && \
sed -i -e "s/memory_limit\s*=\s*.*/memory_limit = 256M/g" ${php_conf} && \
apt-get update && \
apt-get install -y mysql-client

# Setup Craft
ADD ./craft-iot-poc /usr/share/craft-iot-poc
ADD ./app /usr/share/nginx
WORKDIR /usr/share/nginx
RUN composer install

# Add default craft cms nginx config
ADD ./default.conf /etc/nginx/conf.d/default.conf

RUN chown -Rf nginx:nginx /usr/share/nginx/

EXPOSE 80
