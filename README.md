# Prerrequisitos


### Frontend (Vue.js)
Para ejecutar la interfaz de usuario, es necesario contar con un entorno de ejecución de JavaScript moderno:

* **Node.js:** Última versión estable (LTS recomendada).
* **Gestor de paquetes:** [npm](https://www.npmjs.com/) (incluido con Node.js).

### Backend (Laravel)
Para simplificar la configuración y evitar conflictos de versiones, el proyecto utiliza **Laravel Sail**. Esto permite un entorno de desarrollo estandarizado y robusto.

* **Docker Desktop:** Es el **único** requisito indispensable para el backend.
* **¿Por qué Docker/Sail?**: Gracias a esta tecnología, no necesitas instalar localmente PHP, Composer, servidores web o bases de datos. Todo el entorno (runtime de PHP, base de datos, cliente HTTP, etc.) se levanta automáticamente dentro de contenedores aislados, garantizando que el proyecto funcione exactamente igual en cualquier máquina.

---

# Pasos para ejecución del proyecto

El proyecto consta de dos partes principales:

1. **Frontend:** Se encuentra en la carpeta `frontend` y está desarrollado en Vue.js.
2. **Backend:** Se encuentra en la carpeta `restapi` y está desarrollado en Laravel.

### Pasos para ejecución del frontend

1. Navegar hasta la carpeta `frontend`
   
```bash
cd frontend
```

2. Instalar las dependencias

```bash
npm install
```

3. En la raíz del proyecto crear un archivo `.env` con el siguiente contenido:
```bash
## Url base del backend
VITE_API_BASE_URL=http://localhost:80/api
```

> [!WARNING]
> En un entorno de desarrollo real las variables de entorno son confidenciales y no se deben de compartir, pero por la naturaleza de la prueba se comparten para facilitar la ejecución del proyecto para su debida evaluación.

4. Ejecutar el proyecto

```bash
npm run dev
```

5. Acceder al proyecto en el navegador, utilizando la url proporcionada por `vite`:

```bash
  VITE v7.3.1  ready in 1028 ms

  ➜  Local:   http://localhost:5173/ # <- URL a utilizar
  ➜  Network: use --host to expose
  ➜  press h + enter to show help
```

### Pasos para ejecución del backend

1. Navegar hasta la carpeta `restapi`

```bash
cd restapi
```

2. Instalar las dependencias de PHP 

-  **Linux / macOS / Windows (WSL2):**
```bash
docker run --rm \
  -u "$(id -u):$(id -g)" \
  -v "$(pwd):/var/www/html" \
  -w /var/www/html \
  laravelsail/php84-composer:latest \
  composer install --ignore-platform-reqs
```

- **Windows (Powershell):**
```powershell
docker run --rm `
    -v "${PWD}:/var/www/html" `
    -w /var/www/html `
    laravelsail/php84-composer:latest `
    composer install --ignore-platform-reqs
```

3. En la raíz del proyecto crear un archivo `.env` con el siguiente contenido:
```bash
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:A05wrRQniO4BZ/rc1JVghW+x1pviFe0ThLXISVGJkBY=
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
# CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
VITE_PORT=5174


FORWARD_PGADMIN_PORT=8080
PGADMIN_DEFAULT_EMAIL=admin@admin.com
PGADMIN_DEFAULT_PASSWORD=password

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=ucasv.notas@gmail.com
MAIL_PASSWORD=bdqlbrcwrvkolehi
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="ucasv.notas@gmail.com"
MAIL_FROM_NAME="Sistema de Notas UCA"
```

> [!WARNING]
> En un entorno de desarrollo real las variables de entorno son confidenciales y no se deben de compartir, pero por la naturaleza de la prueba se comparten para facilitar la ejecución del proyecto para su debida evaluación.

4. Levantar los servicios de docker utilizando sail
```bash
./vendor/bin/sail up -d
```

5. Ejecutar las migraciones y los seeders de datos
```bash
./vendor/bin/sail artisan migrate:fresh --seed
```


---


# Actualización en estrategia de desarrollo

Durante la fase de implementación de la estrategia de desarrollo, se identificó la necesidad de refinar el modelo de datos original para garantizar la integridad, escalabilidad y funcionalidad de los reportes. A continuación, se detallan y justifican las modificaciones realizadas:


- **Entidad: Estudiante (`students`)**
  - **Cambio:** Inclusión del atributo `career` (carrera).
  - **Justificación:** Se añadió para dotar de contexto académico al perfil del estudiante. Este dato es crítico para la generación de constancias y reportes oficiales, permitiendo además filtrar y segmentar la población estudiantil según su programa de estudio.

- **Entidad: Ciclo (`semesters`)**
  - **Cambio:** Reemplazo del atributo genérico `name` por dos atributos: `year` (año) y `semester_number` (número de ciclo).
  - **Justificación:** Esta normalización facilita el ordenamiento cronológico descendente (ej. obtener el ciclo más reciente) y mejora la precisión en las consultas. Al separar el año del periodo, se evita la dependencia de formatos de texto rígidos, permitiendo una visualización flexible en el frontend (ej. "Ciclo 01/2025").

- **Entidad: Registro (`registers`)**
  - **Cambio:** Incorporación del atributo `grade` (nota).
  - **Justificación:** Se identificó que la entidad actuaba únicamente como una tabla de inscripción. Al agregar `grade`, la entidad evoluciona a un historial académico completo, almacenando el resultado cuantitativo del rendimiento del estudiante en la relación Estudiante-Materia-Ciclo.

---

# Ejercicio

La Unidad de Registro Académico requiere una aplicación web que le permita generar un **reporte de constancia de notas** de cualquier alumno de la universidad.

La constancia de notas puede ser enviada al estudiante a través de correo electrónico y puede ser impresa desde la herramienta.

---

# Requerimientos

Se requiere que se use la combinación adecuada de cualquiera de las siguientes tecnologías:

- Laravel  
- Vue (Preferible) o React  
- Bootstrap o Tailwind (Preferible)  
- PostgreSQL (Preferible) o MariaDB  
- Docker  

---

# Arquitectura

Se debe crear una aplicación **Client-Side Rendered (CSR)** con un **API RESTful**, ambas preparadas para ejecutarse en entornos contenerizados.

---

# Criterios de evaluación 

- Estrategia de solución utilizada  
- Calidad de código  
- Arquitectura  
- Implementación  
- Base de datos  
- Reportes  
- Interfaz y experiencia de usuario  
- Interpretación de requerimientos  
- Documentación  

---

# Preguntas

- **¿Qué es una petición HTTP?**
  
  Básicamente, es la forma en que el cliente (como tu navegador) se comunica con el servidor. Es como cuando vas a un restaurante y haces un pedido: el cliente envía un mensaje diciendo 'necesito esto' (ya sea una página web, una imagen o enviar datos de un formulario) y espera a que el servidor le responda.

- **¿Qué es API RestFul?**
  
  Es una forma de diseñar APIs con la idea de usar el protocolo HTTP tal cual fue diseñado: usas verbos como GET para pedir datos, POST para crear, PUT para editar, etc. Al final, 'RESTful' significa que tu API respeta esas reglas de arquitectura para que sea fácil de consumir por otros sistemas.

- **¿Mencione una herramienta que permita Documento en servicio Rest?**

  Una de las más usadas hoy en día es Swagger, es bastante útil porque te genera una interfaz visual para probar los endpoints. También uso mucho Postman, que aunque es para testing, sirve muy bien para dejar documentados ejemplos de cómo usar la API.

- **¿Qué es un Modelo?**

  El Modelo es la representación de los datos y la lógica de negocio. Es la parte del código que habla directamente con la base de datos. Por ejemplo, si tienes un usuario, el "Modelo" define que ese usuario tiene nombre, email y contraseña, y se encarga de guardar esos datos.

- **¿Qué es un Controller?**

  Es el intermediario o el cerebro de la operación. El Controlador recibe la petición del usuario, decide qué hacer, le pide la información al Modelo y luego se la pasa a la Vista para que el usuario la vea. Coordina el tráfico entre la interfaz y los datos.

- **¿Qué es un componente?**
  
  Es un bloque de código (con su propia vista y lógica) que es independiente y reutilizable. Por ejemplo, un "botón de compra" o una "barra de navegación" pueden ser componentes que escribes una sola vez y usas en muchas partes de la aplicación.

- **¿Qué es una migración?**

  Una migración nos ayuda a que en lugar de crear tablas manualmente con SQL, se escriban archivos de código que describen los cambios (como "crear tabla usuarios") y nos permite llevar la estructura de la base de datos de un entorno a otro sin perder nada.

- **¿Qué es Docker?**

  Docker es la solución al famoso problema de "en mi máquina sí funciona". Permite empaquetar una aplicación con todo lo que necesita (librerías, configuraciones, entorno) en un contenedor, así se garantiza que corra exactamente igual en una computadora independientemente de quién sea y en el servidor de producción.

- **¿Mencione algunos patrones de diseño?**

  - Singleton: Se usa para asegurar que una clase tenga una única instancia en toda la aplicación (como una conexión a la base de datos).

  - Factory: Sirve para crear objetos de diferentes tipos sin tener que especificar la clase exacta de cada uno, centralizando la lógica de creación.

  - Observer: Es ideal para cuando necesitas que varios objetos se enteren y reaccionen automáticamente cuando ocurre un cambio en otro.

  - Repository: Su propósito es separar la lógica de acceso a datos de la lógica de negocio, haciendo que el código sea más limpio y fácil de probar.

- **Explique que hace el siguiente código y como podría mejorarlo**

```
txtUserId = getRequestString("UserId");
txtSQL = "SELECT * FROM Users WHERE UserId = " + txtUserId;
```

  Ese código está tomando un ID que viene del usuario y lo está pegando directamente en una consulta de base de datos para buscar un usuario.

  El problema grave ahí es que es vulnerable a Inyección SQL. Si un atacante escribe código malicioso en vez de un ID, podría borrar tablas o robar datos.

  Para mejorarlo, hay que usar Consultas Parametrizadas, así la base de datos trata el input estrictamente como un dato y no como código ejecutable. 

# Notas

El propósito de la prueba no es completar la totalidad de las funcionalidades, sino demostrar la capacidad de seleccionar de manera adecuada una estrategia de desarrollo y una estructura de código que permitan avanzar hacia una solución con estándares de calidad propios del ámbito empresarial.
