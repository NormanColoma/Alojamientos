#Documentación activa#

El propósito de esta documentación, es mantenerla activa durante el proceso de desarrollo. Explicaremos aquellos conceptos
que creamos necesarios e importantes para el entendimiento del mismo.

##Base de datos

En este apartado trataremos todo lo relativo a la base de datos, y la forma en que laravel nos permite gestionar la misma.

######Migrations

Las migraciones se encuentra bajo el directorio \local\database\migrations. En estos archivos se especifican las tablas
tal y cual irán en la bd. Posteriormente, ejecutando desde terminal y bajo \local  php artisan migrate, se crearán todas
las tablas que se encuentren en las migraciones. Podemos encontrar más información en <p>migrations <a href="http://laravel.com/docs/5.1/migrations"></a></p>


##Middlewares

A menudo necesitamos comprobar (para actuar en consecuencia) los roles del usario. Por ejemplo, en este caso tenemos varios roles,
y según estos, los usuarios podrán acceder a diferentes secciones. Este es el motivo principal del uso de los <p>middlewares <a href="http://laravel.com/docs/5.1/middleware"></a></p>. Para no
tener que realizar estás comprobaciones siempre, los usamos. Los podemos encontrar en \local\app\Http\Middleware.


##Testing

El proceso de testeo de una aplicación es tan (o más) importante como el desarrollo e implementación de la misma. Por ello hemos decidido emplear
BDD para nuestro flujo de desarrollo. Cabe recordar que las pruebas exhaustivas no existen, y lo que se busca son pruebas de calidad.

######Transactions

Cuando estamos realizando pruebas, es necesario insertar, modificar, borrar, datos de la base de datos. Para no tener que interferir con la misma,
y poder dejar los mismos datos que habían antes de realizar un test (cada método del mismo) hacemos uso de las <p>transactions<a href="http://laravel.com/docs/5.1/testing"></a></p>.


