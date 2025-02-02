FROM php:8.2-cli
COPY api/ /usr/src/myapp
WORKDIR /usr/src/myapp