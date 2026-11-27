# BookManager

Sistema de gestión de librería (CRUD de Tiendas y Títulos) hecho con PHP 8 orientado a objetos, PDO con sentencias preparadas, MySQL y la plantilla SB Admin (Bootstrap 5).

## Estructura

- `config/` conexión PDO (`database.php`) y arranque de la app (`app.php`)
- `models/` clases `Tienda` y `Titulo`
- `views/` vistas de Tiendas y Títulos (listar, crear, editar, eliminar)
- `includes/` `header.php` y `footer.php` compartidos
- `assets/` CSS y JS de la plantilla
- `database/db_libreria.sql` base de datos del profesor

## Instalación local (XAMPP)

1. Copiar la carpeta a `C:\xampp\htdocs\bookmanager`.
2. Crear la base `dblibreria` en phpMyAdmin e importar `database/db_libreria.sql`.
3. Abrir `http://localhost/bookmanager/`.

## Despliegue (InfinityFree)

Editar el bloque `else` de `config/database.php` con host, base, usuario y contraseña del panel. Las credenciales reales no se suben al repositorio.
