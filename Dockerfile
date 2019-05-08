ARG BASE_IMAGE=collaborating.tuhh.de:5005/itbh/portfolio-team/portfolio-docker-base

FROM ${BASE_IMAGE}

#FROM collaborating.tuhh.de:5005/itbh/portfolio-team/docker

# Copy project to /var/www/html
WORKDIR /var/www/html
COPY . /var/www/html

RUN yarn install \
	&& yarn run dev \
	&& composer install

RUN chown -R www-data:www-data /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/resources
RUN chown -R www-data:www-data /var/www/html/public
RUN chmod +x /var/www/html/entrypoint.sh
RUN chmod +x /var/www/html/wait-for-it.sh

EXPOSE 80

ENTRYPOINT /var/www/html/entrypoint.sh
