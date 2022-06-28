# App test
Sistema de recepción de Webhooks mediante peticiones HTTP.

## Start up

Para comenzar, asegúrese de tener [Docker installed](https://docs.docker.com/docker-for-mac/install/) en su sistema y luego clone este repositorio.

A continuación, navegue en su terminal hasta el directorio que clonó y active los contenedores para el servidor web ejecutando `docker-compose up -d`.

Se habrán creado 2 contenedores:
- **mysql**: mysql 8.0
- **apache-php**: Apache/2.4.53 (Debian) + PHP 7.4.30

Para la instalación de las dependencias del proyecto ejecutamos el siguiente comando en el directorio del proyecto `docker-compose exec web composer install`.

En el fichero .env se pueden ver las variables de entorno que se usarán en la aplicacion, como la conexion a la base de datos.
```
CONNECTION_DRIVER=mysql
CONNECTION_HOST=mysql
CONNECTION_USER=app
CONNECTION_PASSWORD=password
CONNECTION_NAME=app
CONNECTION_DEBUG=false
REDIS_CONNECTION=tcp://redis:6379
DATE_TIME_FORMAR="Y-m-d H:i:s"
```

En el build de los contenedores se ejecuta un [dump](https://github.com/palatinum/app-testing/blob/master/build/mysql/dump.sql) con las tablas necesarias para el proyecto.
![schema database](https://github.com/palatinum/app-testing/blob/master/database_schema.PNG)


Hay una [colección de Postman](https://github.com/palatinum/app-testing/blob/master/App%20Testing.postman_collection.json) que se puede importar para obtener los endpoint de la aplicación.
![schema database](https://github.com/palatinum/app-testing/blob/master/postman.PNG)

## Rutas
Esxisten 4 rutas: (app\routes\api.php)
- **webhook**: Ruta generica que controla todos los timpos de webhooks.
- **webhook/subscribe**: Ruta especifica para el webhook de nueva suscripccion.
- **webhook/unsubscribe**: Ruta especifica para el webhook de baja de suscripción.
- **webhook/payment**: Ruta especifica para el webhook de cobro.

## Controladores (app\Controllers)
Existen 4 controladores, uno por cada ruta.

## Modelos
Existen 2 modelos: (app\Models)
- **Billing**: representa la tabla billing para el evento de cobro.
- **Subscriber**: representa la tabla subscribers para el alta y baja de suscriptores.

## Request
La request de los webhooks se divide en 2:
- **type**: tipo de evento, pueden ser 3 (subscribe, unsubscribe, payment).
- **data**: los datos especificos para cada webhook.
