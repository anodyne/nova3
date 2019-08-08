FROM nginx:1.17

ADD ./docker/vhost.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www