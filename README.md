<img src="./public/quiosco-6017.svg" alt="Quiosco 6017 Logo" width="400" height="150" style="display: block; margin: 0 auto;">

**Quisco 6017** es un proyecto de software en el marco de las Prácticas Profesionalizantes III de la carrera Tecnicatura Superior en Análisis de Sistemas y Dessarrollo de Software en el Instituto de Enseñanza Superior Nº 6017 "_Prof. Amadeo R. Sirolli_".

El proyecto utiliza el [framework Laravel](https://laravel.com/), un conjunto de herramientas y recursos que permiten desarrollar aplicaciones web de manera rápida y sencilla en el [lenguaje de programación PHP](https://www.php.net/).

## Descripción

Se trata de una aplicación web diseñada para la gestión de los procesos típicos de un quiosco, como la administración de productos, ventas, clientes y reportes. Está pensada para ser utilizada por los propietarios o empleados de un quiosco para facilitar la gestión diaria del negocio y mejorar la eficiencia en las operaciones.

## Características

- **Gestión de productos:** Permite agregar, editar y eliminar productos del quiosco.
- **Gestión de ventas:** Permite registrar ventas, generar facturas y llevar un historial de transacciones.
- **Gestión de clientes:** Permite administrar la información de los clientes y sus compras.
- **Reportes:** Genera reportes de ventas, productos más vendidos, entre otros.

## Requisitos

- PHP 8 o superior
- Composer
- MySQL/MariaDB o cualquier otro sistema de gestión de bases de datos compatible con Laravel
- Servidor web (como Apache o Nginx)

## Instalación & Configuración

1. Clona el repositorio del proyecto:

    ```bash
        git clone https://github.com/sirolli-org/quiosco-6017.git
    ```

2. Navega al directorio del proyecto:

    ```bash
        cd quiosco-6017
    ```

3. Instala las dependencias del proyecto utilizando [Composer](https://getcomposer.org/):

    ```bash
        composer install
    ```

4. Instala las dependencias de JavaScript utilizando [npm](https://www.npmjs.com/):

    ```bash
        npm install
    ```

5. Configura el archivo `.env` con la información de tu base de datos y otras configuraciones necesarias:

    ```bash
        cp .env.example .env
    ```

6. Corre las migraciones para crear las tablas en la base de datos:

    ```bash
        php artisan migrate
    ```

7. Genera la clave de la aplicación:

    ```bash
        php artisan key:generate
    ```

## Desarrollo

Para ejecutar la aplicación en un entorno de desarrollo, puede utilizar el servidor de desarrollo integrado de Laravel:

```bash
    npm run build && php artisan serve
```

Alternativamente, se puede correr un servidor de desarrollo con Vite que incluye hot reloading para una mejor experiencia:

```bash
    composer run dev
```

## Producción

Prepara la aplicación ejecutando el siguiente comando para compilar los assets:

```bash
    npm run build
```

Por último, se tiene que configurar un servidor web (como Apache o Nginx) para servir la aplicación, asegurándose de apuntar al directorio `public`.

## Equipo

ToDo.
