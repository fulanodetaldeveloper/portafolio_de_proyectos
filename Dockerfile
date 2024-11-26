# Usar Ubuntu como imagen base
FROM ubuntu:22.04

# Evitar interacciones durante la instalación
ENV DEBIAN_FRONTEND=noninteractive
# Crear directorio para la aplicación
RUN mkdir -p /var/www/html

# Actualizar el sistema e instalar paquetes necesarios
RUN apt-get update && apt-get install -y \
    apache2 \
    mysql-server \
    php \
    php-mysql \
    php-curl \
    php-json \
    php-common \
    php-mbstring \
    php-xml \
    php-zip \
    libapache2-mod-php \
    curl \
    nano \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Configurar ServerName en Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Configurar MySQL
RUN service mysql start && \
    mysql -e "ALTER USER 'root'@'localhost' IDENTIFIED BY '1234';" && \
    mysql -e "CREATE USER 'toor'@'%' IDENTIFIED BY '1234';" && \
    mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'toor'@'%' WITH GRANT OPTION;" && \
    mysql -e "FLUSH PRIVILEGES;"
    

# Configurar MySQL para permitir conexiones remotas
RUN sed -i 's/bind-address\s*=\s*127.0.0.1/bind-address = 0.0.0.0/' /etc/mysql/mysql.conf.d/mysqld.cnf

# Crear directorio para el backup y copiarlo
RUN mkdir -p /var/lib/mysql/backup
COPY backup.sql /var/lib/mysql/backup/

# Configurar Apache y PHP
RUN ln -sf /etc/apache2/mods-available/php*.conf /etc/apache2/mods-enabled/ && \
    ln -sf /etc/apache2/mods-available/php*.load /etc/apache2/mods-enabled/ && \
    ln -sf /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/ && \
    a2enmod rewrite
    
# Configurar Apache para permitir .htaccess
COPY <<EOF /etc/apache2/sites-available/000-default.conf
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html
    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
    <Directory /var/www/html>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
EOF

# Copiar script de inicio
COPY <<EOF /start.sh
#!/bin/bash
mysqld_safe --datadir=/var/lib/mysql &
service mysql start
# Esperar a que MySQL esté completamente iniciado
while ! mysqladmin ping -h localhost --silent; do
    sleep 1
done
echo "===== RESTAURANDO BD "
mysql -u toor -p1234 < /var/lib/mysql/backup/backup.sql
echo "===== INICIANDO APACHE "
service apache2 start
tail -f /dev/null
EOF

RUN chmod +x /start.sh

# Configurar permisos para el directorio web
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Exponer puertos
EXPOSE 80
EXPOSE 3306

# Volúmenes
VOLUME ["/var/www/html"]

# Comando para iniciar los servicios
CMD ["/start.sh"]
