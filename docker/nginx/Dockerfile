FROM nginx:1.21.6-alpine

ADD ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf
#ADD ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY web /usr/src/app/web
