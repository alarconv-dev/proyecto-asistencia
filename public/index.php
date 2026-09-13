<?php

session_start();

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/app/config/config.php';
require BASE_PATH . '/app/config/Database.php';
require BASE_PATH . '/app/core/Router.php';
require BASE_PATH . '/app/core/Auth.php';

// Autoload simple: busca la clase primero en models, luego en controllers
spl_autoload_register(function (string $clase) {
    $rutasPosibles = [
        BASE_PATH . '/app/models/' . $clase . '.php',
        BASE_PATH . '/app/controllers/' . $clase . '.php',
    ];

    foreach ($rutasPosibles as $ruta) {
        if (file_exists($ruta)) {
            require $ruta;
            return;
        }
    }
});

$router = new Router();

// ----- Autenticación -----
$router->get('/login', 'AuthController', 'mostrarLogin');
$router->post('/login', 'AuthController', 'procesarLogin');
$router->get('/logout', 'AuthController', 'logout');

// ----- Dashboard -----
$router->get('/', 'DashboardController', 'index');

// ----- Profesores (gestión interna, solo accesible ya logueado) -----
$router->get('/profesores', 'ProfesorController', 'index');
$router->get('/profesores/crear', 'ProfesorController', 'mostrarCrear');
$router->post('/profesores/crear', 'ProfesorController', 'crear');

// ----- Perfil propio -----
$router->get('/perfil/password', 'PerfilController', 'mostrarCambiarPassword');
$router->post('/perfil/password', 'PerfilController', 'cambiarPassword');

// ----- Cursos -----
$router->get('/cursos', 'CursoController', 'index');
$router->get('/cursos/crear', 'CursoController', 'mostrarCrear');
$router->post('/cursos/crear', 'CursoController', 'crear');
$router->get('/cursos/editar/{id}', 'CursoController', 'mostrarEditar');
$router->post('/cursos/editar/{id}', 'CursoController', 'editar');
$router->post('/cursos/eliminar/{id}', 'CursoController', 'eliminar');
$router->get('/cursos/detalle/{id}', 'CursoController', 'detalle');

// ----- Estudiantes dentro de un curso -----
$router->post('/cursos/{id}/estudiantes/agregar', 'EstudianteController', 'agregar');
$router->post('/cursos/{id}/estudiantes/eliminar/{estudiante_id}', 'EstudianteController', 'eliminar');
$router->get('/cursos/{id}/estudiantes/editar/{estudiante_id}', 'EstudianteController', 'mostrarEditar');
$router->post('/cursos/{id}/estudiantes/editar/{estudiante_id}', 'EstudianteController', 'editar');

// ----- Sesiones de clase -----
$router->get('/cursos/{id}/sesiones/crear', 'SesionController', 'mostrarCrear');
$router->post('/cursos/{id}/sesiones/crear', 'SesionController', 'crear');
$router->get('/cursos/{id}/sesiones/{sesion_id}', 'SesionController', 'detalle');

// ----- Formulario público de asistencia (el estudiante entra sin login, vía token) -----
$router->get('/asistencia/{token}', 'AsistenciaController', 'mostrarFormulario');
$router->post('/asistencia/{token}', 'AsistenciaController', 'registrar');

// Descuenta la carpeta donde vive index.php (ej: /proyecto-asistencia/public)
// para que el router compare solo la parte que sí definimos en las rutas.
$carpetaBase = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($carpetaBase !== '' && strpos($uri, $carpetaBase) === 0) {
    $uri = substr($uri, strlen($carpetaBase));
}

// Si abren index.php directamente (sin .htaccess/mod_rewrite), también lo descuenta
$uri = preg_replace('#/index\.php$#', '', $uri);

$uri = rtrim($uri, '/');
if ($uri === '' || $uri === false) {
    $uri = '/';
}

$router->despachar($uri, $_SERVER['REQUEST_METHOD']);
