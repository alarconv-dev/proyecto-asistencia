<?php

/**
 * Permite que un profesor YA logueado registre a otros profesores.
 * Así no queda pública la creación de cuentas, pero tampoco depende
 * de editar un script a mano cada vez.
 */
class ProfesorController
{
    public function __construct()
    {
        Auth::verificarLogin();
        if (!Auth::esAdmin()) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }
    }

    public function index(): void
    {
        $profesores = Profesor::listarTodos();
        require BASE_PATH . '/app/views/profesores/index.php';
    }

    public function mostrarCrear(): void
    {
        $error = $_SESSION['error_profesor'] ?? null;
        unset($_SESSION['error_profesor']);
        require BASE_PATH . '/app/views/profesores/crear.php';
    }

    public function crear(): void
    {
        $nombres   = trim($_POST['nombres'] ?? '');
        $apellidos = trim($_POST['apellidos'] ?? '');
        $correo    = trim($_POST['correo'] ?? '');
        $usuario   = trim($_POST['usuario'] ?? '');
        $password  = $_POST['password'] ?? '';
        $password2 = $_POST['password_confirmar'] ?? '';

        if ($nombres === '' || $apellidos === '' || $correo === '' || $usuario === '' || $password === '') {
            $_SESSION['error_profesor'] = 'Todos los campos son obligatorios.';
            header('Location: ' . BASE_URL . '/profesores/crear');
            exit;
        }

        if (strlen($password) < 8) {
            $_SESSION['error_profesor'] = 'La contraseña debe tener al menos 8 caracteres.';
            header('Location: ' . BASE_URL . '/profesores/crear');
            exit;
        }

        if ($password !== $password2) {
            $_SESSION['error_profesor'] = 'Las contraseñas no coinciden.';
            header('Location: ' . BASE_URL . '/profesores/crear');
            exit;
        }

        if (Profesor::existeUsuarioOCorreo($usuario, $correo)) {
            $_SESSION['error_profesor'] = 'Ese usuario o correo ya está registrado.';
            header('Location: ' . BASE_URL . '/profesores/crear');
            exit;
        }

        Profesor::crear([
            'nombres'  => $nombres,
            'apellidos' => $apellidos,
            'correo'   => $correo,
            'usuario'  => $usuario,
            'password' => $password,
        ]);

        header('Location: ' . BASE_URL . '/profesores');
        exit;
    }
}
