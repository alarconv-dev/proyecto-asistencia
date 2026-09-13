<?php

/**
 * Este controller NO exige login: el estudiante entra por el link/QR
 * que contiene el token único de la sesión.
 */
class AsistenciaController
{
    public function mostrarFormulario(string $token): void
    {
        $sesion = SesionClase::obtenerPorToken($token);

        if (!$sesion) {
            http_response_code(404);
            echo "Este enlace no es válido.";
            return;
        }

        if (in_array($sesion['estado'], ['cerrada', 'cancelada'], true)) {
            require BASE_PATH . '/app/views/asistencia/cerrada.php';
            return;
        }

        require BASE_PATH . '/app/views/asistencia/formulario.php';
    }

    public function registrar(string $token): void
    {
        $sesion = SesionClase::obtenerPorToken($token);

        if (!$sesion) {
            http_response_code(404);
            echo "Este enlace no es válido.";
            return;
        }

        if (in_array($sesion['estado'], ['cerrada', 'cancelada'], true)) {
            require BASE_PATH . '/app/views/asistencia/cerrada.php';
            return;
        }

        $codigo = trim($_POST['codigo_estudiante'] ?? '');
        $estudiante = Estudiante::obtenerPorCodigo($codigo);

        if (!$estudiante) {
            $error = 'No encontramos ese código en el sistema. Verifica con tu profesor.';
            require BASE_PATH . '/app/views/asistencia/formulario.php';
            return;
        }

        // Confirma que el estudiante esté matriculado en el curso de esta sesión
        $matriculados = Estudiante::obtenerPorCurso((int) $sesion['curso_id']);
        $estaMatriculado = false;
        foreach ($matriculados as $m) {
            if ((int) $m['id'] === (int) $estudiante['id']) {
                $estaMatriculado = true;
                break;
            }
        }

        if (!$estaMatriculado) {
            $error = 'Tu código no está matriculado en este curso.';
            require BASE_PATH . '/app/views/asistencia/formulario.php';
            return;
        }

        if (Asistencia::yaRegistrado((int) $sesion['id'], (int) $estudiante['id'])) {
            $error = 'Ya registraste tu asistencia para esta sesión.';
            require BASE_PATH . '/app/views/asistencia/formulario.php';
            return;
        }

        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $userAgent = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255);

        Asistencia::registrar((int) $sesion['id'], (int) $estudiante['id'], $ip, $userAgent);

        require BASE_PATH . '/app/views/asistencia/gracias.php';
    }
}
