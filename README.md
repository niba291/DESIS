
### VERSIONES

| Herramientas  | Versiones         | 
| :--------     | :-------          | 
| `PHP`         | `8.2.12`          | 
| `MariaDB`     | `10.4.32-MariaDB` | 
___________________________________________________________________________________________________________________

### PASO A SEGUIR

`Paso 1`: Instalar Xampp para ejecutar un ambiente en PHP y la base de dato.

`Paso 2`: Clonar el proyecto de Github (https://github.com/niba291/DESIS) a la carpeta de Xampp/htdocs.

`Paso 3`: Iniciar los servicios de Apache y MySql de Xampp.

`Paso 4`: Abrir la carpeta SQL para importar el script a la base de dato o ejecutar el script migrate.php 
(http://localhost/desis/backend/migrate.php).

`Paso 5`: Abrir el navegador con la siguiente ruta (http://localhost/desis/frontend).

___________________________________________________________________________________________________________________

### INFORMACIÓN

Se ha creado 3 carpetas (backend - frontend - SQL), donde en el backend esta toda la lógica con PHP y se usa como 
API, frontend la vista con html y javascript donde el JS se hizo modular y SQL la base de dato.
___________________________________________________________________________________________________________________

#### backend
Tiene la siguiente estructuración.

- src
    - controller
    - model
    - utils

`src` : está el proyecto y las variables de entorno (.env), se ejecuta primero el index.php para el funcionamiento del 
programa.

`controller`: es un canal de comunicación de index y los modelos, acá se hace la mayor parte de lógica.

`model`: es la comunicación de la programación y base de datos.

`utils`: son herramientas que se utilizan en todas parte, por ejemplo el conector de la base de datos, etc.
___________________________________________________________________________________________________________________

### frontend
tiene la siguiente estructuración.

- src
    - js 
    - utils

`src`: para globalizar la carpetas del proyecto.

`js`: son los script de js en esta parte son mayormente de lógica frontend

`utils`: son herramientas que se utilizan en todas parte.
___________________________________________________________________________________________________________________

### SQL

Tiene un archivo llamado desis.sql, para importar la base de dato.
