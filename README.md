# Sistema de Control de Asistencia

Proyecto en PHP + MySQL, pensado para XAMPP.

## Instalación

### 1. Copiar el proyecto
Copia toda la carpeta `proyecto-asistencia` dentro de `htdocs` de tu XAMPP.
Ejemplo en Windows: `C:\xampp\htdocs\proyecto-asistencia`

### 2. Crear la base de datos
1. Abre phpMyAdmin (`http://localhost/phpmyadmin`).
2. Crea una base de datos llamada `control_asistencia` (cotejamiento `utf8mb4_general_ci`).
3. Entra a esa base de datos, ve a la pestaña **Importar**, y selecciona el archivo
   `database/control_asistencia.sql` de este proyecto.
4. Esto crea todas las tablas, el trigger que calcula asistencia/tardanza/ausencia,
   el evento programado, y la vista de resumen.

### 3. Activar el Event Scheduler (opcional pero recomendado)
Para que las sesiones vencidas se cierren automáticamente incluso si nadie
entra al sistema, ejecuta esto una vez en phpMyAdmin (pestaña SQL):

```sql
SET GLOBAL event_scheduler = ON;
```

Si tu XAMPP no lo permite o se reinicia, no hay problema: el sistema también
revisa y cierra sesiones vencidas cada vez que el profesor entra a un curso
o un estudiante abre el formulario (ver `SesionClase::cerrarVencidas()`).

### 4. Configurar la conexión
Abre `app/config/Database.php` y confirma usuario/clave de tu MySQL
(en XAMPP por defecto es usuario `root` sin contraseña, ya viene así).

Abre `app/config/config.php` y ajusta `BASE_URL` según tu carpeta real, ejemplo:
```php
define('BASE_URL', 'http://localhost/proyecto-asistencia/public');
```

### 5. Crear tu primer profesor
1. Abre `public/crear_profesor.php` en un editor y cambia nombres, usuario y contraseña.
2. Entra a `http://localhost/proyecto-asistencia/public/crear_profesor.php` en el navegador.
3. **Borra ese archivo** apenas veas el mensaje de éxito (por seguridad).

### 6. Entrar al sistema
Ve a `http://localhost/proyecto-asistencia/public/login` e inicia sesión con
el usuario y contraseña que creaste.

## Flujo de uso

1. El profesor crea un curso.
2. Dentro del curso, agrega estudiantes (por código, nombre, apellido).
3. El profesor crea una "sesión de clase" indicando fecha y los 3 horarios:
   inicio, límite para "asistió", límite para "tardanza".
4. El sistema genera un enlace único (y su QR) para esa sesión.
5. El profesor comparte ese enlace/QR con los estudiantes (proyectado en clase, por ejemplo).
6. Cada estudiante entra al enlace, escribe su código, y el sistema decide
   automáticamente si es "asistió", "tardanza" o "ausente" según la hora de envío.
7. Los que nunca abren el enlace quedan como "ausente" en cuanto vence el tiempo.

## Seguridad ya incluida

- Contraseñas de profesor con `password_hash` (bcrypt).
- Prepared statements en todas las consultas (protección contra inyección SQL).
- Cada curso/estudiante/sesión se filtra siempre por `profesor_id`, para que
  un profesor jamás pueda ver ni modificar datos de otro.
- Enlace de asistencia con token aleatorio de 32 caracteres (no adivinable).
- Límite de 5 intentos de login fallidos por usuario+IP cada 15 minutos.
- `htmlspecialchars()` en toda salida hacia el HTML (protección contra XSS).
