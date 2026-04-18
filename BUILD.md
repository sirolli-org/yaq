# Build

## Prerequisitos

- [PHP](https://www.php.net/) 8.0 o superior
- [Composer](https://getcomposer.org/) 2.0 o superior
- [Node.js](https://nodejs.org/) v24 o superior (LTS)
- [NPM](https://www.npmjs.com/) v11 o superior
- Servidor web ([Apache](https://httpd.apache.org/), [Nginx](https://nginx.org/) o similares)
- Base de datos [MySQL](https://www.mysql.com/)/[MariaDB](https://mariadb.org/)

## Entorno de Desarrollo

Para un entorno de desarrollo recomendado, consulte [IDE.md](./IDE.md) para obtener detalles sobre la configuración de Visual Studio Code con las extensiones y ajustes recomendados para trabajar con Laravel y PHP.

## Configuración: Paso a Paso

Clona el repositorio del proyecto:

```bash
git clone https://github.com/sirolli-org/yaq.git
```

Navega al directorio del proyecto:

```bash
cd yaq
```

Instale las dependencias de JavaScript utilizando _npm_:

```bash
npm install
```

Instale las dependencias del proyecto utilizando _composer_:

```bash
composer install
```

Configura el archivo `.env` con la información de su base de datos y otros parametros necesarios. Puede copiar el archivo de ejemplo y luego editarlo:

```bash
cp .env.example .env
```

Corra las migraciones para crear las tablas en la base de datos (necesitará una instancia de base de datos configurada y accesible):

```bash
php artisan migrate
```

Genere la clave de la aplicación para asegurar las sesiones y otros datos cifrados:

```bash
php artisan key:generate --force
```

## Despliegue

### Desarrollo: Local

Inicie el servidor de desarrollo de Laravel ejecutando el siguiente comando:

```bash
composer run dev
```

Luego acceda a `http://localhost:8000` en su navegador para ver la aplicación en acción.

### Desarrollo: Local + Contenedores para la base de datos

Instale [Podman](https://podman.io/) y luego ejecute el siguiente comando para iniciar únicamente la base de datos con Podman Compose:

```bash
podman-compose -f compose.yml up -d mysql migrate
```

Luego, inicie el servidor de desarrollo de Laravel ejecutando el siguiente comando:

```bash
composer run dev
```

Luego acceda a `http://localhost:8000` en su navegador para ver la aplicación en acción.


### Producción: Manual

Prepare para el despliegue en producción ejecutando el siguiente comando:

```bash
npm run build
```

Por último, se tiene que configurar un servidor web para servir los archivos, asegurándose de apuntar al directorio `public/`.

### Producción: Contenedores

Instale [Podman](https://podman.io/) y luego ejecute el siguiente comando para construir la imagen del contenedor:

```bash
podman-compose -f compose.yml build --no-cache
```

Luego, ejecute el contenedor con el siguiente comando:

```bash
podman-compose -f compose.yml up -d
```

Luego acceda a `http://localhost:8000` en su navegador para ver la aplicación en acción.
