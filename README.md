# API REST - De León Ferrer 

Una API REST moderna y robusta para gestionar productos, construida con **PHP puro** y **MySQL**. Soporta múltiples formatos de entrada (JSON, form-data, query strings) y sigue el patrón **MVC** para una arquitectura limpia y mantenible.

##  Características

 **CRUD Completo** - Crear, leer, actualizar y listar productos  
 **Flexible con Entrada de Datos** - Acepta JSON body, form-data y query strings  
 **Validación de Campos** - Asegura que los datos requeridos estén presentes  
 **Códigos HTTP Semánticos** - Respuestas apropiadas (200, 201, 400, 404, 503)  
 **CORS Habilitado** - Funciona con aplicaciones frontend desde cualquier origen  
 **MVC Architecture** - Código organizado y mantenible  
 **PDO Prepared Statements** - Protegido contra SQL injection  
 **Sanitización de Datos** - Protección contra XSS y ataques de inyección  

##  Stack Tecnológico

| Tecnología | Versión | Propósito |
|-----------|---------|----------|
| **PHP** | 7.4+ | Backend del servidor |
| **MySQL** | 5.7+ | Base de datos |
| **Apache** | 2.4+ | Servidor web |
| **PDO** | Nativo | Abstracción de base de datos |

##  Estructura del Proyecto

\\\
APIREST-DELEONFERRER/
 index.php                    # Router principal y punto de entrada
 config/
    database.php            # Configuración de conexión a BD
 model/
    Producto.php            # Modelo de datos (CRUD)
 controller/
    ProductosController.php  # Lógica de negocio
 README.md                    # Este archivo
\\\

##  Instalación

### Requisitos Previos
- XAMPP o servidor Apache + PHP + MySQL
- \mod_rewrite\ habilitado en Apache
- Acceso a la carpeta \htdocs\

### Pasos de Instalación

1. **Clonar el repositorio**
\\\ash
cd c:\xampp\htdocs
git clone https://github.com/luzdl/APIREST-DELEONFERRER.git
\\\

2. **Verificar la base de datos**
\\\sql
-- Verificar que existe la BD
SHOW DATABASES;

-- Ver estructura de la tabla
DESCRIBE lab3crud.products;
\\\

3. **Verificar permisos en Apache**
- Asegúrate de que \.htaccess\ está habilitado
- \mod_rewrite\ está activo

4. **Probar la API**
\\\ash
http://localhost/APIREST-DELEONFERRER/
\\\

##  Documentación de Endpoints

### Base URL
\\\
http://localhost/APIREST-DELEONFERRER
\\\

### 1 GET - Listar Todos los Productos

**Endpoint:**
\\\
GET /APIREST-DELEONFERRER/
\\\

**Ejemplo:**
\\\ash
curl http://localhost/APIREST-DELEONFERRER/
\\\

**Respuesta Exitosa (200):**
\\\json
{
    "success": true,
    "message": "Productos obtenidos correctamente",
    "data": [
        {
            "id": 1,
            "name": "Laptop",
            "description": "Laptop de alto rendimiento",
            "price": "899.99",
            "quantity": 5,
            "image": "laptop.jpg",
            "created_at": "2025-11-16 10:30:00",
            "updated_at": "2025-11-16 10:30:00"
        }
    ]
}
\\\

**Respuesta Sin Productos (404):**
\\\json
{
    "success": false,
    "message": "No hay productos disponibles"
}
\\\

---

### 2 GET - Obtener Producto por ID

**Endpoint:**
\\\
GET /APIREST-DELEONFERRER/?id=1
o
GET /APIREST-DELEONFERRER/1
\\\

**Ejemplo:**
\\\ash
curl "http://localhost/APIREST-DELEONFERRER/?id=1"
\\\

**Respuesta Exitosa (200):**
\\\json
{
    "success": true,
    "message": "Producto encontrado",
    "data": {
        "id": 1,
        "name": "Laptop",
        "description": "Laptop de alto rendimiento",
        "price": "899.99",
        "quantity": 5,
        "image": "laptop.jpg",
        "created_at": "2025-11-16 10:30:00",
        "updated_at": "2025-11-16 10:30:00"
    }
}
\\\

**Producto No Encontrado (404):**
\\\json
{
    "success": false,
    "message": "Producto no encontrado"
}
\\\

---

### 3 POST - Crear Nuevo Producto

**Endpoint:**
\\\
POST /APIREST-DELEONFERRER/
\\\

**Parámetros Requeridos:**
- \
ame\ (string) - Nombre del producto
- \price\ (float) - Precio del producto
- \quantity\ (int) - Cantidad disponible

**Parámetros Opcionales:**
- \description\ (string) - Descripción del producto
- \image\ (string) - URL o nombre de la imagen

**Métodos de Entrada:**

#### Opción 1: Query String  (Recomendado)
\\\ash
curl "http://localhost/APIREST-DELEONFERRER/?name=Mouse&price=25.50&quantity=100&description=Mouse%20inalámbrico"
\\\

#### Opción 2: JSON Body
\\\ash
curl -X POST http://localhost/APIREST-DELEONFERRER/ \\
  -H "Content-Type: application/json" \\
  -d '{
    "name": "Mouse",
    "price": 25.50,
    "quantity": 100,
    "description": "Mouse inalámbrico"
  }'
\\\

#### Opción 3: Form Data
\\\ash
curl -X POST http://localhost/APIREST-DELEONFERRER/ \\
  -F "name=Mouse" \\
  -F "price=25.50" \\
  -F "quantity=100" \\
  -F "description=Mouse inalámbrico"
\\\

**Respuesta Exitosa (201):**
\\\json
{
    "success": true,
    "message": "Producto creado exitosamente",
    "data": {
        "id": 2,
        "name": "Mouse",
        "description": "Mouse inalámbrico",
        "price": "25.50",
        "quantity": 100,
        "image": null,
        "created_at": "2025-11-16 11:00:00",
        "updated_at": "2025-11-16 11:00:00"
    }
}
\\\

**Campos Faltantes (400):**
\\\json
{
    "success": false,
    "message": "Campos requeridos faltantes",
    "campos_requeridos": ["name", "price", "quantity"]
}
\\\

---

### 4 PUT - Actualizar Producto

**Endpoint:**
\\\
PUT /APIREST-DELEONFERRER/?id=1
o
PUT /APIREST-DELEONFERRER/1
\\\

**Parámetros:**
- \id\ (int) - ID del producto a actualizar *(REQUERIDO)*
- \
ame\ (string) - Nuevo nombre (opcional)
- \price\ (float) - Nuevo precio (opcional)
- \quantity\ (int) - Nueva cantidad (opcional)
- \description\ (string) - Nueva descripción (opcional)
- \image\ (string) - Nueva imagen (opcional)

**Ejemplo con Query String:**
\\\ash
curl -X PUT "http://localhost/APIREST-DELEONFERRER/?id=1&name=Laptop%20Pro&price=1299.99&quantity=3"
\\\

**Ejemplo con URL Path:**
\\\ash
curl -X PUT "http://localhost/APIREST-DELEONFERRER/1?name=Laptop%20Pro&price=1299.99&quantity=3"
\\\

**Respuesta Exitosa (200):**
\\\json
{
    "success": true,
    "message": "Producto actualizado exitosamente",
    "data": {
        "id": 1,
        "name": "Laptop Pro",
        "description": "Laptop de alto rendimiento",
        "price": "1299.99",
        "quantity": 3,
        "image": "laptop.jpg",
        "created_at": "2025-11-16 10:30:00",
        "updated_at": "2025-11-16 11:15:00"
    }
}
\\\

**Sin ID (400):**
\\\json
{
    "success": false,
    "message": "ID requerido para actualizar"
}
\\\

**Producto No Encontrado (404):**
\\\json
{
    "success": false,
    "message": "Producto no encontrado"
}
\\\

---

##  Pruebas con Postman

### Setup en Postman

1. **Importar Colección** (opcional)
   - Crear una nueva colección llamada "APIREST-DELEONFERRER"

2. **Configurar Variables de Entorno**
   - \ase_url\: \http://localhost/APIREST-DELEONFERRER\

3. **Crear Requests**

#### GET - Listar Todo
\\\
Method: GET
URL: {{base_url}}/
\\\

#### GET - Por ID
\\\
Method: GET
URL: {{base_url}}/?id=1
\\\

#### POST - Crear
\\\
Method: POST
URL: {{base_url}}/
Params:
  - name: Mouse
  - price: 25.50
  - quantity: 100
  - description: Mouse inalámbrico
\\\

#### PUT - Actualizar
\\\
Method: PUT
URL: {{base_url}}/?id=1
Params:
  - name: Laptop Pro
  - price: 1299.99
  - quantity: 3
\\\

##  Seguridad

La API implementa varias medidas de seguridad:

 **SQL Injection Protection** - PDO Prepared Statements
\\\php
\ = \->db->prepare("SELECT * FROM products WHERE id = ?");
\->execute([\]);
\\\

 **XSS Protection** - htmlspecialchars() y strip_tags()
\\\php
\ = htmlspecialchars(strip_tags(\['name']));
\\\

 **CORS Configurado**
\\\php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
\\\

 **Type Casting**
\\\php
\ = (int)\['id']; // Asegurar que sea entero
\\\

##  Solución de Problemas

### Error 404 - API no encontrada
\\\
Solución:
1. Verifica que mod_rewrite esté habilitado en Apache
2. Asegúrate que .htaccess existe en la raíz
3. Reinicia Apache
\\\

### Error 503 - Database connection error
\\\
Solución:
1. Verifica que MySQL esté corriendo
2. Confirma las credenciales en config/database.php
3. Verifica que la BD lab3crud existe
\\\

### Error 400 - Campos requeridos faltantes
\\\
Solución:
1. POST/PUT requieren: name, price, quantity
2. Usa la sintaxis correcta: ?name=valor&price=valor&quantity=valor
3. URL encode los espacios: Mouse%20Gaming
\\\

### El ID no se extrae del query string
\\\
Solución:
1. Usa ?id=1 al final de la URL
2. O usa la ruta: /1 sin query string
3. Ambos formatos son soportados
\\\

##  Esquema de Base de Datos

\\\sql
CREATE TABLE products (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
\\\

##  Optimizaciones Implementadas

| Optimización | Descripción |
|-------------|-------------|
| **Triple Input Handling** | Acepta datos de JSON body, form-data o query strings |
| **ID Extraction** | Busca ID en URL path (/1) y query string (?id=1) |
| **Data Filtering** | Filtra automáticamente el ID de los datos cuando corresponde |
| **Error Responses** | Mensajes claros con campos requeridos listados |
| **HTTP Status Codes** | 200, 201, 400, 404, 405, 503 apropiados para cada caso |

##  Ejemplo de Flujo Completo

\\\ash
# 1. Listar productos existentes
curl http://localhost/APIREST-DELEONFERRER/

# 2. Crear un nuevo producto
curl "http://localhost/APIREST-DELEONFERRER/?name=Teclado&price=75.00&quantity=50"

# 3. Obtener el producto creado (id=3)
curl "http://localhost/APIREST-DELEONFERRER/?id=3"

# 4. Actualizar el producto
curl -X PUT "http://localhost/APIREST-DELEONFERRER/?id=3&name=Teclado%20Mecánico&price=99.99"

# 5. Verificar cambios
curl "http://localhost/APIREST-DELEONFERRER/?id=3"

# 6. Listar todos nuevamente
curl http://localhost/APIREST-DELEONFERRER/
\\\

##  Autor

**De León Ferrer** - Estudiante de Desarrollo Web

- GitHub: [@luzdl](https://github.com/luzdl)
- Email: deleonferrer@example.com

##  Licencia

Este proyecto está bajo la licencia MIT. Ver \LICENSE\ para más detalles.

##  Contribuciones

¡Las contribuciones son bienvenidas! Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (\git checkout -b feature/AmazingFeature\)
3. Commit tus cambios (\git commit -m 'Add some AmazingFeature'\)
4. Push a la rama (\git push origin feature/AmazingFeature\)
5. Abre un Pull Request

##  Si te fue útil, considera dar una estrella al repositorio!

---

**Última actualización:** Noviembre 16, 2025  
**Versión:** 1.0.0
