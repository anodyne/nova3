FROM nginx:1.17

ADD ./docker/nginx/vhost.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www