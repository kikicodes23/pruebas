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
