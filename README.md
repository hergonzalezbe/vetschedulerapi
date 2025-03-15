# VetScheduler API

Es una API de gestión de citas veterinarias con Slim Framework y MySQL. Actualmente publicado en un hosting compartido y se encuentra en fase de desarrollo.

## Características
- Creación y gestión de clientes, mascotas y citas.
- Uso de Slim Framework para manejar rutas y controladores.
- Middleware para el manejo simple de una API key que permita darle algo de seguridad a los endpoints.
- Base de datos MySQL para almacenar la información.

## Requisitos
- PHP 7.4 o superior
- Composer
- MySQL
- Servidor web (Apache, Nginx, etc.)

## Instalación
1. Clonar este repositorio:
   ```
   git clone https://github.com/usuario/vetschedulerapi.git
   cd vetschedulerapi
   ```
2. Instalar las dependencias correspondientes:
   ```
   composer install
   ```
3. Configurar la base de datos en `src/Database/Database.php`:
   ```
   private $host = "localhost";
   private $db_name = "vetschedulerdb";
   private $username = "usuario";
   private $password = "contraseña";
   ```
4. Configurar el servidor web para que el directorio `public/` sea el punto de entrada.

## Uso
(Opcional) Iniciar el servidor de desarrollo con: (usar el puerto disponible adecuado). Si se tiene wampserver, xampp, etc., y se puede publicar el sitio.
```
php -S localhost:8000 -t public
```
Luego acceder a `http://localhost:8000` o a la url en la que se haya publicado.

## Endpoints Principales
### Clientes
- POST /clientes → Crea un nuevo cliente.
- GET /clientes/{id} → Obtiene un cliente por ID.
- GET /clientes/ → Obtiene todos los clientes.

### Mascotas
- POST /mascotas → Registra una mascota.
- GET /mascotas/{id} → Obtiene una mascota por ID.

### Citas
- POST /citas → Crea una cita veterinaria.
- GET /citas/{id} → Obtiene una cita por ID.

## Middleware
Se incluye un middleware `ApiKeyMiddleware.php` para proteger las rutas con una clave API.

## Licencia
MIT

