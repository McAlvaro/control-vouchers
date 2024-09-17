# Control Vales
(Base Laravel 11 y Vue3)

## Desarrollo Local

### Requerimientos
- `php 8.2`
- `MySql`
- `composer`
- `NodeJs`
- `Npm`

### instalación
1. Copiar el archivo de variables de entorno `.env`

```shell
cp .env.example .env
```

2. Instalar dependencias

```shell
composer install
npm install
```
3. Generar `key`

```shell
php artisan key:generate
```

4. Configurar base de datos en `.env`

```shell
DB_HOST=127.0.0.1
DB_PORT=3325
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

4. Ejecutar las migraciones de la base de datos
```shell
php artisan migrate
```

5. Ejecutar el siguiente comando para crear enlace simbolico de storage
```shell
php artisan storage:link
```

6. Levantar servidor de desarrollo

```shell
php artisan serve
```
