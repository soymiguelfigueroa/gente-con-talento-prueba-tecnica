# Prueba Técnica Práctica: Desarrollador Backend / Full Stack (Laravel & PHP)

El objetivo de esta prueba es desarrollar una pequeña aplicación funcional para gestionar una biblioteca de libros. La solución permite realizar las operaciones esenciales de gestión (CRUD) y filtrado de contenido mediante el framework Laravel.

## Stack Tecnológico

* **Framework:** Laravel 13

* **Base de Datos:** MySQL

* **Arquitectura:** Patrón MVC extendido con Service Classes. Se utilizan Migraciones y Seeders, Form Requests para validación, ORM Eloquent y tratamiento de respuestas/errores HTTP.   

* **Entorno:** Linux: Debian 13 / PHP 8.5.12 - Composer - Laravel installer 5.32.0 - Node 24.18.1 - NPM 11.16.0

## Decisiones de Arquitectura y Diseño

Para cumplir con los requerimientos de un ecosistema tecnológico seguro y de alta transaccionalidad, se implementaron los siguientes patrones:

### 1. Migraciones

Se diseñó una migración que crea dos tables:

- categories: con el campo name
- books: con los campos title, author, description, published_year y category_id. Además se creó una referencia (FK) a la tabla categories.

Cada tabla cuenta con su campo PK id y los timestamps que laravel agregar por defecto.

### 2. Modelos

Se diseñaron dos modelos:

- Book: tiene configurado como fillable los campos title, author, description, published_year y category_id. Son lo únicos que se pueden manipular mediante eloquent. Además tiene configurada una relación del tipo BelongsTo con el modelo Category. De esta forma, se puede obtener la categoría asociada al libro registrado.
- Category: tiene configurado como fillable el campo name. Además tiene configurada una relación del tipo HasMany con el modelo Book. De esta forma, se pueden obtener los libros asociados a la categoría registrada.

Ambos modelos utilizan el trait HasFactory para ser usados durante la creación de la data inicial (seed).

### 3. Fatories y Seeders

Factory permite definir el tipo de dato que se utilizará para generar los registros semilla y los Seeder se encargan de generar varios registros semilla en secuencia. Con esto ya se puede realizar el desarrollo con datos.

### 4. Services

Son clases especializadas que contienen el modelo de negocio, haciendo que los controller sean más limpios y solo se dediquen a enrutar.

### 5. Controller y Form Request

El controller capta los datos que son previamente validados por las clases Request, luego le envía los datos al Service y espera una respuesta. Al recibir la respuesta, se encarga de renderizar o redireccionar a la vista correspondiente con un mensaje flash indicando el resultado de la operación.

### 6. Routes

Se crearon rutas tanto para book como para categories, con los métodos correspondientes a cada tipo de operación:

- GET: para obtener y listar los libros o las categorías.
- POST: para crear nuevos registros.
- PUT: para actualizar toda la información del registro seleccionado.
- DELETE: para eliminar un registro, previa confirmación.


### 7. Vistas

Se renderiza el contenido en tablas y se permite crear o editar datos mediante formularios. Además los elementos repetitivos se colocaron en un layout:

- Estrutura HTML repetitiva
- Menú principal
- Mensajes Flash


## Instalación y Despliegue Local

El proyecto está preparado para levantarse fácilmente utilizando el instalador de Laravel, compatible con macOS, Windows PowerShell y Linux.

### Requisitos Previos

* Entorno de ejecución de Laravel. Para más información sobre cómo obtener el instalador, visita [este enlace](https://laravel.com/framework/docs/installation#installing-php).

* [Git](https://git-scm.com/).

* MySQL / [MariaDB](https://mariadb.org/).

### Pasos de Instalación

1. **Clonar el repositorio:**

   ```
   git clone https://github.com/soymiguelfigueroa/gente-con-talento-prueba-tecnica
   cd gente-con-talento-prueba-tecnica
   
   ```

2. **Crear una base de datos para el proyecto en MySQL:**

   Ejemplo: gente-con-talento-prueba-tecnica

3. **Configurar el entorno:**

   ```
   cp .env.example .env
   
   ```

   modificar la sección de base de datos para que se pueda conecta a MySQL:

   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=gente-con-talento-prueba-tecnica
   DB_USERNAME=admin
   DB_PASSWORD=TuContraseñaSegura
   
   ```

4. **Costruir los módulos de node**

   ```
   npm install && npm run build
   
   ```

5. **Ejecutar las migraciones:**

   ```
   php artisan migrate
   
   ```

6. **Poblar la base de datos:**

   Para los libros
   
   ```
   php artisan db:seed --class=BookSeeder
   
   ```

   Para las categorías
   
   ```
   php artisan db:seed --class=CategorySeeder
   
   ```

7. **Levantar el servidor:**

   ```
   composer run dev
   
   ```

   Por defecto el servidor se levanta en [http://127.0.0.1:8000](http://127.0.0.1:8000)

## Navegación

Al ingresar, aparece el listado de libros. Hay dos botones que representan el menú superior:

- Libros: dirige al listado de libros.
- Categorías: dirige al listado de categorías.

Cada listado tiene un botón "registrar" para crear nuevos registros.

Cada fila permite dos acciones: editar y eliminar.

En el listao de libros es posible selecionar una categoría específica y luego usar el botón filtrar.

Los formularios tienen un botón "Registrar" o "Guardar". Además se puede cancelar para volver a los listados.
