FROM almalinux:9

RUN dnf -y update
RUN dnf -y install epel-release
RUN dnf -y install \
        nginx \
        php php-fpm php-mysqlnd php-json php-mbstring php-xml php-pdo php-gd \
        supervisor \
        git unzip \
        && dnf clean all

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Node.js 18
RUN dnf module -y install nodejs:18

RUN mkdir -p /run/nginx /run/php-fpm

WORKDIR /var/www/html

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
