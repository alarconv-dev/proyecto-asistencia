<?php

/**
 * Middleware de autenticación. Se usa dentro de los constructores
 * de los controllers que requieren que el profesor haya iniciado sesión.
 */
class Auth
{
    public static function verificarLogin()
    {
        if (!isset($_SESSION['profesor_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    public static function iniciarSesion(array $profesor)
    {
        // Regenerar el ID de sesión al hacer login previene fijación de sesión
        session_regenerate_id(true);
        $_SESSION['profesor_id'] = $profesor['id'];
        $_SESSION['profesor_nombre'] = $profesor['nombres'] . ' ' . $profesor['apellidos'];
        $_SESSION['rol']=$profesor['rol']??'profesor';
    }

    public static function cerrarSesion()
    {
        $_SESSION = [];
        session_destroy();
    }

    public static function profesorActualId()
    {
        return $_SESSION['profesor_id'] ?? null;
    }

    public static function profesorActualNombre()
    {
        return $_SESSION['profesor_nombre'] ?? null;
    }

    public static function esAdmin()
    {
        return isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
    }

    public static function esProfesor()
    {
        return isset($_SESSION['rol']) && $_SESSION['rol'] === 'profesor';
    }
}
