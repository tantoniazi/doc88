FROM tiagoguerra/magento:1
ADD php.ini /usr/local/etc/php/php.ini
ADD doc88.conf /etc/apache2/sites-available/doc88.conf
RUN ln -s /etc/apache2/sites-available/doc88.conf /etc/apache2/sites-enabled/doc88.conf

RUN chmod 777 -Rf /var/www /var/www/.* \
	&& chown -Rf www-data:www-data /var/www /var/www/.* \
	&& usermod -u 1000 www-data \
	&& chsh -s /bin/bash www-data\
	&& a2enmod rewrite \
	&& a2enmod headers

VOLUME /var/www/html
WORKDIR /var/www/html
RUN "composer install"
CMD "php artisan migrate"
CMD "php artisan db:seed"
