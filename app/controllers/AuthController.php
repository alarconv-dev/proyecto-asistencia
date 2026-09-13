<?php

class AuthController
{
    public function mostrarLogin(): void
    {
        if (Auth::profesorActualId()) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        $error = $_SESSION['error_login'] ?? null;
        unset($_SESSION['error_login']);

        require BASE_PATH . '/app/views/auth/login.php';
    }

    public function procesarLogin(): void
    {
        $usuario  = trim($_POST['usuario'] ?? '');
        $password = $_POST['password'] ?? '';
        $ip       = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

        // Máximo 5 intentos fallidos por usuario+IP en 15 minutos
        if (IntentoLogin::contarFallidosRecientes($usuario, $ip) >= 5) {
            $_SESSION['error_login'] = 'Demasiados intentos fallidos. Intenta de nuevo en unos minutos.';
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $profesor = Profesor::obtenerPorUsuario($usuario);

        if ($profesor && password_verify($password, $profesor['password_hash'])) {
            IntentoLogin::registrar($usuario, $ip, true);
            Auth::iniciarSesion($profesor);
            Profesor::actualizarUltimoLogin((int) $profesor['id']);
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        IntentoLogin::registrar($usuario, $ip, false);
        $_SESSION['error_login'] = 'Usuario o contraseña incorrectos.';
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    public function logout(): void
    {
        Auth::cerrarSesion();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}
