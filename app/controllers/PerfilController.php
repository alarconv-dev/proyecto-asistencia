<?php

/**
 * Acciones sobre la cuenta del propio profesor logueado (no sobre otros).
 */
class PerfilController
{
    public function __construct()
    {
        Auth::verificarLogin();
    }

    public function mostrarCambiarPassword(): void
    {
        $error = $_SESSION['error_password'] ?? null;
        $exito = $_SESSION['exito_password'] ?? null;
        unset($_SESSION['error_password'], $_SESSION['exito_password']);

        require BASE_PATH . '/app/views/perfil/cambiar_password.php';
    }

    public function cambiarPassword(): void
    {
        $actual    = $_POST['password_actual'] ?? '';
        $nueva     = $_POST['password_nueva'] ?? '';
        $confirmar = $_POST['password_confirmar'] ?? '';

        $profesor = Profesor::obtenerPorId(Auth::profesorActualId());

        if (!$profesor || !password_verify($actual, $profesor['password_hash'])) {
            $_SESSION['error_password'] = 'La contraseña actual no es correcta.';
            header('Location: ' . BASE_URL . '/perfil/password');
            exit;
        }

        if (strlen($nueva) < 8) {
            $_SESSION['error_password'] = 'La nueva contraseña debe tener al menos 8 caracteres.';
            header('Location: ' . BASE_URL . '/perfil/password');
            exit;
        }

        if ($nueva !== $confirmar) {
            $_SESSION['error_password'] = 'La nueva contraseña y su confirmación no coinciden.';
            header('Location: ' . BASE_URL . '/perfil/password');
            exit;
        }

        if ($actual === $nueva) {
            $_SESSION['error_password'] = 'La nueva contraseña debe ser distinta a la actual.';
            header('Location: ' . BASE_URL . '/perfil/password');
            exit;
        }

        Profesor::actualizarPassword((int) $profesor['id'], $nueva);

        $_SESSION['exito_password'] = 'Tu contraseña se actualizó correctamente.';
        header('Location: ' . BASE_URL . '/perfil/password');
        exit;
    }
}
