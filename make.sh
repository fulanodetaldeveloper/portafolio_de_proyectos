# Reconstruir la imagen
docker build -t lamp-stack .

# Detener y eliminar el contenedor anterior si existe
docker stop mi-lamp
docker rm mi-lamp

docker volume rm mysql-mi-lamp
# Crear el nuevo contenedor
docker run -d \
  -p 81:80 \
  -p 33061:3306 \
  -v $(pwd)/sitio/www:/var/www/html \
  --mount src=mysql-mi-lamp,dst=/var/lib/mysql \
  --name mi-lamp lamp-stack
  
cp -f $(pwd)/info.php $(pwd)/sitio/www
cp -f $(pwd)/.htaccess $(pwd)/sitio/www
cp -f $(pwd)/test_bd.php $(pwd)/sitio/www
